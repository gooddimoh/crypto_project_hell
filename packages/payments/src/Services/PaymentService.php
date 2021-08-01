<?php

namespace Packages\Payments\Services;

use Packages\Payments\Models\PaymentGateway;

abstract class PaymentService
{
    protected $response;

    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;

        $this->init();

        return $this;
    }

    public final function getPaymentGateway(): PaymentGateway
    {
        return $this->paymentGateway;
    }

    public final function getPaymentGatewayCurrency(): string
    {
        return $this->getPaymentGateway()->currency;
    }

    public final function getPaymentGatewayRate(): float
    {
        return $this->getPaymentGateway()->rate;
    }

    public final function getReturnUrl(): string
    {
        return route('payments.webhooks.complete', ['paymentGateway' => $this->paymentGateway, 'action' => 'complete']);
    }

    public final function getCancelUrl(): string
    {
        return route('payments.webhooks.complete', ['paymentGateway' => $this->paymentGateway, 'action' => 'cancel']);
    }

    public final function getNotifyUrl(): string
    {
        return route('payments.webhooks.ipn', ['paymentGateway' => $this->paymentGateway]);
    }

    /**
     * Get payment amount
     *
     * @return float
     */
    public function getPaymentAmount(): float
    {
        return (float) $this->response->getRequest()->getAmount();
    }

    /**
     * Get payment currency (child classes can override this method)
     *
     * @return string
     */
    public function getPaymentCurrency(): string
    {
        return $this->response->getRequest()->getCurrency();
    }

    /**
     * Get payment extra parameters (such as destination tag for instance)
     *
     * @return object|null
     */
    public function getPaymentParameters(): ?array
    {
        return NULL;
    }

    protected function getPaymentDescription(): string
    {
        return __('Credits purchase');
    }

    /**
     * Get API response object
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function isResponseSuccessful()
    {
        return is_object($this->response) ? $this->response->isSuccessful() : FALSE;
    }

    public function isResponseRedirect()
    {
        return is_object($this->response) ? $this->response->isRedirect() : FALSE;
    }

    public function getResponseData()
    {
        return is_object($this->response) ? $this->response->getData() : NULL;
    }

    public function getResponseMessage()
    {
        return is_object($this->response) ? $this->response->getMessage() : NULL;
    }

    public function getRedirectUrl(): string
    {
        return is_object($this->response) ? $this->response->getRedirectUrl() : NULL;
    }

    public function isExternalRedirect(): bool
    {
        return TRUE;
    }

    /**
     * Create a PaymentService instance using gateway ID
     *
     * @param int $paymentGatewayId
     * @return PaymentService
     */
    public final static function create(int $paymentGatewayId): PaymentService
    {
        return self::createFromModel(PaymentGateway::find($paymentGatewayId));
    }

    /**
     * Create a PaymentService instance using gateway model
     *
     * @param PaymentGateway $paymentGateway
     * @return PaymentService
     */
    public final static function createFromModel(PaymentGateway $paymentGateway): PaymentService
    {
        $paymentServiceClass = 'Packages\\Payments\\Services\\' . ucfirst($paymentGateway->code) . 'PaymentService';

        return new $paymentServiceClass($paymentGateway);
    }

    abstract protected function init();

    abstract public function createPayment(array $params): PaymentService;

    abstract public function completePayment(array $params): PaymentService;

    abstract public function getTransactionReferenceParameterName(): string;

    abstract public function getTransactionReference(): string;

    // parameters required to complete a payment
    abstract public function getCompletePaymentParameters(): array;

    // parameters required to cancel a payment
    abstract public function getCancelPaymentParameters(): array;
}
