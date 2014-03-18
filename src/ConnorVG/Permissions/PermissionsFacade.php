<?php namespace ConnorVG\Permissions;

class PermissionsFacade extends \Illuminate\Support\Facades\Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'permissions'; }

}
