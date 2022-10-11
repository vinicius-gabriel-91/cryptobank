<?php

use App\Models\BankAccount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_log', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BankAccount::class)
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('account_number')
                ->nullable(false);
            $table->string('transaction_type')
                ->nullable(false);
            $table->string('value')
                ->nullable(false);
            $table->string('destination_account')
                ->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_log');
    }
}
