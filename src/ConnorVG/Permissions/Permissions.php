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

	public function create($name, $key)
	{
		return Permission::create([
			'name' => $name,
			'key' => $key
		]);
	}

	public function hasAtleastOneOf($user, $permissions)
	{
		foreach ($permissions as $permission)
			if ($user->hasPermission($permission))
				return true;

		return false;
	}
}