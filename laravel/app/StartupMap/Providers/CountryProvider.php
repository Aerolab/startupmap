<?php namespace StartupMap\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class CountryProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('StartupMap\Country\CountryInterface', function(){
			return new \StartupMap\Country\CountryRepository(array(
				'update' => $this->app->make('StartupMap\Country\Validation\Update')
				));
		});
	}

}