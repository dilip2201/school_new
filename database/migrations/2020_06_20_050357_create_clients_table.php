<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_id');
            $table->enum('name_salutation',['Mr.','Miss','Mrs.','Ms.'])->default('Mr.');
            $table->string('first_name',25)->nullable();
            $table->string('last_name',25)->nullable();
            $table->enum('relation',['Self','Husband','Wife','Father','Mother','Brother','Sister','Son','Daughter','Staff','Friend','Others'])->default('Self');
            $table->enum('group_head',['yes','no'])->default('no');
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_anniversary')->nullable();
            $table->string('mobile_number',30)->nullable();
            $table->string('email',50)->nullable();
            $table->string('address_1',50)->nullable();
            $table->string('address_2',50)->nullable();
            $table->string('area',50)->nullable();
            $table->string('city',25)->nullable();
            $table->string('pin_code',10)->nullable();
            $table->enum('client_category',['Silver','Gold','Diamond']);
            $table->enum('status',['active','inactive'])->default('active');
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
        Schema::dropIfExists('clients');
    }
}
