<?php

namespace Packages\Payments\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Packages\Payments\Events\DepositCancelled;
use Packages\Payments\Events\DepositCompleted;
use Packages\Payments\Http\Requests\Backend\ChangeDepositStatus;
use Packages\Payments\Models\Deposit;
use Packages\Payments\Models\Sort\Backend\DepositSort;
use Illuminate\Http\Request;
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
        $sort = new DepositSort($request);
        $search = $request->query('search');

        $deposits = Deposit::with('account.user', 'method:id,code,name')
            // when status filter is provided
            ->when($request->has('status'), function($query) use ($request) {
                $query->where('status', $request->query('status'));
            })
            // when search filter is provided
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

        return view('payments::backend.pages.deposits.index', [
            'deposits'      => $deposits,
            'search'        => $search,
            'sort'          => $sort->getSort(),
            'order'         => $sort->getOrder(),
        ]);
    }

    public function show(Deposit $deposit)
    {
        return view('payments::backend.pages.deposits.show', [
            'deposit' => $deposit
        ]);
    }

    public function transaction(Deposit $deposit)
    {
        $paymentService = PaymentService::createFromModel($deposit->method->gateway);

        abort_if(!method_exists($paymentService, 'fetchTransaction'), 404);

        $cacheKey = 'payments.deposits.' . $deposit->id . '.transaction';

        // get data from cache
        $transaction = Cache::get($cacheKey);

        // if data is not present in the cache or it's expired
        if (!$transaction) {
            $paymentService->fetchTransaction($deposit->external_id);

            // request is successful
            if ($paymentService->isResponseSuccessful()) {
                $transaction = $paymentService->getResponseData();
                Cache::put($cacheKey, $transaction, now()->addMinute());
            // if request is not successful return an error message
            } else {
                return back()->withErrors($paymentService->getResponseMessage());
            }
        }

        return view('payments::backend.pages.deposits.transaction', [
            'deposit' => $deposit,
            'transaction' => $transaction
        ]);
    }

    public function cancel(ChangeDepositStatus $request, Deposit $deposit)
    {
        $deposit->update(['status' => Deposit::STATUS_CANCELLED]);

        event(new DepositCancelled($deposit));

        return redirect()->route('backend.deposits.index')->with('success', __('Deposit is successfully cancelled.'));
    }

    public function complete(ChangeDepositStatus $request, Deposit $deposit)
    {
        $deposit->update(['status' => Deposit::STATUS_COMPLETED]);

        event(new DepositCompleted($deposit));

        return redirect()->route('backend.deposits.index')->with('success', __('Deposit is successfully completed.'));
    }
}
