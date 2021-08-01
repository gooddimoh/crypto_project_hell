<?php

namespace Packages\Payments\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Packages\Payments\Events\DepositCompleted;
use Packages\Payments\Http\Requests\Frontend\StoreDeposit;
use Packages\Payments\Http\Requests\Frontend\UpdateDeposit;
use Packages\Payments\Models\Deposit;
use Packages\Payments\Models\DepositMethod;
use Packages\Payments\Models\Sort\Frontend\DepositSort;
use Packages\Payments\Services\CoinpaymentsPaymentService;
use Packages\Payments\Services\DepositService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Packages\Payments\Services\PaymentService;

class DepositController extends Controller
{
    /**
     * Deposits listing
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $account = $request->user()->account;
        $sort = new DepositSort($request);

        $deposits = Deposit::where('account_id', '=', $account->id)
            ->with('method:id,name')
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('payments::frontend.pages.deposits.index', [
            'deposits'      => $deposits,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    public function show(Request $request, Deposit $deposit, CoinpaymentsPaymentService $coinpaymentsPaymentService)
    {
        $user = $request->user();

        if ($deposit->account->id != $user->account->id || $deposit->status != Deposit::STATUS_PENDING)
            abort(404);

        $payment = $coinpaymentsPaymentService->getPaymentInfo($deposit->external_id);

        return view('payments::frontend.pages.deposits.show', [
            'deposit' => $deposit,
            'payment' => $payment,
        ]);
    }

    /**
     * Display deposit page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $methods = DepositMethod::enabled()
            ->with('gateway')
            ->orderBy('id')
            ->get()
            ->map(function ($method) {
                if ($method->gateway) {
                    $method->gateway->append('payment_currencies');
                }
                return $method;
            });

        return view('payments::frontend.pages.deposits.create', [
            'props' => [
                'account' => $request->user()->account,
                'config' => [
                    'deposit_min' => config('payments.deposit_min'),
                    'deposit_max' => config('payments.deposit_max'),
                    'stripe' => [
                        'public_key' => config('payments.stripe.public_key')
                    ]
                ],
                'methods' => $methods,
                'user' => $request->user()->only(['name', 'email'])
            ]
        ]);
    }

    public function store(StoreDeposit $request, DepositMethod $depositMethod)
    {
        // if deposit method is linked to some payment gateway
        if ($depositMethod->gateway) {
            $request->merge(['user' => (object)$request->user()->toArray()]);

            // instantiate payment service
            $paymentService = PaymentService::createFromModel($depositMethod->gateway);

            // initialize payment
            $paymentService->createPayment($request->all());

            // if request is not successful log it and return an error message
            if (!$paymentService->isResponseSuccessful() && !$paymentService->isResponseRedirect()) {
                Log::error($paymentService->getResponseData());

                return back()->withInput()->withErrors($paymentService->getResponseMessage());
            }

            // request was successful => make a new deposit model
            $deposit = DepositService::create([
                'account'           => $request->user()->account,
                'method'            => $depositMethod,
                'external_id'       => $paymentService->getTransactionReference() ?: NULL,
                'amount'            => $request->amount,
                'payment_amount'    => $paymentService->getPaymentAmount(),
                'payment_currency'  => $paymentService->getPaymentCurrency(),
                'parameters'        => $paymentService->getPaymentParameters(),
                'response'          => $paymentService->getResponseData() ? [$paymentService->getResponseData()] : NULL,
                'status'            => $paymentService->isResponseSuccessful() ? Deposit::STATUS_COMPLETED : Deposit::STATUS_CREATED,
            ]);

            // payment is completed
            if ($paymentService->isResponseSuccessful()) {
                event(new DepositCompleted($deposit));

                return redirect()->route('frontend.deposits.index')->with('success', __('Deposit is successfully completed.'));
            // payment requires further action
            } elseif ($paymentService->isResponseRedirect()) {
                return $paymentService->isExternalRedirect()
                    ? redirect()->away($paymentService->getRedirectUrl())
                    : redirect()->route('frontend.deposits.complete', $deposit);
            }
        // manual deposit processing
        } else {
            DepositService::create([
                'account'       => $request->user()->account,
                'method'        => $depositMethod,
                'amount'        => $request->amount,
                'parameters'    => $request->parameters,
            ]);

            return redirect()->route('frontend.deposits.index')->with('success', __('Deposit is successfully created.'));
        }
    }

    public function complete(Request $request, Deposit $deposit)
    {
        if($request->user()->account->id != $deposit->account_id
            || !$deposit->is_created
            || !$deposit->method->gateway
            || !in_array($deposit->method->gateway->code, ['coinpayments', 'ethereum', 'bsc'])) {
            return redirect()->route('frontend.deposits.index')->withErrors(__('Deposit is not found or expired.'));
        }

        return view('payments::frontend.pages.deposits.complete', [
            'props' => [
                'config' => [
                    'ethereum' => config('payments.ethereum'),
                ],
                'deposit' => $deposit
            ]
        ]);
    }

    public function update(UpdateDeposit $request, DepositMethod $depositMethod, Deposit $deposit)
    {
        if (in_array($depositMethod->code, ['metamask', 'bsc'])) {
            $deposit->update([
                'external_id'   => $request->transaction_id,
                'status'        => Deposit::STATUS_PENDING
            ]);
        }

        return ['success' => TRUE];
    }

    /**
     * Handle async events (webhooks setup is required)
     *
     * @param Request $request
     */
    public function ipn(Request $request, CoinpaymentsPaymentService $coinpaymentsPaymentService)
    {
        $payload = $request->getContent();
        Log::info($payload);

        // HMAC header should always be set
        if ($request->header('HMAC')) {
            if ($request->ipn_mode == 'hmac' && $request->merchant == config('payments.coinpayments.merchant_id')) {
                // verify stripe signature to ensure the request is authentic
                if ($coinpaymentsPaymentService->signatureIsValid($payload, $request->header('HMAC'))) {
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
                        $depositService = new DepositService($request->txn_id);
                        $depositService->complete();
                    }

                    return response()->make('OK', 200);
                }
            }
        }

        // report an error
        return response()->make('ERROR', 400);
    }
}
