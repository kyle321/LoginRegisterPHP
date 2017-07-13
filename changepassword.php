<?php

require_once 'core/init.php';
$user=new User();
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate=new Validate();
		$validation=$validate->check($_POST, [
				'password_current'=>[
					'required'=>true,
					'min'=>6
				],
				'new_password'=>[
					'required'=>true,
					'min'=>6
				],
				'confirm_password'=>[
					'required'=>true,
					'min'=>6,
					'matches'=>'new_password'
				]
			]);
		if ($validation->passed()) {
			if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				echo "Your current password is wrong";
			}else{
				$salt=Hash::salt(32);
				$user->update([
						'password'=>Hash::make(Input::get('new_password'), $salt),
						'salt'=>$salt
					]);
				Session::flash('home', "Your password has been changed");
				Redirect::to('index.php');
			}
		}else{
			foreach ($validation->errors() as $error) {
				echo $error,"<br>";
			}
		}
	}
}

?>
<div class="container">
	<form action="" method="post" class="form-horizontal">
		<div class="form-group">
			<label for="password_current" class="col-lg-2 control-label">Current Password</label>
			<input type="password" class="form-control" name="password_current" id="password_current">
		</div>
		<div class="form-group">
			<label for="new_password" class="col-lg-2 control-label">New Password</label>
			<input type="password" class="form-control" name="new_password" id="new_password">
		</div>
		<div class="form-group">
			<label for="confirm_password" class="col-lg-2 control-label">COnfirm Password</label>
			<input type="password" class="form-control" name="confirm_password" id="confirm_password">
		</div>
		<div class="form-group">
			<input type="submit" name="submit" class="form-control btn-success" value="submit">
			<input type="hidden" name="token" value="<?php echo Token::generate();?>">
		</div>
		
		
	</form>
</div>

