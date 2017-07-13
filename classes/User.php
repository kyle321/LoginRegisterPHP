<?php

class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;

	public function __construct($user=null)
	{
		$this->_db=DB::getInstance();

		$this->_sessionName=Config::get('sessions/session_name');
		$this->_cookieName=Config::get('remember/cookie_name');
		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user=Session::get($this->_sessionName);
				if ($this->find($user)) {
					$this->_isLoggedIn=true;
				}else{
					#process logout
				}
			}
		}else{
			$this->find($user);
		}
	}
	public function create($fields=[])
	{
		if (!$this->_db->insert('users',$fields)) {
			throw new Exception("There was a problem creating an account", 1);
			
		}
	}
	public function exists()
	{
		return (!empty($this->_data))? true : false;
	}
	public function find($user=null)
	{
		if ($user) {
			$field=(is_numeric($user)? 'id': 'username');
			$data=$this->_db->get('users',[$field, '=',$user]);
			if ($data->count()) {
				$this->_data=$data->first();
				return true;
			}
		}
		return false;
	}
	public function hasPermission($key)
	{
		$group=$this->_db->get('groups',['id', '=', $this->data()->group]);
		if ($group) {
			 $permissions=json_decode($group->first()->permissions, true);
			 if ($permissions[$key] == true) {
			 	return true;
			 }
		}
		return false;
	}
	public function update($fields=[], $id=null)
	{
		if (!$id && $this->isLoggedIn()) {
			$id=$this->data()->id;
		}
		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception("problem with updating", 1);
			
		}
	}
	public function login($username=null, $password=null, $remember)
	{
		$user=$this->find($username);
		if ($user) {
			if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
				Session::put($this->_sessionName, $this->data()->id);
				if ($remember) {
					$hash=Hash::unique();
					$hashCheck=$this->_db->get('users_session', ['user_id','=',$this->data()->id]);
					if (!$hashCheck->count()) {
						$this->_db->insert('users_session', [
							'user_id'=>$this->data()->id,
							'hash'=>$hash
							]);
					}else{
						$hash=$hashCheck->first()->hash;
					}
					Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expirery'));
				}
				return true;
			}
		}
		return false;
	}
	public function logout()
	{
		Session::delete($this->_sessionName);
	}
	public function data()
	{
		return $this->_data;
	}
	public function isLoggedIn()
	{
		return $this->_isLoggedIn;
	}
}