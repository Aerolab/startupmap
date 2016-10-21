<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) 
		return Redirect::route('root');
});

Route::filter('auth.json', function(){
	if(Auth::guest())
		return Response::json(array(
			'status'	=>	'redirect',
			'redirect'	=>	route('root')
			));
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('admin', function(){

	if(Auth::user()->admin != 'y')
		return Redirect::route('root');

});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('guest.json', function(){
	if(Auth::check())
		return Response::json(array(
			'status'	=>	'error',
			'redirect'	=>	route('root')
			));
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});



Route::filter('valid.startup', function($route){
	if( ! Startup::find($route->getParameter('id')))
		return Redirect::route(Request::segment(1) == 'admin' ? 'startup.admin' : Request::segment(1) == 'manager' ? 'manager.dashboard' : 'startups')
						->with('notification', 'Sorry but we couldn\'t find the startup you\'re looking for.');
});

Route::filter('valid.country', function($route){
	if( ! Country::where('iso', $route->getParameter('iso')))
		return Redirect::route(Request::segment(1) == 'admin' ? 'country.admin' : 'root')
						->with('notification', 'Sorry but we couldn\'t find the country you\'re looking for.');
});

Route::filter('valid.user', function($route){
	if( ! User::find($route->getParameter('id')))
		return Redirect::route(Request::segment(1) == 'admin' ? 'user.admin' : 'startups')
						->with('notification', 'Sorry but we couldn\'t find the user you\'re looking for.');
});

Route::filter('valid.category', function($route){
	if( ! Category::find($route->getParameter('id')))
		return Redirect::route(Request::segment(1) == 'admin' ? 'category.admin' : 'root')
						->with('notification', 'Sorry but we couldn\'t find the category you\'re looking for.');
});

Route::filter('exists.startup', function($route){
	if( ! Startup::find($route->getParameter('startup_id')))
		return Response::json(array(
			'status'	=>	'error',
			'error'		=>	'Sorry, but we couldn\'t find the startup you\'re looking for.'
			), 400);
});

Route::filter('valid.reset_token', function($route){
	if( ! $user = User::where('remember_token', $route->getParameter('token'))->first())
		return Redirect::route('root');
});


Route::filter('is.startup', function($route){
	if( ! Startup::find($route->getParameter('id')))
		return Request::ajax() ? Response::json(array('Bad request'), 400) : Redirect::route('root');
});

Route::filter('is_startup_manager', function($route){
	if(@Auth::user()->startups()->where('startup_id', $route->getParameter('id'))->first()->is_admin != 'y')
		return Redirect::route('manager.dashboard')
						->with('error', 'You don\'t have access to this startup.');
});