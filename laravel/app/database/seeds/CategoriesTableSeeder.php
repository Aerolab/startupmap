<?php

class CategoriesTableSeeder extends Seeder {

	public function run() {

		Categories::truncate();

		Categories::create([
			'name' => 'Startups'
		]);

	}

}