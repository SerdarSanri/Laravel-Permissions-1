<?php namespace ConnorVG\Permissions;

class Permissions
{
	/**
	 * Laravel application
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	public $app;

	/**
	 * Create a new permissions instance.
	 *
	 * @return void
	 */
	public function __construct($app)
	{
		$this->app = $app;
	}

	/**
	 * Create a new permission.
	 *
	 * @param string $name name
	 * @param string $key unique key
	 * @return ConnorVG\Permissions\Permission
	 */
	public function create($name, $key)
	{
		return Permission::create([
			'name' => $name,
			'key' => $key
		]);
	}

	/**
	 * Checks a user has at-least one of a permisson
	 *
	 * @param HasPermission $user owner of HasPermission
	 * @param array $permissions and array of permission keys
	 * @return ConnorVG\Permissions\Permission
	 */
	public function hasAtleastOneOf($user, $permissions)
	{
		foreach ($permissions as $permission)
			if ($user->hasPermission($permission))
				return true;

		return false;
	}
}