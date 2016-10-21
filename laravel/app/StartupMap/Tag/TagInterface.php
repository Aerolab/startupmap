<?php namespace StartupMap\Tag;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
interface TagInterface {
	public function all($orderBy = 'id', $order = 'asc');
	public function find($value, $field = 'id');
	public function findBy($args = array());
	public function create($input);
	public function update(\Tag $tag, $input);
	public function delete(\Tag $tag);
}