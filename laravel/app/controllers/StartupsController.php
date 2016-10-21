<?php

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class StartupsController extends Controller 
{

	protected $startups;

	public function __construct(StartupMap\Startup\StartupInterface $startups)
	{
		$this->startups = $startups;
	}

	/**
	 * @since 0.2
	 */
	public function api_index()
	{
		return Response::json($this->startups->all(true), 200);
	}

	/**
	 * @since 0.2
	 */
	public function api_store()
	{
		try
		{
			return Response::json($this->startups->create(array_merge(Input::all(), array(
				'user_id'	=>	Auth::user()->id,
				'approved'	=>	'y',
				'parent'	=>	0
				))), 201);
		}
		catch(StartupMap\Validation\FormValidationException $e)
		{
			return Response::json($e->getErrors(), 400);
		}
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function api_show($id)
	{
		if( ! $startup = $this->startups->find($id))
			return Response::json(array('Startup not found'), 404);

		return Response::json($startup, 200);
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function api_update($id)
	{
		try
		{
			return Response::json($this->startups->update($id, Input::all()), 200);
		}
		catch(StartupMap\Validation\FormValidationException $e)
		{
			return Response::json($e->getErrors(), 400);
		}
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function api_destroy($id)
	{
		if( ! $this->startups->delete($id))
			return Response::json(array('Bad request'), 400);

		return Response::json(array('Startup #'. $id . ' deleted'), 200);
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function api_claim($id)
	{
		try
		{
			if( ! $this->startups->claim($id, Input::all()))
				return Response::json(array(
					'error'	=>	Lang::get('error.claim_invalid')
					), 400);

			return Response::json(array(
				'message'	=>	Lang::get('message.claim_pending')
				), 200);
		}
		catch(StartupMap\Validation\FormValidationException $e)
		{
			return Response::json($e->getErrors(), 400);
		}
	}

	public function api_map()
	{
		return Response::json($this->startups->map(array(
			'country'		=>	Input::get('country', 'AR'),
			'categories'	=>	Input::has('categories') ? explode(',', Input::get('categories')) : array(),
			'text'			=>	Input::get('text', '')
			)), 200);
	}

}
