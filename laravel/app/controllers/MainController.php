<?php

/** 
 * @package 	StartupsMap
 * @version 	0.1
 */
class MainController extends Controller 
{

	protected $randomizer = array(
		'links' => array(
			'http://www.youtube.com/watch?v=x47NYUbtYb0',
			'http://www.youtube.com/watch?v=X5Izm1LQfw4',
			'http://www.youtube.com/watch?v=gy1B3agGNxw',
			'http://www.youtube.com/watch?v=dQw4w9WgXcQ',
			'http://www.youtube.com/watch?v=4r7wHMg5Yjg',
			'http://www.youtube.com/watch?v=Fc1P-AEaEp8',
			'http://www.youtube.com/watch?v=btwG0E4xke0',
			'http://www.youtube.com/watch?v=ZZ5LpwO-An4',
			'http://www.youtube.com/watch?v=jlSF0dtDRD8',
			),
		'texts' =>  array(
			'Happy birthday',
			'Get ready',
			'Be careful what you wish for, punk',
			'Hasta la vista, baby',
			'Time for Tetris',
			'Don\'t click the link. Seriously.',
			'Robert, compra CheeseCake'
			)
		);

	/**
	 * @since 	0.1
	 */
	public function index($countryName = '', $startupID = '0', $startupName = false)
	{
		$countries = array();
		$currentCountry = array();
		$showCountryModal = false;
		$geoCountryISO = GeoIP::getLocation()['isoCode'];

		$pageTitle = 'StartupMap &mdash; Mapa de Startups Latinoamericanas';

		foreach(Country::where('enabled', 'y')->get() as $country)
		{
			$countries[$country->iso] = array(
				'slug'	=>	$country->slug(),
				'iso'	=>	$country->iso,
				'name'	=>	$country->name,
				'cities'	=>	$country->cities->toArray()
				);

			if($country->slug() == $countryName)
				$currentCountry = $countries[$country->iso];
		}

		if(array_key_exists($geoCountryISO, $countries) ) {
			$currentCountry = $countries[$geoCountryISO];
		}

		if ($countryName != "" && empty($currentCountry)) {
			App::abort(404);
		}

		if (count($currentCountry) != 0) {
			$pageTitle = 'StartupMap &mdash; ' . $currentCountry['name'];
		} else {
			$currentCountry = $countries[array_key_exists($geoCountryISO, $countries) ? $geoCountryISO : 'AR'];
			$showCountryModal = true;
		}

		if($startupID != 0 && $startup = Startup::find($startupID))
			$pageTitle = $startup->name . ' &mdash; StartupMap';


		return View::make('app')
					->with('categories', Category::orderby('order')->get())
					->with('country', $currentCountry)
					->with('countryList', $countries)
					->with('startupID', $startupID)
					->with('countryIP', $geoCountryISO)
					->with('startupData', $startupID != 0 ? Startup::find($startupID) : array())
					->with('pageTitle', $pageTitle)
					->with('showCountryModal', $showCountryModal)
					->with('tags', Tag::all());
	}

	// -----------------------------------------------------------------------

	public function api_upload($type)
	{
		try
		{
			if( ! in_array($type, array('banner', 'logo')))
				throw new Exception('Something went wrong...');

			$validation = Validator::make(Input::all(), array(
				$type . 'File'	=>	'image'
				));

			if($validation->fails())
				throw new Exception('Something went wrong...');

			$cropSizes = array(
				'logo'		=>	array(120, 120, 'thumb_'),
				'banner'	=>	array(370, 180, '')
				);

			// Resize & crop uploaded files
			if(Input::hasFile($type. 'File'))
			{
				$config = $cropSizes[$type];

				$file = Input::file($type. 'File');

				$newFilename = Str::random(128) . '.' . $file->getClientOriginalExtension();

				$file->move('uploads', $newFilename);

				if(is_array($config))
				{
					Image::load('uploads/' . $newFilename)
							->resize_crop($config[0], $config[1])
							->save('uploads/' . $config[2] . $newFilename, true);
				}

				return Response::json(array(
					'status'	=>	'success',
					'file'		=>	array(
						'name'	=>	$newFilename,
						'path'	=>	asset('uploads/' . $newFilename)
						)
					));
			}

			throw new Exception('Something went wrong...');
		}
		catch(Exception $e)
		{
			return Response::json(array(
				'status'	=>	'error',
				'error'		=>	$e->getMessage()
				));
		}
	}

	public function slacker_redirect($linkID)
	{
		return Redirect::to($this->randomizer['links'][$linkID]);
	}

	public function slacker()
	{
		$randomLink = rand(0, count($this->randomizer['links']) - 1);
		$link = route('slack_redirect', array('id' => $randomLink));
		\Slack::send(':banana: <' . $link . '|' . $this->randomizer['texts'][rand(0, count($this->randomizer['texts']) - 1)] . '> :banana:', '#random');
	}

}
