<?php

/** 
 * Admin Routes
 *
 * @package StartupsMap
 * @version 0.1
 */
Route::group(array( 'prefix' => 'admin', 'before' => 'auth|admin' ), function(){

	Route::group(array('prefix' => 'slacker'), function(){
		Route::group(array( 'prefix' => '{claim}' ), function(){
			Route::get('accept', array( 'as' => 'claim.slack.accept', 'uses' => 'ClaimController@accept' ));
			Route::get('deny', array( 'as' => 'claim.slack.deny', 'uses' => 'ClaimController@deny' ));
		});
	});

	// Dashboard
	Route::get('/', array( 'as' => 'admin.dashboard', 'uses' => 'AdminController@index' ));

	// Claims
	Route::group(array( 'prefix' => 'claim' ), function(){

		Route::get('list', array( 'as' => 'claim.admin', 'uses' => 'StartupMap\Admin\Controllers\Claims@index' ));

		Route::group(array( 'prefix' => '{claim}' ), function(){
			Route::get('accept', array( 'as' => 'claim.admin.accept', 'uses' => 'StartupMap\Admin\Controllers\Claims@accept' ));
			Route::get('deny', array( 'as' => 'claim.admin.deny', 'uses' => 'StartupMap\Admin\Controllers\Claims@deny' ));
		});

	});

	// Users
	Route::group(array( 'prefix' => 'user' ), function(){

			// List all users
			Route::get('list', array( 'as' => 'user.admin', 'uses' => 'StartupMap\Admin\Controllers\Users@index' ));

			// Create a user
			Route::group(array( 'prefix' => 'create', 'as' => 'user.admin.create' ), function(){
					Route::get('/', 'StartupMap\Admin\Controllers\Users@create');
					Route::post('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Users@store' ));
				});

			// Single user
			Route::group(array( 'prefix' => '{id}-{name}', 'before' => 'valid.user' ), function(){

					Route::get('/', array( 'as' => 'user.admin.show', 'uses' => 'StartupMap\Admin\Controllers\Users@show' ));

					Route::group(array( 'prefix' => 'edit', 'as' => 'user.admin.edit' ), function(){
							Route::get('/', 'StartupMap\Admin\Controllers\Users@edit');
							Route::put('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Users@update' ));
						});

					Route::get('delete', array( 'as' => 'user.admin.destroy', 'uses' => 'StartupMap\Admin\Controllers\Users@destroy' ));

				});

	});

	// Countries
	Route::group(array( 'prefix' => 'country' ), function(){

		// List all countries
		Route::get('list', array( 'as' => 'country.admin', 'uses' => 'StartupMap\Admin\Controllers\Countries@index'));

		// Country by ISO
		Route::group(array( 'prefix' => '{iso}-{name}', 'before' => 'valid.country' ), function(){
			Route::get('/', array( 'as' => 'country.admin.show', 'uses' => 'StartupMap\Admin\Controllers\Countries@show'));
			Route::get('toggle', array( 'as' => 'country.admin.update', 'uses' => 'StartupMap\Admin\Controllers\Countries@update'));
		});

	});

	// Startups
	Route::group(array( 'prefix' => 'startup' ), function(){

			// List all startups & country
			Route::get('list/{country?}', array( 'as' => 'startup.admin', 'uses' => 'StartupMap\Admin\Controllers\Startups@index' ));

			// Create a startup
			Route::group(array( 'prefix' => 'create', 'as' => 'startup.admin.create' ), function(){
					Route::get('/', 'StartupMap\Admin\Controllers\Startups@create');
					Route::post('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Startups@store' ));
				});

			// Single startup
			Route::group(array( 'prefix' => '{id}-{name}', 'before' => 'valid.startup' ), function(){

					Route::get('/', array( 'as' => 'startup.admin.show', 'uses' => 'StartupMap\Admin\Controllers\Startups@show' ));

					Route::group(array( 'prefix' => 'edit', 'as' => 'startup.admin.edit' ), function(){
							Route::get('/', 'StartupMap\Admin\Controllers\Startups@edit');
							Route::put('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Startups@update' ));
						});

					Route::get('delete', array( 'as' => 'startup.admin.destroy', 'uses' => 'StartupMap\Admin\Controllers\Startups@destroy' ));

				});

		});

	// Categories
	Route::group(array( 'prefix' => 'category' ), function(){

			// List all categories
			Route::get('list', array( 'as' => 'category.admin', 'uses' => 'StartupMap\Admin\Controllers\Categories@index' ));

			// Create a category
			Route::group(array( 'prefix' => 'create', 'as' => 'category.admin.create' ), function(){
					Route::get('/', 'StartupMap\Admin\Controllers\Categories@create');
					Route::post('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Categories@store' ));
				});

			// Single category
			Route::group(array( 'prefix' => '{id}-{name}', 'before' => 'valid.category' ), function(){

					Route::get('/', array( 'as' => 'category.admin.show', 'uses' => 'StartupMap\Admin\Controllers\Categories@show' ));

					Route::group(array( 'prefix' => 'edit', 'as' => 'category.admin.edit' ), function(){
							Route::get('/', 'StartupMap\Admin\Controllers\Categories@edit');
							Route::put('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Categories@update' ));
						});

					Route::get('delete', array( 'as' => 'category.admin.destroy', 'uses' => 'StartupMap\Admin\Controllers\Categories@destroy' ));

				});

		});

	// Tags
	Route::group(array( 'prefix' => 'tag' ), function(){

			// List all tags
			Route::get('list', array( 'as' => 'tag.admin', 'uses' => 'StartupMap\Admin\Controllers\Tags@index' ));

			// Create a tag
			Route::group(array( 'prefix' => 'create', 'as' => 'tag.admin.create' ), function(){
					Route::get('/', 'StartupMap\Admin\Controllers\Tags@create');
					Route::post('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Tags@store' ));
				});

			// Single tag
			Route::group(array( 'prefix' => '{id}-{name}', 'before' => 'valid.tag' ), function(){

					Route::get('/', array( 'as' => 'tag.admin.show', 'uses' => 'StartupMap\Admin\Controllers\Tags@show' ));

					Route::group(array( 'prefix' => 'edit', 'as' => 'tag.admin.edit' ), function(){
							Route::get('/', 'StartupMap\Admin\Controllers\Tags@edit');
							Route::put('/', array( 'before' => 'csrf', 'uses' => 'StartupMap\Admin\Controllers\Tags@update' ));
						});

					Route::get('delete', array( 'as' => 'tag.admin.destroy', 'uses' => 'StartupMap\Admin\Controllers\Tags@destroy' ));

				});

		});

});