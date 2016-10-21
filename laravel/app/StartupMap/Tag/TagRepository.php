<?php namespace StartupMap\Tag;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class TagRepository implements TagInterface {

	protected $validator;

	public function __construct($validator = false){
		$this->validator = $validator;
	}

	public function all($orderBy = 'id', $order = 'asc')
	{
		return \Tag::orderBy($orderBy, $order)->get();
	}

	public function find($value, $field = 'id')
	{
		return \Tag::where($field, $value)->first();
	}

	public function findBy($args = array())
	{
		$tags = \Tag::orderBy('id', 'asc');

		foreach($args as $field => $value)
			$tags->where($field, $value);

		return $tags->get();
	}

	public function create($input)
	{
		$this->validator->run($input);

		return \Tag::create(array(
			'tag'			=>	$input['tag']
			));
	}

	public function update(\Tag $tag, $input)
	{
		$this->validator->run($input);
		
		$tag->update(array(
			'tag'			=>	$input['tag']
			));

		return $tag;
	}

	public function delete(\Tag $tag)
	{
		$tag->delete();

		return true;
	}

}