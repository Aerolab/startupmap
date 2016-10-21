<?php namespace StartupMap\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class CategoryProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('StartupMap\Category\CategoryInterface', function(){
			return new \StartupMap\Category\CategoryRepository(array(
				'create' => $this->app->make('StartupMap\Category\Validation\Create'),
				'update' => $this->app->make('StartupMap\Category\Validation\Update')
				));
		});
	}

}