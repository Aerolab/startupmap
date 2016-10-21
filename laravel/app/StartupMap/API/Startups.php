<?php namespace StartupMap\API;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class Startups extends \Controller {

	protected $startups;

	public function __construct(\StartupMap\Startup\StartupInterface $startups){
		$this->startups = $startups;
	}

	/**
	 * @since 0.2
	 */
	public function index(){
		return \Response::json($this->startups->all(true), 200);
	}

	/**
	 * @since 0.2
	 */
	public function store(){
		try{
			return \Response::json($this->startups->create(array_merge(\Input::all(), array(
				'user_id'	=>	\Auth::user()->id,
				'approved'	=>	'y',
				'parent'	=>	0
				))), 201);
		}
		catch(\StartupMap\Validation\FormValidationException $e){
			return \Response::json($e->getErrors(), 400);
		}
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function show($id){
		if( ! $startup = $this->startups->find($id))
			return \Response::json(array('Startup not found'), 404);

		return \Response::json($startup, 200);
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function update($id){
		try{
			$startup = $this->startups->find($id);
			return \Response::json($this->startups->update($startup, array_merge(\Input::all(), array('user_id' => $startup->user_id, 'approved' => 'y', 'parent' => $startup->child_of))), 200);
		}
		catch(\StartupMap\Validation\FormValidationException $e){
			return \Response::json($e->getErrors(), 400);
		}
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function destroy($id){
		if( ! $this->startups->delete($id))
			return \Response::json(array('Bad request'), 400);

		return \Response::json(array('Startup #'. $id . ' deleted'), 200);
	}

	/**
	 * @param $id integer
	 * @since 0.2
	 */
	public function claim($id){
		try{
			if( ! $this->startups->claim($id, \Input::all()))
				return \Response::json(array(
					'error'	=>	\Lang::get('error.claim_invalid')
					), 400);

			return \Response::json(array(
				'message'	=>	\Lang::get('message.claim_pending')
				), 200);
		}
		catch(\StartupMap\Validation\FormValidationException $e){
			return \Response::json($e->getErrors(), 400);
		}
	}

	public function map(){
		return \Response::json($this->startups->map(array(
			'country'		=>	e(\Input::get('country', 'AR')),
			'categories'	=>	\Input::has('categories') ? explode(',', \Input::get('categories')) : array(),
			'text'			=>	e(\Input::get('text', ''))
			)), 200);
	}

}
