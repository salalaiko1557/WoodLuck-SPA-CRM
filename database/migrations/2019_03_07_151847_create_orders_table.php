<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->nullable();
            //Индексация с таблицей КЛИЕНТЫ
            //$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->integer('order_type_id')->nullable();
            //Индексация с таблицей ТИПЫ ЗАКАЗА
            //$table->foreign('order_type_id')->references('id')->on('orders_type')->onDelete('cascade');
            $table->double('price', 8, 2)->nullable();
            $table->integer('pay_type_id')->nullable();
            //Индексация с таблицей ТИПЫ ОПЛАТЫ
            //$table->foreign('pay_type_id')->references('id')->on('pays_type')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->text('text_execution')->nullable();
            $table->timestamp('date_execution')->useCurrent();
            $table->integer('material_id')->nullable();
            //Индексация с таблицей СКЛАД
            //$table->foreign('material_id')->references('id')->on('stock')->onDelete('cascade');
            $table->integer('material_count')->nullable();
            $table->integer('canban_status')->default(1);
            $table->string('draw')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
