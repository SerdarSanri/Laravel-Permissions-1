<?php

Route::filter('permissions', function($route, $request, $permissions)
{
	if (Auth::guest()) return Redirect::guest('login');

	$permissions = explode('&', $permissions);
	if (!Auth::user()->hasPermissions($permissions)) 
			return View::make(Config::get('permissions::errors.permissions'));
});