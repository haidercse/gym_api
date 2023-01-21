<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',20);
            $table->unsignedBigInteger('create_by');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('amount');
            $table->tinyInteger('fee_type');
            $table->unsignedBigInteger('payment_type');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('member_id')->references('member_id')->on('members');
            $table->foreign('create_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
