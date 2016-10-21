<?php namespace StartupMap\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class ClaimProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('StartupMap\Claim\ClaimInterface', function(){
			return new \StartupMap\Claim\ClaimRepository;
		});
	}

}