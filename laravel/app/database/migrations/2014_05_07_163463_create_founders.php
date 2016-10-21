<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFounders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('founders', function(Blueprint $table){

			$table->increments('id');

			$table->integer('user_id');

			$table->string('name');
			$table->string('last_name');

			$table->string('picture');

			$table->text('linkedin');
			$table->text('angellist');
			$table->text('crunchbase');

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
		Schema::drop('startup_members');
	}

}
