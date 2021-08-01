<?php

namespace Packages\Payments\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Packages\Payments\Events\WithdrawalCancelled;
use Packages\Payments\Events\WithdrawalCompleted;
use Packages\Payments\Http\Requests\Backend\ChangeWithdrawalStatus;
use Packages\Payments\Models\Sort\Backend\WithdrawalSort;
use Packages\Payments\Models\Withdrawal;
use Packages\Payments\Services\PaymentService;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Withdrawals listing
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort = new WithdrawalSort($request);
        $search = $request->query('search');

        $withdrawals = Withdrawal::with('account.user', 'method:id,code,name')
            // when status filter is provided
            ->when($request->has('status'), function($query) use ($request) {
                $query->where('status', $request->query('status'));
            })
            // when search is provided
            ->when($search, function($query, $search) {
                // query related user model
                $query->whereHas('account.user', function($query) use($search) {
                    $query
                        ->whereRaw('LOWER(name) LIKE ?', ['%'. strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(email) LIKE ?', ['%'. strtolower($search) . '%']);
                });
            })
            ->orderBy($sort->getSortColumn(), $sort->getOrder())
            ->paginate($this->rowsPerPage);

        return view('payments::backend.pages.withdrawals.index', [
            'withdrawals'   => $withdrawals,
            'search'        => $search,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    public function show(Withdrawal $withdrawal)
    {
        return view('payments::backend.pages.withdrawals.show', [
            'withdrawal' => $withdrawal->loadMissing('method', 'method.gateway')
        ]);
    }

    public function transaction(Withdrawal $withdrawal)
    {
        $paymentService = PaymentService::createFromModel($withdrawal->method->gateway);

        abort_if(!$withdrawal->external_id, 404);
        abort_if(!method_exists($paymentService, 'fetchWithdrawal'), 404);

        $cacheKey = 'payments.withdrawals.' . $withdrawal->id . '.transaction';

        // get data from cache
        $transaction = Cache::get($cacheKey);

        // if data is not present in the cache or it's expired
        if (!$transaction) {
            $paymentService->fetchWithdrawal($withdrawal->external_id);

            // request is successful
            if ($paymentService->isResponseSuccessful()) {
                $transaction = $paymentService->getResponseData();
                Cache::put($cacheKey, $transaction, now()->addMinute());
                // if request is not successful return an error message
            } else {
                return back()->withErrors($paymentService->getResponseMessage());
            }
        }

        return view('payments::backend.pages.withdrawals.transaction', [
            'withdrawal' => $withdrawal,
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        $withdrawal->update($request->all());

        return ['success' => TRUE];
    }

    public function send(ChangeWithdrawalStatus $request, Withdrawal $withdrawal)
    {
        // instantiate payment service
        $paymentService = PaymentService::createFromModel($withdrawal->method->gateway);

        // initialize payment
        $paymentService->createWithdrawal([
            'amount'            => $withdrawal->amount,
            'payment_currency'  => $withdrawal->payment_currency,
            'address'           => $withdrawal->parameters->address,
            'user'              => (object) $withdrawal->account->user->toArray()
        ]);

        // if request is not successful log it and return an error message
        if (!$paymentService->isResponseSuccessful()) {
            Log::error($paymentService->getResponseMessage());

            return back()->withErrors($paymentService->getResponseMessage());
        }

        // if everything is correct set withdrawal status to pending and save response in the database
        $withdrawal->external_id = $paymentService->getTransactionReference();
        $withdrawal->response = [$paymentService->getResponseData()];
        $withdrawal->status = Withdrawal::STATUS_PENDING;
        $withdrawal->save();

        return redirect()
            ->route('backend.withdrawals.index')
            ->with('success', __('Withdrawal transaction with reference :id is created.', ['id' => $paymentService->getTransactionReference()]));
    }

    public function cancel(ChangeWithdrawalStatus $request, Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => Withdrawal::STATUS_CANCELLED]);

        event(new WithdrawalCancelled($withdrawal));

        return redirect()
            ->route('backend.withdrawals.index')
            ->with('success', __('Withdrawal is rejected.'));
    }

    public function complete(ChangeWithdrawalStatus $request, Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => Withdrawal::STATUS_COMPLETED]);

        event(new WithdrawalCompleted($withdrawal));

        return redirect()
            ->route('backend.withdrawals.index')
            ->with('success', __('Withdrawal is completed.'));
    }
}
