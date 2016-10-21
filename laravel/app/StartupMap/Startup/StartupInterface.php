<?php namespace StartupMap\Startup;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
interface StartupInterface {
	public function all($array = false, $orderBy = 'id', $order = 'asc');
	public function find($value, $field = 'id');
	public function findBy($args = array());
	public function create($input);
	public function update(\Startup $startup, $input);
	public function delete(\Startup $startup);
	public function claim($startupID, $input);
	public function map($input);
	public function add_member(\Startup $startup, $email);
	public function remove_member(\Startup $startup);
}