<?php namespace StartupMap\User;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
interface UserInterface {
	public function all($orderBy = 'id', $order = 'asc');
	public function find($value, $field = 'id');
	public function findBy($args = array());
	public function create($input, $generatePassword = false, $sendValidation = true, $forceLogin = false);
	public function update(\User $user, $input);
	public function delete(\User $user);
}