<?php namespace StartupMap\Admin\Controllers;

class Tags extends \Controller {

	protected $tags;

	/**
	 * @since 0.3
	 */
	public function __construct(\StartupMap\Tag\TagInterface $tags){
		$this->tags = $tags;
	}

	/**
	 * @since 0.3
	 */
	public function index(){
		return \View::make('admin::tag.list')
					->with('tags', $this->tags->all())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.3
	 */
	public function show($id, $name){
		return \View::make('admin::tag.show')
					->with('tag', $this->tags->find($id))
					->with('message', \Session::get('notification'));
	}

	/**
	 * @since 0.3
	 */
	public function create(){
		return \View::make('admin::tag.form')
					->with('mode', 'create')
					->with('message', \Session::get('notification'));
	}

	/**
	 * @since 0.3
	 */
	public function store(){
		try {
			$tag = $this->tags->create(\Input::all());

			return \Redirect::route('tag.admin')->with('notification', 'The tag &quot;' . $tag->name . '&quot; was created succesfully.');
		}
		catch(\StartupMap\Validation\FormValidationException $e){
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.3
	 */
	public function edit($id, $name){
		return \View::make('admin::tag.form')
					->with('mode', 'edit')
					->with('tag', \Tag::find($id))
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.3
	 */
	public function update($id, $name){
		try {
			$tag = $this->tags->update($this->tags->find($id), \Input::all());

			return \Redirect::back()->with('notification', $tag->tag . ' has been updated succesfully.');
		}
		catch(\StartupMap\Validation\FormValidationException $e){
			return \Redirect::back()->withInput()->withErrors($e->getErrors());
		}
	}

	/**
	 * @param 	$id 	integer
	 * @param 	$name 	string
	 * @since 	0.3
	 */
	public function destroy($id, $name)
	{
		$this->tags->delete($this->tags->find($id));

		return \Redirect::back()->with('notification', 'The tag was deleted succesfully.');
	}

}