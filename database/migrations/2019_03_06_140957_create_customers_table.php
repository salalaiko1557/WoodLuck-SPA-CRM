<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id')->start_from(001);
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('company')->nullable();
            $table->bigInteger('telephone')->nullable();
            $table->string('email')->nullable();
            $table->integer('orders_sum')->nullable();
            $table->integer('source_id')->nullable();
            //Индексация с таблицей ТАРГЕТЫ
            //$table->foreign('source_id')->references('id')->on('sources')->onDelete('cascade');
            $table->text('delivery')->nullable();
            $table->integer('rate_value')->nullable();
            $table->text('rate_description')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
