<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Packages\Payments\Models\Deposit;
use Packages\Payments\Models\DepositMethod;
use Packages\Payments\Models\Withdrawal;
use Packages\Payments\Models\WithdrawalMethod;

class DepositsWithdrawalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('deposits_archive') && DB::table('deposits')->count() == 0) {
            $rows = [];

            $depositMethodId = DepositMethod::where('code', 'coinpayments')->value('id');

            foreach (DB::table('deposits_archive')->orderBy('id', 'asc')->get() as $item) {
                switch ((int) $item->status) {
                    case 1:
                        $status = Deposit::STATUS_COMPLETED;
                        break;
                    case 2:
                        $status = Deposit::STATUS_CANCELLED;
                        break;
                    default:
                        $status = Deposit::STATUS_CREATED;
                }

                $rows[] = [
                    'account_id'        => $item->account_id,
                    'deposit_method_id' => $depositMethodId,
                    'external_id'       => $item->external_id,
                    'amount'            => $item->amount,
                    'payment_amount'    => $item->payment_amount,
                    'payment_currency'  => $item->payment_currency,
                    'status'            => $status,
                    'parameters'        => $item->destination_tag ? json_encode(['destination_tag' => $item->destination_tag]) : NULL,
                    'response'          => NULL,
                    'created_at'        => $item->created_at,
                    'updated_at'        => $item->updated_at
                ];
            }

            if (!empty($rows)) {
                DB::table('deposits')->insert($rows);
            }
        }

        if (Schema::hasTable('withdrawals_archive') && DB::table('withdrawals')->count() == 0) {
            $rows = [];

            $withdrawalMethodId = WithdrawalMethod::where('code', 'coinpayments')->value('id');

            foreach (DB::table('withdrawals_archive')->orderBy('id', 'asc')->get() as $item) {
                switch ((int) $item->status) {
                    case 3:
                        $status = Withdrawal::STATUS_CANCELLED;
                        break;
                    default:
                        $status = $item->status;
                }

                $rows[] = [
                    'account_id'        => $item->account_id,
                    'withdrawal_method_id' => $withdrawalMethodId,
                    'external_id'       => $item->external_id,
                    'amount'            => $item->amount,
                    'payment_amount'    => NULL,
                    'payment_currency'  => $item->payment_currency,
                    'status'            => $status,
                    'parameters'        => json_encode(['address' => $item->wallet, 'comment' => $item->comment]),
                    'response'          => NULL,
                    'created_at'        => $item->created_at,
                    'updated_at'        => $item->updated_at
                ];
            }

            if (!empty($rows)) {
                DB::table('withdrawals')->insert($rows);
            }
        }
    }
}
