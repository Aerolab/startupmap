<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table){

			$table->increments('id');

			$table->string('email');
			$table->text('password');

			$table->string('key');
			$table->enum('admin', array('y', 'n'));

			$table->text('ln_access_token');
			$table->text('remember_token');

			$table->timestamp('validated_at');
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
		Schema::drop('users');
	}

}
