<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


if (App::environment('local')) {
	Route::get('godlogin', function(){
		Auth::loginUsingId(1);
		return Redirect::route('root');
	});

}

Common::globalXssClean();

include('macros.php');

//LANDING -> Route::get('/', function(){ return View::make('newlanding'); });
include('routes/manager.php');
include('routes/admin.php');
include('routes/api.php');
include('routes/errors.php');

Route::get('markers.xml', function(){

    // create new sitemap object
    $sitemap = App::make("sitemap");

    // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
    // by default cache is disabled
    // $sitemap->setCache('laravel.sitemap', 3600);

    $markers = Startup::all()->toArray();
    // print_r($markers);

    // check if there is cached sitemap and build new only if is not
    if (!$sitemap->isCached())
    {
         // add item to the sitemap (url, date, priority, freq)
         $sitemap->add(URL::to('/'));

         // get all posts from db
         // $posts = DB::table('posts')->orderBy('created_at', 'desc')->get();


         // add every post to the sitemap
         foreach ($markers as $marker)
         {
         	// echo "http://startupmap.la/".$marker['country_slug']."/".$marker['category_slug']."/".$marker['id']."/".$marker['slug'];
            $sitemap->add($marker['permalink'], $marker['updated_at']);
         }
    }

    // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
    return $sitemap->render('xml');

});


Route::any('slacker', 'MainController@slacker');
Route::any('slacker_redir/{id}',  array(
	'as'	=> 'slack_redirect',
	'uses' => 'MainController@slacker_redirect'
	));

// Guest only routes
Route::group(array( 'before' => 'guest' ), function(){

		// Validate accunt
		Route::get('validate/{key}', array(
			'uses'	=>	'UserController@validate',
			'as'	=>	'user.validate'
			));

		// Reset password
		Route::group(array(
			'prefix'	=>	'recover/{token}',
			'as'		=>	'reset_password',
			'before'	=>	'valid.reset_token'
			), function(){
			Route::get('/', 'ResetController@edit');
			Route::post('/', 'ResetController@update');
		});

	});

Route::group(array( 'before' => 'auth' ), function(){

	Route::get('logout', 'SessionController@destroy');

});

Route::get('/{countryName?}', array(
	'as'	=>	'root',
	'uses'	=>	'MainController@index'
	));

foreach(Category::all() as $category){
	Route::get('{countryName}/' . $category->slug() . '/{id}/{startup}', array(
		'as'	=>	'startup.url',
		'uses'	=>	'MainController@index'
		));
	
	Route::get('{countryName}/' . $category->slug(), 'MainController@index');
	Route::get('{countryName}/all', 'MainController@index');
}

Route::get('{countryName}/{category}/{id}/{startup}', array(
	'as'	=>	'startup.permalink',
	'uses'	=>	'MainController@index'
	));
