<?php

/** 
 * Startup Manager
 *
 * @package StartupsMap
 * @version 0.1
 */
Route::group(array( 'prefix' => 'manager', 'before' => 'auth' ), function(){

	// Dashboard
	Route::get('/', array( 'as' => 'manager.dashboard', 'uses' => '\StartupMap\Manager\Controllers\Main@index' ));

	// Startup
	Route::group(array( 'prefix' => '{id}-{startup}', 'before' => 'valid.startup|is_startup_manager' ), function(){

		Route::get('/', array( 'as' => 'manager.startup.index', 'uses' => '\StartupMap\Manager\Controllers\Startups@index' ));
		Route::post('add_member', array( 'as' => 'manager.startup.member.add', 'uses' => '\StartupMap\Manager\Controllers\Startups@post_add_member' ));

	});

});