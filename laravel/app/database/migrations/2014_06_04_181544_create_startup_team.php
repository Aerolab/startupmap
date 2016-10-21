<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStartupTeam extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('startup_team', function(Blueprint $table){
			$table->increments('id');
			$table->integer('startup_id');
			$table->integer('user_id');
			$table->integer('role_id');
			$table->enum('is_admin', array('y','n'));
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
		Schema::drop('startup_team');
	}

}
