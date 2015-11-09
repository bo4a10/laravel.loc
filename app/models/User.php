<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	//связь между ролями и пользователями
	public function roles()
	{
		return $this->belongsToMany('Role');
	}

	public function isAdmin()
	{
		$admin_role = Role::whereRole('admin')->first();
		return $this->roles->contains($admin_role->id);
	}

	public function isManager()
	{
		$manager_role = Role::whereRole('manager')->first();
		return $this->roles->contains($manager_role->id) || $this->isAdmin();
	}

	public function isModerator()
	{
		$admin_role = Role::whereRole('admin')->first();
		return $this->roles->contains($admin_role->id) || $this->isAdmin();
	}

	public function isRegular()
	{
		$roles = array_filter($this->roles->toArray());
		return empty($roles);
	}

}
