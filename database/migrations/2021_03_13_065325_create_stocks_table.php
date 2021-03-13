<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('item_id')->nullable();
            $table->integer('date')->nullable();
            $table->integer('expected_date')->nullable();
            $table->integer('size')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('pending_quantity')->nullable();
            $table->text('remark')->nullable();
            $table->enum('status',['pending','ordered','dispatched','delivered','partially_delivered','cancelled'])->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
