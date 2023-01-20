<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',20)->unique();
            $table->string('name',50);
            $table->tinyInteger('gender');
            $table->string('mobile_number',11)->unique();
            $table->enum('blood',['A+','AB+','B+','AB-','B-','O+','O-','A-']);
            $table->text('address')->nullable();
            $table->string('image',100);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('lock')->default(0);
            $table->unsignedBigInteger('create_by');
            $table->string('card_no',15)->default('00000000');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('members');
    }
}
