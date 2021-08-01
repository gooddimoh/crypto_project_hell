<?php

namespace Packages\Payments\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Packages\Payments\Models\PaymentGateway;
use Illuminate\Http\Request;
use Packages\Payments\Services\PaymentService;

class PaymentGatewayController extends Controller
{
    public function index(Request $request)
    {
        $payment_gateways = PaymentGateway::all();

        return view('payments::backend.pages.payment-gateways.index', [
            'payment_gateways' => $payment_gateways
        ]);
    }

    public function show(PaymentGateway $paymentGateway)
    {
        return $paymentGateway;
    }

    public function info(PaymentGateway $paymentGateway)
    {
        $paymentService = PaymentService::createFromModel($paymentGateway);

        abort_if(!method_exists($paymentService, 'fetchAccountInfo'), 404);

        $cacheKey = 'payments.payment-gateways.' . $paymentGateway->id . '.info';

        // get data from cache
        $data = Cache::get($cacheKey);

        // if data is not present in the cache or it's expired
        if (!$data) {
            $paymentService->fetchAccountInfo();

            // request is successful
            if ($paymentService->isResponseSuccessful()) {
                $data = $paymentService->getResponseData();
                Cache::put($cacheKey, $data, now()->addMinutes(30));
            // if request is not successful return an error message
            } else {
                return back()->withErrors($paymentService->getResponseMessage());
            }
        }

        return view('payments::backend.pages.payment-gateways.info', [
            'payment_gateway' => $paymentGateway,
            'data' => $data
        ]);
    }

    public function balance(PaymentGateway $paymentGateway)
    {
        $paymentService = PaymentService::createFromModel($paymentGateway);

        abort_if(!method_exists($paymentService, 'fetchBalance'), 404);

        $cacheKey = 'payments.payment-gateways.' . $paymentGateway->id . '.balance';

        // get data from cache
        $data = Cache::get($cacheKey);

        // if data is not present in the cache or it's expired
        if (!$data) {
            $paymentService->fetchBalance();

            // request is successful
            if ($paymentService->isResponseSuccessful()) {
                $data = $paymentService->getResponseData();
                Cache::put($cacheKey, $data, now()->addMinutes(5));
            // if request is not successful return an error message
            } else {
                return back()->withErrors($paymentService->getResponseMessage());
            }
        }

        return view('payments::backend.pages.payment-gateways.balance', [
            'payment_gateway' => $paymentGateway,
            'data' => $data
        ]);
    }

    public function edit(Request $request, PaymentGateway $paymentGateway)
    {
        return view('payments::backend.pages.payment-gateways.edit', [
            'payment_gateway' => $paymentGateway
        ]);
    }

    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $paymentGateway->name = $request->name;
        $paymentGateway->currency = $request->currency;
        $paymentGateway->rate = $request->rate;
        $paymentGateway->save();

        return redirect()->route('backend.payment-gateways.index')->with('success', __('Payment gateway is successfully updated.'));
    }
}
