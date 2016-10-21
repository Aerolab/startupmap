<?php namespace StartupMap\Category;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
interface CategoryInterface {
	public function all($orderBy = 'id', $order = 'asc');
	public function find($value, $field = 'id');
	public function findBy($args = array());
	public function create($input);
	public function update(\Category $category, $input);
	public function delete(\Category $category);
}