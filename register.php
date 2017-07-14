<?php
require_once('core/init.php');
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate=new Validate();
		$validation=$validate->check($_POST, [
			'username'=>[
				'required'=>true,
				'min'=>2,
				'max'=>20,
				'unique'=>'users'

			],
			'password'=>[
				'required'=>true,
				'min'=>6
			],
			'confirm_password'=>[
				'required'=>true,
				'matches'=>'password'
			],
			'name'=>[
				'required'=>true,
				'min'=>2,
				'max'=>50
			]
		]);

		if ($validation->passed()) {
			$user=new User();
			$salt=Hash::salt(32);			
				$user->create([
					'username'=>Input::get('username'),
					'password'=>Hash::make(Input::get('password'),$salt),
					'salt'=>$salt,
					'name'=>Input::get('name'),
					'joined'=>date('Y-m-d H:i:s'),
					'group'=>1
					]);
				Session::flash('success','You are now Registered, please log in to proceed');
				Redirect::to('login.php');
		}else{
			$msg=$validation->errors();
		}
	}
}
?>
<?php require_once('header.php'); 
	require_once('navigation.php');
?>

<div class="container">
<div class="panel panel-primary">
	  <div class="panel-heading">
	     <h3 class="panel-title text-center">Register Here</h3>
	  </div>
	  <div class="panel-body">
			 <?php 
				    if (isset($msg)) {
				    	?>
				    	<div class="alert alert-dismissible alert-danger">
				  	  <button type="button" class="close" data-dismiss="alert">&times;</button>
				  	   <ul>
				  	  <?php 
				  	  foreach ($msg as $error) {
				  	  	?>
				  	  	<li><?php echo $error;?></li>
				  	  	<?php
				  	  }

				  	  ?>	  	
				  	  </ul>
				  	</div>
				  	<?php 
				    }

				    ?>
			<form  class="form-horizontal" method="POST" action="">
				<div class="form-group">
					<label for="username" class="col-lg-2 control-label">Username</label>
					<div class="col-lg-10">
						<input type="text" name="username" class="form-control" id="username" value="<?php echo escape(Input::get('username'));?>" autocomplete="off">
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-lg-2 control-label">Password</label>
					<div class="col-lg-10">
						<input type="password" name="password" class="form-control" value="" id="password">
					</div>
				</div>

				<div class="form-group">
					<label for="confirm_password" class="col-lg-2 control-label">Confirm Password</label>
					<div class="col-lg-10">
						<input type="password" name="confirm_password" class="form-control" value="" id="confirm_password">
					</div>
				</div>

				<div class="form-group">
					<label for="name" class="col-lg-2 control-label">Name</label>
					<div class="col-lg-10">
						<input type="text" name="name" id="name" class="form-control" value="<?php echo escape(Input::get('name'));?>" >
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					<label for="name" class="col-lg-2 control-label"></label>
					<div class="col-lg-10">
						<input type="submit" class="form-control btn-info" name="submit" value="Submit">
					</div>
				</div>
						
			</form>
		</div>
	</div>
</div>
<?php 

	require_once('footer.php');
?>
