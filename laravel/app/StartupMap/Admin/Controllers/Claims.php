<?php namespace StartupMap\Admin\Controllers;

class Claims extends \Controller 
{

	protected $claims;

	/**
	 * @since 0.2
	 */
	public function __construct(\StartupMap\Claim\ClaimInterface $claims)
	{
		$this->claims = $claims;
	}

	/**
	 * @since 0.2
	 */
	public function index($country = false)
	{
		return \View::make('admin::claim.list')
					->with('claims', $this->claims->all())
					->with('user', \Auth::user())
					->with('message', \Session::get('notification'));
	}

	/**
	 * @param 	$claim 	integer
	 * @since 	0.2
	 */
	public function accept($claim)
	{
		if( ! $this->claims->accept($this->claims->find($claim)))
			return \Redirect::back()->with('error', 'We couldn\'t find that claim. Sorry');

		return \Redirect::back()->with('message', 'The claim has been accepted succesfully.');
	}

	/**
	 * @param 	$claim 	integer
	 * @since 	0.2
	 */
	public function deny($claim)
	{
		if( ! $this->claims->deny($this->claims->find($claim)))
			return \Redirect::back()->with('error', 'We couldn\'t find that claim. Sorry');

		return \Redirect::back()->with('message', 'The claim has been denied.');
	}

}
