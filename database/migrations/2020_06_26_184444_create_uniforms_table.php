<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uniforms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->enum('gender',['male','female']);
            $table->enum('season',['winter','summer']);
            $table->enum('standard',['1','2','3','4','5','6','7','8','9','10','11','12']);
            $table->integer('item_id');
            $table->string('file',40);
            $table->string('single_text',30);
            $table->string('remarks',20);
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
        Schema::dropIfExists('uniforms');
    }
}
