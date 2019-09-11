<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('stocks')) {
            Schema::table('stocks', function (Blueprint $table) {            
                $table->string('comment')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('stocks')) {
            Schema::table('stocks', function (Blueprint $table) {      
                $table->dropColumn('comment');
            });
        }
    }
}
