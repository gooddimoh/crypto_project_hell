<?php

namespace Packages\Payments\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    /**
     * This format will be used when the model is serialized to an array or JSON.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'object', // array of objects
    ];

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    /**
     * Scope a query to only include enabled methods.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query): Builder
    {
        return $query->where('enabled', TRUE);
    }

    public function getStatusTitleAttribute()
    {
        return $this->enabled
            ? __('Enabled')
            : __('Disabled');
    }

    /**
     * Getter for keyed_parameters attribute
     */
    public function getKeyedParametersAttribute()
    {
        return collect($this->parameters)->keyBy('id');
    }
}
