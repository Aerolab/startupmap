<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Linkedin' => array(
            'client_id'     => '755nb5ls41be58',
            'client_secret' => 'TyIOUmO8eMKPAWmY',
            'scope' => [ 'r_basicprofile', 'r_emailaddress' ]
        ),		

	)

);