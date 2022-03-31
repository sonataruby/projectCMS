<?php namespace App\Models;

use CodeIgniter\Model;


class UserProfileModel extends Model
{
	protected $table = 'users_profile';
    protected $primaryKey = 'id';

    public function getProfile(){
    	$user = user();
    	$data = $this->find($user->id);
    	$data["email"] = $user->email;
    	$data["username"] = $user->username;
    	return (Object)$data;
    }
}