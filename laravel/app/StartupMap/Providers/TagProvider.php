<?php namespace StartupMap\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class TagProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('StartupMap\Tag\TagInterface', function(){
			return new \StartupMap\Tag\TagRepository($this->app->make('StartupMap\Tag\Validation\Form'));
		});
	}

}