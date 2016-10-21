<?php

/** 
 * API Routes
 *
 * @package StartupsMap
 * @version 0.1
 */

Route::group(array('prefix' => 'api'), function(){

	// Startups
	Route::group(array('prefix' => 'startup'), function(){

		Route::get('/', array('as' => 'startup.index', 'uses' => '\StartupMap\API\Startups@index'));
		Route::post('/', array('as' => 'startup.store', 'uses' => '\StartupMap\API\Startups@store'));
		Route::any('map', array('as' => 'startup.map', 'uses' => '\StartupMap\API\Startups@map'));

		Route::group(array('prefix' => '{id}', 'before' => 'is.startup'), function(){
			Route::get('/', array('as' => 'startup.show', 'uses' => '\StartupMap\API\Startups@show'));
			Route::put('/', array('as' => 'startup.update', 'uses' => '\StartupMap\API\Startups@update'));
			Route::delete('/', array('as' => 'startup.destroy', 'uses' => '\StartupMap\API\Startups@destroy', 'before' => 'is.admin'));
			Route::post('claim', array('as' => 'startup.claim', 'uses' => '\StartupMap\API\Startups@claim', 'before' => 'auth.json'));
		});

	});

});

Route::group(array(
	'prefix'	=>	'api'
	), function(){

	// Reset password
	Route::group(array(
		'prefix'	=>	'reset_password',
		'before'	=>	'guest.json',
		'as'		=>	'api.reset_password'
		), function(){
		Route::post('/', 'ResetController@api_reset_password');
	});

	// Login & LinkedIn OAuth
	Route::group(array(
		'prefix'	=>	'login',
		'before'	=>	'guest.json'
		), function(){

		// Email login
		Route::post('/', array(
			'as'	=>	'api.login',
			'uses'	=>	'SessionController@create'
			));

		// LinkedIn OAuth
		Route::any('linkedin', array(
			'as'	=>	'api.login.linkedin',
			'uses'	=>	'SessionController@oauth_linkedin'
			));

	});

	Route::get('logout', array(
		'as'	=>	'api.logout',
		'uses'	=>	'SessionController@destroy'
		));

	// Upload media
	Route::group(array(
		'prefix'	=> 'upload',
		'as'	=>	'api.upload'
		), function(){
			Route::any('{type}', 'MainController@api_upload');
	});

	// Users
	Route::group(array('prefix' => 'user' ), function(){

		Route::post('/', array(
			'as'	=>	'api.user.store',
			'uses'	=>	'UserController@api_store'
			));

	});

});