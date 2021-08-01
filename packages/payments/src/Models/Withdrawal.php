<?php

namespace Packages\Payments\Models;

use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\Formatters\Formatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Packages\Payments\Helpers\Ethereum;

class Withdrawal extends Model
{
    use Formatter;

    const STATUS_CREATED        = 0;
    const STATUS_PENDING        = 1;
    const STATUS_COMPLETED      = 2;
    const STATUS_CANCELLED      = 10;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'payment_amount_wei'
    ];

    protected $formats = [
        'amount' => 'decimal',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'external_id',
        'status',
        'response'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount'            => 'float',
        'parameters'        => 'object',
        'response'          => 'array',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function transaction()
    {
        return $this->morphOne(AccountTransaction::class, 'transactionable');
    }

    public function method()
    {
        return $this->belongsTo(WithdrawalMethod::class, 'withdrawal_method_id');
    }

    /**
     * Scope a query to only include created withdrawals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreated($query): Builder
    {
        return $query->where('status', self::STATUS_CREATED);
    }

    /**
     * Scope a query to only include completed withdrawals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query): Builder
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function getTitleAttribute()
    {
        return __('Withdrawal');
    }

    /**
     * Getter for is_created attribute
     *
     * @return bool
     */
    public function getIsCreatedAttribute()
    {
        return $this->status == self::STATUS_CREATED;
    }

    /**
     * Getter for is_pending attribute
     *
     * @return bool
     */
    public function getIsPendingAttribute()
    {
        return $this->status == self::STATUS_PENDING;
    }

    /**
     * Getter for is_completed attribute
     *
     * @return bool
     */
    public function getIsCompletedAttribute()
    {
        return $this->status == self::STATUS_COMPLETED;
    }

    /**
     * Getter for is_cancelled attribute
     *
     * @return bool
     */
    public function getIsCancelledAttribute()
    {
        return $this->status == self::STATUS_CANCELLED;
    }

    public static function statuses()
    {
        return [
            self::STATUS_CREATED    => __('Created'),
            self::STATUS_PENDING    => __('Pending'),
            self::STATUS_COMPLETED  => __('Completed'),
            self::STATUS_CANCELLED  => __('Cancelled'),
        ];
    }

    public function getStatusTitleAttribute()
    {
        return self::statuses()[$this->status];
    }

    /**
     * Get payment amount in wei for ETH and ERC20 tokens
     *
     * @return string
     */
    public function getPaymentAmountWeiAttribute()
    {
        return is_object($this->parameters) && isset($this->parameters->contractDecimals)
            ? Ethereum::toWei($this->payment_amount, $this->parameters->contractDecimals)
            : (in_array($this->payment_currency, ['ETH', 'BNB'])
                ? Ethereum::toWei($this->payment_amount, 18)
                : '0');
    }
}
