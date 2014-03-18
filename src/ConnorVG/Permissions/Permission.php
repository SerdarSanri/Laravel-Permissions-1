<?php namespace ConnorVG\Permissions;

class Permission extends \Illuminate\Database\Eloquent\Model {

	protected $guarded = [];

	protected $table = Config::get('permissions::permissions.table');

	/**
	 * @Return all users that have this permission
	 */
	public function users()
	{
		return $this->hasMany(Config::get('auth.model'), 'user_id', 'permission_id');
	}

}