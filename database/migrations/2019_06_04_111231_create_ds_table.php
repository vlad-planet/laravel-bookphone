<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ds', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
            $table->text('bookphone_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
		Schema::dropIfExists('ds');
    }
}
