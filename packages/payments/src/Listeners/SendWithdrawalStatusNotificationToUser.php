<?php

namespace Packages\Payments\Listeners;

use Packages\Payments\Events\WithdrawalCancelled;
use Packages\Payments\Events\WithdrawalCompleted;
use Packages\Payments\Events\WithdrawalStatusChanged;
use Packages\Payments\Notifications\WithdrawalCancelled as WithdrawalCancelledNotification;
use Packages\Payments\Notifications\WithdrawalCompleted as WithdrawalCompletedNotification;

class SendWithdrawalStatusNotificationToUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WithdrawalStatusChanged  $event
     * @return void
     */
    public function handle(WithdrawalStatusChanged $event)
    {
        $withdrawal = $event->withdrawal;
        $user = $withdrawal->account->user;

        if ($event instanceof WithdrawalCancelled) {
            $user->notify(new WithdrawalCancelledNotification($withdrawal));
        } elseif ($event instanceof WithdrawalCompleted) {
            $user->notify(new WithdrawalCompletedNotification($withdrawal));
        }
    }
}
