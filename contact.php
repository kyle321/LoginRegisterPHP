<?php 

include_once 'core/init.php';
$user=new User();
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate=new Validate();
		$validation=$validate->check($_POST,[
			'username'=>[
			'required'=>true,
			'mini'=>2,
			],
			'email'=>[
			'required'=>true,
			'email'=>'email'
			],
			'message'=>[
			'required'=>true,
			'max'=>120
			]
			]);
		if ($validation->passed()) {
			$user->make([
				'username'=>Input::get('username'),
				'email'=>Input::get('email'),
				'message'=>Input::get('message')
				]);
			Session::flash('success', "Message sent successful");
			Redirect::to('index.php');
		}else{
			$msg=$validation->errors();
		}
	}
	
}

require_once 'header.php';

require_once 'navigation.php';

?>
<div class="container">
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
			<input type="text" name="username" class="form-control" id="username" value="<?php echo $user->data()->username;?>" autocomplete="off">
		</div>

		<div class="form-group">
			<label for="email" class="col-lg-2 control-label">Email</label>
			<input type="email" name="email" class="form-control" value="<?php echo escape(Input::get('email'));?>" id="email">
		</div>

		<div class="form-group">
			<label for="message" class="col-lg-2 control-label">Message</label>
			<textarea name="message" class="form-control" value="<?php echo escape(Input::get('message'));?>" id="message" rows="10" cols="60"></textarea>
		</div>
		<div class="form-group">
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" class="form-control btn-info" name="submit" value="Submit">
		</div>
				
	</form>
</div>




<?php 
require_once 'footer.php';

?>
