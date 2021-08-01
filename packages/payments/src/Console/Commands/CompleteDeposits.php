<?php

namespace Packages\Payments\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Packages\Payments\Events\DepositCompleted;
use Packages\Payments\Helpers\Ethereum;
use Packages\Payments\Models\Deposit;
use Packages\Payments\Services\PaymentService;

class CompleteDeposits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deposits:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete pending deposits';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $methods = [];
        // check that API key is specified in the settings
        if (config('payments.ethereum.api_key')) {
            $methods[] = 'metamask';
        }

        if (config('payments.bsc.api_key')) {
            $methods[] = 'bsc';
        }

        if (!empty($methods)) {

            // get pending deposits
            $deposits = Deposit::pending()
                ->whereNotNull('external_id')
                ->with('method')
                ->whereHas('method', function ($query) use ($methods) {
                    $query->whereIn('code', $methods);
                })
                ->get();

            foreach ($deposits as $deposit) {
                try {
                    Log::info(sprintf('Complete deposit #%d, %f %s (%s wei) = %d credits', $deposit->id, $deposit->payment_amount, $deposit->payment_currency, $deposit->payment_amount_wei, $deposit->amount));

                    // instantiate payment service
                    $paymentService = PaymentService::createFromModel($deposit->method->gateway);

                    $paymentService->fetchTransaction($deposit->external_id);

                    // request is successful
                    if ($paymentService->isResponseSuccessful()) {
                        $transaction = $paymentService->getResponseData();

                        // ERC20 token transaction
                        if (isset($deposit->parameters->contractAddress)) {
                            $input = $transaction->input;

                            if (strlen($input) == 138) {
                                $method = substr($input, 0, 10);
                                $addressTo = substr($input, 10, 64);
                                $value = substr($input, 74, 64);
                                $paddedDepositAddressTo = str_pad(substr($deposit->parameters->addressTo, 2), 64, '0', STR_PAD_LEFT);
                                $paddedDepositPaymentAmount = Ethereum::fromWeiToPaddedHex($deposit->payment_amount_wei);

                                // check transaction parameters
                                if ($method == '0xa9059cbb'
                                    && strtolower($transaction->from) == strtolower($deposit->parameters->addressFrom)
                                    && strtolower($addressTo) == strtolower($paddedDepositAddressTo)
                                    && $value == $paddedDepositPaymentAmount) {
                                    // mark deposit as completed
                                    $deposit->update(['status' => Deposit::STATUS_COMPLETED]);
                                    event(new DepositCompleted($deposit));

                                    Log::info(sprintf('SUCCESS'));
                                } else {
                                    Log::info(sprintf(
                                        'FROM match: %s, TO match: %s, AMOUNT match: %s, %s, %s',
                                        (int)(strtolower($transaction->from) == strtolower($deposit->parameters->addressFrom)),
                                        (int)(strtolower($addressTo) == strtolower($paddedDepositAddressTo)),
                                        (int)($value == $paddedDepositPaymentAmount),
                                        $value,
                                        $paddedDepositPaymentAmount
                                    ));
                                }

                            } else {
                                Log::info(sprintf('TRX ERROR: input length is incorrect %d', strlen($input)));
                            }
                        // regular ETH transaction
                        } else {
                            // check transaction parameters
                            if (strtolower($transaction->from) == strtolower($deposit->parameters->addressFrom)
                                && strtolower($transaction->to) == strtolower($deposit->parameters->addressTo)
                                && Ethereum::bchexdec($transaction->value) == $deposit->payment_amount_wei) {
                                // mark deposit as completed
                                $deposit->update(['status' => Deposit::STATUS_COMPLETED]);
                                event(new DepositCompleted($deposit));

                                Log::info(sprintf('SUCCESS'));
                            } else {
                                Log::info(sprintf(
                                    'FROM match: %s, TO match: %s, AMOUNT match: %s, %s, %s',
                                    (int)(strtolower($transaction->from) == strtolower($deposit->parameters->addressFrom)),
                                    (int)(strtolower($transaction->to) == strtolower($deposit->parameters->addressTo)),
                                    (int)(Ethereum::bchexdec($transaction->value) == $deposit->payment_amount_wei),
                                    Ethereum::bchexdec($transaction->value),
                                    $deposit->payment_amount_wei
                                ));
                            }
                        }
                    } else {
                        Log::info(sprintf('FETCH ERROR: %s', $paymentService->getResponseMessage()));
                    }
                } catch (\Exception $e) {
                    Log::error(sprintf('GENERAL ERROR: %s', $e->getMessage()));
                }
            }
        }
    }
}
