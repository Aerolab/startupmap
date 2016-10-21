<?php

class StartupsTableSeeder extends Seeder {

	public function run() {

		Startups::truncate();

		Startups::create([
			'categoryId' => 'Startups',
			'name' => 'Aerolab'
		]);

	}

}