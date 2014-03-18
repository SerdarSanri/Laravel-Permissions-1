<?php namespace ConnorVG\Permissions;

use Config;

trait HasPermission
{
	public function permissions()
	{
		return $this->belongsToMany('ConnorVG\Permissions\Permission', 
			Config::get('permissions::permission.table'),
			'user_id', 'permission_id');
	}

	public function hasPermission($key)
	{
		return $this->hasPermissions([$key]);
	}

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

	public function attachPermission($key)
	{
		return $this->attachPermissions([ $key ]);
	}

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

	public function detachPermission($key)
	{
		return $this->detachPermissions([ $key ]);
	}

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