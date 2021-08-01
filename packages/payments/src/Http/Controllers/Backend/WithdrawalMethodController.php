<?php

namespace Packages\Payments\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Payments\Http\Requests\Backend\UpdateWithdrawalMethod;
use Packages\Payments\Models\WithdrawalMethod;

class WithdrawalMethodController extends Controller
{
    public function index(Request $request)
    {
        $withdrawal_methods = WithdrawalMethod::all();

        return view('payments::backend.pages.withdrawal-methods.index', [
            'withdrawal_methods' => $withdrawal_methods
        ]);
    }

    public function create()
    {
        return view('payments::backend.pages.withdrawal-methods.create', [
            'props' => [
                'action' => route('backend.withdrawal-methods.store'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $withdrawalMethod = new WithdrawalMethod();
        $withdrawalMethod->code = $request->code;
        $withdrawalMethod->name = $request->name;
        $withdrawalMethod->description = $request->description;
        $withdrawalMethod->enabled = $request->enabled;
        $withdrawalMethod->parameters = $request->parameters ?: [];
        $withdrawalMethod->save();

        return redirect()->route('backend.withdrawal-methods.index')
            ->with('success', __('Withdrawal method is successfully created.'));
    }

    public function edit(WithdrawalMethod $withdrawalMethod)
    {
        return view('payments::backend.pages.withdrawal-methods.edit', [
            'props' => [
                'action' => route('backend.withdrawal-methods.update', $withdrawalMethod),
                'method' => $withdrawalMethod->loadMissing('gateway')
            ]
        ]);
    }

    public function update(UpdateWithdrawalMethod $request, WithdrawalMethod $withdrawalMethod)
    {
        $withdrawalMethod->name = $request->name;
        $withdrawalMethod->description = $request->description;
        $withdrawalMethod->enabled = $request->enabled;
        $withdrawalMethod->parameters = $request->parameters ?: [];
        $withdrawalMethod->save();

        return redirect()->route('backend.withdrawal-methods.index')
            ->with('success', __('Withdrawal method is successfully saved.'));
    }

    public function delete(Request $request, WithdrawalMethod $withdrawalMethod)
    {
        $request->session()->flash('warning', __('Please note that all withdrawals associated with this method will also be deleted.'));

        return view('payments::backend.pages.withdrawal-methods.delete', [
            'withdrawal_method' => $withdrawalMethod
        ]);
    }

    public function destroy(WithdrawalMethod $withdrawalMethod)
    {
        $withdrawalMethod->delete();

        return redirect()->route('backend.withdrawal-methods.index')
            ->with('success', __('Withdrawal method is successfully deleted.'));
    }
}
