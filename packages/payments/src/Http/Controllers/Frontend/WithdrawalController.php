<?php

namespace Packages\Payments\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Packages\Payments\Events\WithdrawalCreated;
use Packages\Payments\Http\Requests\Frontend\StoreWithdrawal;
use Packages\Payments\Models\Sort\Frontend\WithdrawalSort;
use Packages\Payments\Models\Withdrawal;
use Packages\Payments\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Packages\Payments\Services\MulticurrencyPaymentService;
use Packages\Payments\Services\PaymentService;

class WithdrawalController extends Controller
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
        $sort = new WithdrawalSort($request);

        $withdrawals = Withdrawal::where('account_id', '=', $account->id)
            ->with('method:id,name')
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('payments::frontend.pages.withdrawals.index', [
            'withdrawals'   => $withdrawals,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    /**
     * Display withdrawal form
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $methods = WithdrawalMethod::enabled()
            ->with('gateway')
            ->orderBy('id')
            ->get()
            ->map(function ($method) {
                if ($method->gateway) {
                    $method->gateway->append('payment_currencies');
                }
                return $method;
            });

        return view('payments::frontend.pages.withdrawals.create', [
            'props' => [
                'account' => $request->user()->account,
                'config' => [
                    'withdrawal_min' => config('payments.withdrawal_min'),
                    'withdrawal_max' => config('payments.withdrawal_max')
                ],
                'methods' => $methods
            ]
        ]);
    }

    /**
     * Handle withdrawals form submission
     *
     * @param StoreWithdrawal $request
     * @param WithdrawalMethod $withdrawalMethod
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreWithdrawal $request, WithdrawalMethod $withdrawalMethod)
    {
        $withdrawal = new Withdrawal();
        $withdrawal->account()->associate($request->user()->account);
        $withdrawal->method()->associate($withdrawalMethod);
        $withdrawal->status = Withdrawal::STATUS_CREATED;
        $withdrawal->amount = $request->amount;

        $parameters = $request->parameters;

        // if the withdrawal method is linked to a gateway
        if ($withdrawalMethod->gateway) {
            $paymentService = PaymentService::createFromModel($withdrawalMethod->gateway);

            // in case of multi currency get the payment currency from the request (it is specified by the user)
            if ($paymentService instanceof MulticurrencyPaymentService) {
                $withdrawal->payment_currency = $request->payment_currency;
            // otherwise get the default currency from the gateway settings
            } else {
                $withdrawal->payment_currency = $paymentService->getPaymentGatewayCurrency();
            }

            $rate = $paymentService->getPaymentGatewayRate();
            // calculate payment amount if payment currency and gateway currency are equal
            if ($withdrawal->payment_currency == $paymentService->getPaymentGatewayCurrency() && $rate > 0) {
                $withdrawal->payment_amount = $withdrawal->amount / $rate;
            }

            if ($withdrawalMethod->gateway->code == 'ethereum' && $withdrawal->payment_currency != 'ETH') {
                $parameters = array_merge($parameters, [
                    'contractDecimals' => config('payments.ethereum.deposit_contract_decimals'),
                ]);
            } elseif ($withdrawalMethod->gateway->code == 'bsc' && $withdrawal->payment_currency != 'BNB') {
                $parameters = array_merge($parameters, [
                    'contractDecimals' => config('payments.bsc.deposit_contract_decimals'),
                ]);
            }
        }

        $withdrawal->parameters = $parameters;

        $withdrawal->save();

        event(new WithdrawalCreated($withdrawal));

        return redirect()->route('frontend.withdrawals.index')
            ->with('success', __('Withdrawal request is successfully submitted.'));
    }
}
