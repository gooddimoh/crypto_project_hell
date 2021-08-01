<?php

namespace Packages\Payments\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Packages\Payments\Http\Requests\Backend\UpdateDepositMethod;
use Packages\Payments\Models\DepositMethod;

class DepositMethodController extends Controller
{
    public function index(Request $request)
    {
        $deposit_methods = DepositMethod::all();

        return view('payments::backend.pages.deposit-methods.index', [
            'deposit_methods' => $deposit_methods
        ]);
    }

    public function create()
    {
        return view('payments::backend.pages.deposit-methods.create', [
            'props' => [
                'action' => route('backend.deposit-methods.store'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $depositMethod = new DepositMethod();
        $depositMethod->code = $request->code;
        $depositMethod->name = $request->name;
        $depositMethod->description = $request->description;
        $depositMethod->enabled = $request->enabled;
        $depositMethod->parameters = $request->parameters ?: [];
        $depositMethod->save();

        return redirect()->route('backend.deposit-methods.index')
            ->with('success', __('Deposit method is successfully created.'));
    }

    public function edit(DepositMethod $depositMethod)
    {
        return view('payments::backend.pages.deposit-methods.edit', [
            'props' => [
                'action' => route('backend.deposit-methods.update', $depositMethod),
                'method' => $depositMethod->loadMissing('gateway')
            ]
        ]);
    }

    public function update(UpdateDepositMethod $request, DepositMethod $depositMethod)
    {
        $depositMethod->name = $request->name;
        $depositMethod->description = $request->description;
        $depositMethod->enabled = $request->enabled;
        $depositMethod->parameters = $request->parameters ?: [];
        $depositMethod->save();

        return redirect()->route('backend.deposit-methods.index')
            ->with('success', __('Deposit method is successfully saved.'));
    }

    public function delete(Request $request, DepositMethod $depositMethod)
    {
        $request->session()->flash('warning', __('Please note that all deposits associated with this method will also be deleted.'));

        return view('payments::backend.pages.deposit-methods.delete', [
            'deposit_method' => $depositMethod
        ]);
    }

    public function destroy(DepositMethod $depositMethod)
    {
        $depositMethod->delete();

        return redirect()->route('backend.deposit-methods.index')
            ->with('success', __('Deposit method is successfully deleted.'));
    }
}
