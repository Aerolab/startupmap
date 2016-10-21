<?php

Form::macro('users_dropdown', function($name, $value = false, $attributes = []){

	$options = [
		0	=> 'Nobody'
	];

	foreach(Profile::orderBy('name')->get() as $profile)
		$options[$profile->user_id] = $profile->name . ' ' . $profile->last_name;

	return Form::select($name, $options, $value, $attributes);

});

Form::macro('countries', function($__){

	$options = [];

	foreach(Country::orderby('name', 'asc')->get() as $country)
		$options[$country->iso] = e($country->name);

	return Form::select($__['name'], $options, isset($__['value']) ? $__['value'] : false, isset($__['attributes']) ? $__['attributes'] : []);

});