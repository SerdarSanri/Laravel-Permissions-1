<?php namespace ConnorVG\Permissions;

use Config;

trait HasPermission
{

	/**
	 * @Return all permissions that this user has
	 */
	public function permissions()
	{
		return $this->belongsToMany('ConnorVG\Permissions\Permission', 
			'permissions', 'user_id', 'permission_id');
	}

	/**
	 * Has a permission.
	 *
	 * @param string $key unique key
	 * @return bool
	 */
	public function hasPermission($key)
	{
		return $this->hasPermissions([$key]);
	}

	/**
	 * Has permissions.
	 *
	 * @param array $keys unique keys
	 * @return bool
	 */
	public function hasPermissions($keys)
	{
		foreach ($this->permissions as $permission)
		{
			foreach ($keys as $key)
			{
				if ($permission->key == $key)
				{
					$keys = array_diff($keys, [$key]);

					if (count($keys) == 0)
						return true;
				}
			}
		}

		return false;
	}

	/**
	 * Adds a permission.
	 *
	 * @param string $key unique key
	 * @return this instance
	 */
	public function attachPermission($key)
	{
		return $this->attachPermissions([ $key ]);
	}

	/**
	 * Adds a collection of permissions.
	 *
	 * @param array $keys unique keys
	 * @return this instance
	 */
	public function attachPermissions($keys)
	{
		if (count($keys) < 1) 
			return $this;

		$permissions = Permission::where(function($query) use (&$keys)
		{
			foreach($keys as $key)
			{
				$query->orWhere('key', $key);
			}
		});

		foreach ($permissions->get() as $permission)
		{
			if (!$this->hasPermission($permission->key))
				$this->permissions()->attach($permission->id);
		}

		return $this;
	}

	/**
	 * Removes a permission.
	 *
	 * @param string $key unique key
	 * @return this instance
	 */
	public function detachPermission($key)
	{
		return $this->detachPermissions([ $key ]);
	}

	/**
	 * Removes a collection of permissions.
	 *
	 * @param array $keys unique keys
	 * @return this instance
	 */
	public function detachPermissions($keys)
	{
		if (count($keys) < 1) 
			return $this;

		foreach ($this->permissions as $permission)
		{
			if (in_array($permission->key, $keys))
				$this->permissions()->detach($permission->id);
		}

		return $this;
	}
}