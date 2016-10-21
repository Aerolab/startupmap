<?php

/**
 * @package StartupMap
 * @version 0.2
 * @author Mauro Casas
 */
class AdminController extends Controller 
{

	public function index()
	{
		return View::make('admin::dashboard');
	}

}
