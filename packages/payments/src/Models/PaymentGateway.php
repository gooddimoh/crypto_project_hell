<?php

namespace Packages\Payments\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Packages\Payments\Services\MulticurrencyPaymentService;
use Packages\Payments\Services\PaymentService;

class PaymentGateway extends Model
{
    /**
     * This format will be used when the model is serialized to an array or JSON.
     *
     * @var array
     */
    protected $casts = [
        'rate' => 'float',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Getter for payment_currencies attribute
     * For performance reasons it should not be added to $appends[] and should be appended manually on a query basis.
     *
     * @return Collection|null
     */
    public function getPaymentCurrenciesAttribute(): ?Collection
    {
        $paymentService = PaymentService::createFromModel($this);

        if ($paymentService instanceof MulticurrencyPaymentService) {
            return $paymentService->getPaymentCurrencies();
        }

        return NULL;
    }
}
