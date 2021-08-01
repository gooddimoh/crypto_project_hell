<?php

namespace Packages\Payments\Models\Sort\Frontend;

use App\Models\Sort\Sort;

class WithdrawalSort extends Sort
{
    protected $sortableColumns = [
        'method'                => 'withdrawal_method_id',
        'amount'                => 'amount',
        'status'                => 'status',
        'created'               => 'created_at',
        'updated'               => 'updated_at'
    ];

    protected $defaultSort = 'created';
}
