<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStartupsHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('startup_history', function(Blueprint $table){

			$table->increments('id');

			$table->integer('startup_id');
			$table->integer('category_id');
			$table->integer('user_id');

			$table->text('commit');

			$table->integer('child_of');

			$table->string('name');
			$table->string('slogan');
			$table->text('description');

			$table->text('logo');
			$table->text('banner');

			$table->text('website');
			$table->text('facebook');
			$table->text('twitter');
			$table->text('linkedin');
			$table->text('crunchbase');
			$table->text('angelist');
			$table->text('dribbble');
			$table->text('google_plus');
			$table->text('foursquare');
			$table->text('youtube');

			$table->text('tags');
			$table->string('type');
			$table->text('flag');
			$table->enum('approved', array('y', 'n'));

			$table->text('address');
			$table->text('city');
			$table->text('country');

			$table->text('address_city');
			$table->text('address_street');
			$table->text('address_country');
			$table->text('address_formatted');

			$table->float('lat');
			$table->float('lon');

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
		Schema::drop('startup_history');
	}

}
