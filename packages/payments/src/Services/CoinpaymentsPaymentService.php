<?php

namespace Packages\Payments\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Omnipay\Omnipay;

class CoinpaymentsPaymentService extends PaymentService implements MulticurrencyPaymentService
{
    protected $omnipay;

    protected function init()
    {
        $this->omnipay = Omnipay::create('Coinpayments');

        $this->omnipay->initialize([
            'merchant_id'   => config('payments.coinpayments.merchant_id'),
            'public_key'    => config('payments.coinpayments.public_key'),
            'private_key'   => config('payments.coinpayments.private_key'),
            'secret_key'    => config('payments.coinpayments.secret_key'),
        ]);
    }

    public function createPayment(array $params): PaymentService
    {
        $params = [
            'amount'            => $params['amount'] / $this->getPaymentGatewayRate(),
            'currency'          => $this->getPaymentGatewayCurrency(),
            'payment_currency'  => $params['payment_currency'],
            'description'       => $this->getPaymentDescription(),
            'client_email'      => $params['user']->email,
            'notify_url'        => $this->getNotifyUrl(),
            'confirm'           => TRUE,
        ];

        $this->response = $this->omnipay->createTransaction($params)->send();

        return $this;
    }

    public function completePayment(array $params): PaymentService
    {
        return $this;
    }

    public function createWithdrawal(array $params): PaymentService
    {
        $params = [
            'amount'            => $params['amount'] / $this->getPaymentGatewayRate(),
            'currency'          => $this->getPaymentGatewayCurrency(),
            'payment_currency'  => $params['payment_currency'],
            'description'       => __('Withdrawal of :n credits by user :email', ['n' => $params['amount'], 'email' => $params['user']->email]),
            'address'           => $params['address'],
            'notify_url'        => $this->getNotifyUrl(),
            'auto_confirm'      => config('payments.coinpayments.withdrawals_auto_confirm'),
            'confirm'           => TRUE
        ];

        $this->response = $this->omnipay->createWithdrawal($params)->send();

        return $this;
    }

    public function getPaymentCurrencies(): Collection
    {
        $nominalCurrencyCode = $this->getPaymentGatewayCurrency();
        $nominalCurrencyToCreditsRate = $this->getPaymentGatewayRate();

        return Cache::remember('payments.deposits.currencies' . $nominalCurrencyCode, 300, function () use ($nominalCurrencyCode, $nominalCurrencyToCreditsRate) {
            $this->response = $this->omnipay->fetchCurrencies()->send();

            if ($this->isResponseSuccessful()) {
                $currencies = collect($this->response->getData());

                if (!$currencies->get($nominalCurrencyCode)) {
                    throw new \Exception(sprintf('Currency "%s" is not supported by this gateway.', $nominalCurrencyCode));
                }

                $nominalCurrencyToBitcoinRate = $currencies->get($nominalCurrencyCode)->rate_btc;

                // leave only cryptocurrencies, which are accepted
                $paymentCurrencies = $currencies->filter(function ($currency) {
                    return $currency->is_fiat == 0 && $currency->status == 'online' && $currency->accepted == 1;
                });

                // calculate conversion rate to credits for each currency
                $paymentCurrencies = $paymentCurrencies->transform(function ($currency) use ($nominalCurrencyToBitcoinRate, $nominalCurrencyToCreditsRate) {
                    return (object) [
                        'name' => $currency->name,
                        'rate_btc' => $currency->rate_btc,
                        'rate_credits' => (float) $currency->rate_btc / $nominalCurrencyToBitcoinRate * $nominalCurrencyToCreditsRate,
                    ];
                });

                return $paymentCurrencies->sortKeys();
            }

            return collect();
        });
    }

    public function fetchAccountInfo(): PaymentService
    {
        $this->response = $this->omnipay->fetchAccountInfo()->send();

        return $this;
    }

    public function fetchBalance(): PaymentService
    {
        $this->response = $this->omnipay->fetchBalance()->send();

        return $this;
    }

    public function fetchTransaction(string $transactionId): PaymentService
    {
        $this->response = $this->omnipay->fetchTransaction(['transactionReference' => $transactionId])->send();

        return $this;
    }

    public function fetchWithdrawal(string $transactionId): PaymentService
    {
        $this->response = $this->omnipay->fetchWithdrawal(['withdrawalReference' => $transactionId])->send();

        return $this;
    }

    public function getTransactionReferenceParameterName(): string
    {
        return '';
    }

    public function getTransactionReference(): string
    {
        return $this->response->getTransactionReference();
    }

    public function getPaymentAmount(): float
    {
        return (float) $this->response->getData()->amount;
    }

    public function getPaymentCurrency(): string
    {
        return $this->response->getRequest()->getPaymentCurrency();
    }

    public function getPaymentParameters(): ?array
    {
        $data = $this->response->getData();

        return [
            'address'           => $data->address,
            'destination_tag'   => $data->dest_tag ?? NULL,
            'expiration_time'   => time() + $data->timeout,
            'qr_url'            => $data->qrcode_url
        ];
    }

    public function getRedirectUrl(): string
    {
        return 'user.account.deposits.complete';
    }

    public function isExternalRedirect(): bool
    {
        return FALSE;
    }

    public function getCompletePaymentParameters(): array
    {
        return [];
    }

    public function getCancelPaymentParameters(): array
    {
        return [];
    }

    /**
     * Check whether IPN callback has a valid signature
     *
     * @param $content
     * @param $header
     * @return bool
     */
    public function isSignatureValid($content, $header): bool
    {
        return $this->omnipay->isSignatureValid($content, $header);
    }
}
