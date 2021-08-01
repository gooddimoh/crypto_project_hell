<?php

namespace Packages\Payments\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Packages\Payments\Events\DepositCancelled;
use Packages\Payments\Events\DepositCompleted;
use Packages\Payments\Events\WithdrawalCancelled;
use Packages\Payments\Events\WithdrawalCompleted;
use Packages\Payments\Models\Deposit;
use Packages\Payments\Models\PaymentGateway;
use Packages\Payments\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Packages\Payments\Services\PaymentService;

class WebhookController extends Controller
{
    public function completePayment(Request $request, PaymentGateway $paymentGateway)
    {
        Log::info(json_encode(array_merge(['gateway' => $paymentGateway->code], $request->all())));

        $paymentService = PaymentService::createFromModel($paymentGateway);

        abort_if($request->action == 'complete' && !$this->requiredParamsPresent($request, $paymentService->getCompletePaymentParameters()), 404);
        abort_if($request->action == 'cancel' && !$this->requiredParamsPresent($request, $paymentService->getCancelPaymentParameters()), 404);

        // get deposit by external ID and ensure it's still in created state
        $deposit = Deposit::where('external_id', $request->{$paymentService->getTransactionReferenceParameterName()})
            ->created()
            ->firstOrFail();

        $request->merge(['amount' => $deposit->payment_amount, 'currency' => $deposit->payment_currency]);

        if ($request->action == 'complete') {
            $paymentService->completePayment($request->all());

            // deposit completed
            if ($paymentService->isResponseSuccessful()) {
                $deposit->update([
                    'status'    => Deposit::STATUS_COMPLETED,
                    'response'  => array_merge($deposit->response, [$paymentService->getResponseData()])
                ]);

                event(new DepositCompleted($deposit));

                return redirect()->route('frontend.deposits.index')->with('success', __('Deposit is successfully completed.'));
            // there was some error when completing the deposit
            } else {
                $deposit->update([
                    'status' => Deposit::STATUS_CANCELLED,
                    'response' => array_merge($deposit->response, [$paymentService->getResponseData()])
                ]);

                return redirect()->route('frontend.deposits.index')->withErrors(__('There was some error while processing this deposit.'));
            }
        // deposit is cancelled
        } elseif ($request->action == 'cancel') {
            $deposit->update(['status' => Deposit::STATUS_CANCELLED]);

            event(new DepositCancelled($deposit));

            return redirect()->route('frontend.deposits.index')->withErrors(__('Deposit is cancelled.'));
        }

        return redirect()->route('frontend.deposits.index');
    }

    public function ipn(Request $request, PaymentGateway $paymentGateway)
    {
        $payload = $request->getContent();
        Log::info($payload);

        $paymentService = PaymentService::createFromModel($paymentGateway);

        // HMAC header should always be set for coinpayments
        if ($paymentGateway->code == 'coinpayments' && $request->ipn_mode == 'hmac' && $request->header('HMAC') && $request->merchant == config('payments.coinpayments.merchant_id')) {
            // verify coinpayments signature to ensure the request is authentic
            if ($paymentService->isSignatureValid($payload, $request->header('HMAC'))) {
                // deposit
                if ($request->ipn_type == 'api') {
                    // https://www.coinpayments.net/merchant-tools-ipn#statuses
                    /*Payments will post with a 'status' field, here are the currently defined values:
                    -2 = PayPal Refund or Reversal
                    -1 = Cancelled / Timed Out
                    0 = Waiting for buyer funds
                    1 = We have confirmed coin reception from the buyer
                    2 = Queued for nightly payout (if you have the Payout Mode for this coin set to Nightly)
                    3 = PayPal Pending (eChecks or other types of holds)
                    100 = Payment Complete. We have sent your coins to your payment address or 3rd party payment system reports the payment complete
                    For future-proofing your IPN handler you can use the following rules:
                    <0 = Failures/Errors
                    0-99 = Payment is Pending in some way
                    >=100 = Payment completed successfully*/
                    if ($request->status >= 100 || $request->status == 2) {
                        $deposit = Deposit::where('external_id', $request->txn_id)->created()->first();

                        if ($deposit) {
                            $deposit->update([
                                'status' => Deposit::STATUS_COMPLETED,
                                'response' => array_merge($deposit->response, [$request->all()])
                            ]);

                            event(new DepositCompleted($deposit));
                        }
                    }

                    return response()->make('OK', 200);
                // withdrawal request
                } elseif ($request->ipn_type == 'withdrawal') {
                    // https://www.coinpayments.net/merchant-tools-ipn#statuses
                    if ($request->status >= 100 || $request->status == 2) {
                        $withdrawal = Withdrawal::where('external_id', $request->id)->first();

                        if ($withdrawal) {
                            $withdrawal->update([
                                'status' => Withdrawal::STATUS_COMPLETED,
                                'payment_amount' => $request->amount,
                                'response' => array_merge($withdrawal->response, [$request->all()])
                            ]);

                            event(new WithdrawalCompleted($withdrawal));
                        }
                    } elseif ($request->status == -1) {
                        $withdrawal = Withdrawal::where('external_id', $request->id)->first();

                        if ($withdrawal) {
                            $withdrawal->update([
                                'status' => Withdrawal::STATUS_CANCELLED,
                                'response' => array_merge($withdrawal->response, [$request->all()])
                            ]);

                            event(new WithdrawalCancelled($withdrawal));
                        }
                    }

                    return response()->make('OK', 200);
                }
            } else {
                Log::error(sprintf('Request signature is not valid, HMAC: %s', $request->header('HMAC')));
            }
        }

        // report an error
        return response()->make('ERROR', 400);
    }

    private function requiredParamsPresent (Request $request, array $keys) {
        $req = $request->all();

        foreach ($keys as $key) {
            if (!array_key_exists($key, $req)) {
                return FALSE;
            }
        }

        return TRUE;
    }
}
