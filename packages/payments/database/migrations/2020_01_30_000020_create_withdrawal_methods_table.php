<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            // columns
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->string('code', 30)->unique();
            $table->string('name', 100);
            $table->string('description', 2000)->nullable();
            $table->boolean('enabled')->default(TRUE);
            $table->text('parameters');
            $table->timestamps();
            // foreign keys
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onUpdate('cascade')->onDelete('cascade');
            // indexes
            $table->index('enabled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdrawal_methods');
    }
}
