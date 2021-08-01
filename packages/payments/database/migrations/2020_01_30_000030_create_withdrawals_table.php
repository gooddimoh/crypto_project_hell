<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('withdrawals')) {
            Schema::rename('withdrawals', 'withdrawals_archive');
        }

        Schema::create('withdrawals', function (Blueprint $table) {
            // columns
            $table->bigIncrements('id');
            $table->unsignedInteger('account_id')->unsigned();
            $table->unsignedBigInteger('withdrawal_method_id');
            $table->string('external_id', 100)->nullable()->unique(); // external payment ID
            $table->decimal('amount', 20, 2); // amount in credits, e.g. 100.25 credits
            $table->decimal('payment_amount', 26, 8)->nullable(); // amount in payment currency, e.g. 1.1215
            $table->string('payment_currency', 20)->nullable(); // payment currency, e.g. BTC
            $table->unsignedTinyInteger('status');
            $table->mediumText('parameters')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
            // foreign keys
            $table->foreign('account_id', 'withdrawals_accounts_foreign_key')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('withdrawal_method_id')->references('id')->on('withdrawal_methods')->onUpdate('cascade')->onDelete('cascade');
            // indexes
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawals');

        if (Schema::hasTable('withdrawals_archive')) {
            Schema::rename('withdrawals_archive', 'withdrawals');
        }
    }
}
