<?php namespace StartupMap\Claim;

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
interface ClaimInterface {
	public function all($flag = false, $orderBy = 'id', $order = 'asc');
	public function find($id);
	public function accept(\Claim $claim);
	public function deny(\Claim $claim);
}