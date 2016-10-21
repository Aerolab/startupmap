<?php namespace StartupMap\Category;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class CategoryRepository implements CategoryInterface {

	protected $validators;

	public function __construct(array $validators = array()){
		$this->validators = $validators;
	}

	/**
	 * @param $orderBy string
	 * @param $order string
	 * @since 0.2
	 */
	public function all($orderBy = 'id', $order = 'asc')
	{
		return \Category::orderBy($orderBy, $order)->get();
	}

	/**
	 * @param $value mixed
	 * @param $field string
	 * @since 0.2
	 */
	public function find($value, $field = 'id')
	{
		return \Category::where($field, $value)->first();
	}

	/**
	 * @param $args mixed
	 * @since 0.2
	 */
	public function findBy($args = array())
	{
		$categories = \Category::orderBy('id', 'asc');

		foreach($args as $field => $value)
			$categories->where($field, $value);

		return $categories->get();
	}

	/**
	 * @param $input array
	 * @since 0.2
	 */
	public function create($input)
	{
		$this->validators['create']->run($input);

		return \Category::create(array(
			'name'	=>	$input['name'],
			'order'	=>	$input['order'],
			'visible'	=>	$input['visible']
			));
	}

	/**
	 * @param $category Category
	 * @param $input mixed
	 * @since 0.2
	 */
	public function update(\Category $category, $input)
	{
		$this->validators['update']->run($input);
		
		$category->update(array(
			'name'	=>	$input['name'],
			'order'	=>	$input['order'],
			'visible'	=>	$input['visible']
			));

		return $category;
	}

	/**
	 * @param $category Category
	 * @since 0.2
	 */
	public function delete(\Category $category)
	{
		$category->delete();

		return true;
	}

}