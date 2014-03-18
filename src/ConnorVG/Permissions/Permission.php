<?php namespace ConnorVG\Permissions;

class Permission extends \Illuminate\Database\Eloquent\Model {

	protected $guarded = [];

	public function users()
	{
		return $this->hasMany(Config::get('auth.model'));
	}

}