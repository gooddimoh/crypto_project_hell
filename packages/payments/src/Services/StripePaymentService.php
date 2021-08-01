<?php

namespace Packages\Payments\Services;

use Omnipay\Omnipay;

/**
 * Class StripePaymentService
 * @package Packages\Payments\Services
 *
 * Test cards: https://stripe.com/docs/testing
 *
 */
class StripePaymentService extends PaymentService
{
    protected $omnipay;

    protected function init()
    {
        $this->omnipay = Omnipay::create('Stripe_PaymentIntents');

        $this->omnipay->initialize([
            'apiKey'  => config('payments.stripe.secret_key')
        ]);
    }

    public function createPayment(array $params): PaymentService
    {
        $params = [
            'amount'            => round($params['amount'] / $this->getPaymentGatewayRate(), 2),
            'currency'          => $this->getPaymentGatewayCurrency(),
            'paymentMethod'     => $params['parameters']['payment_method_id'],
            'description'       => $this->getPaymentDescription(),
            'returnUrl'         => $this->getReturnUrl(),
            'confirm'           => TRUE,
        ];

        $this->response = $this->omnipay->purchase($params)->send();

        return $this;
    }

    public function completePayment(array $params): PaymentService
    {
        $this->response = $this->omnipay->confirm([
            'paymentIntentReference' => $params['payment_intent']
        ])->send();

        return $this;
    }

    public function getTransactionReferenceParameterName(): string
    {
        return 'payment_intent';
    }

    public function getTransactionReference(): string
    {
        return $this->response->getPaymentIntentReference();
    }

    public function getCompletePaymentParameters(): array
    {
        return ['payment_intent'];
    }

    public function getCancelPaymentParameters(): array
    {
        return [];
    }
}
