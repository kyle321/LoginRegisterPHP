<?php
require_once('core/init.php');
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate=new Validate();
		$validation=$validate->check($_POST,[
			'username'=>['required'=>true],
			'password'=>['required'=>true]
			]);
		if ($validation->passed()) {
			$user=new User();
			$remember=(Input::get('remember') ==='on' )? true : false;
			$login=$user->login(Input::get('username'), Input::get('password'), $remember);
			if ($login) {
				Session::flash('success',"Your login was successful");
				Redirect::to('index.php');
			}else{
				echo "login failed";
			}
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
	<div class="panel panel-default">
	  <div class="panel-heading">
	     <h3 class="panel-title text-center">Login Here</h3>
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
	    <form class="form-horizontal" action="" method="POST">
	      <fieldset>
	        <div class="form-group">
	          <label for="username" class="col-lg-2 control-label">Username</label>
	          <div class="col-lg-10">
	            <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="false">
	          </div>
	        </div>
	        <div class="form-group">
	          <label for="password" class="col-lg-2 control-label">Password</label>
	          <div class="col-lg-10">
	            <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="false">
	            <div class="form-group">
	              <label for="remember" class="col-lg-2 control-label">
	                <input type="checkbox" id="remember" name="remember"> Remember Me
	              </label>
	            </div>
	          </div>
	        </div>
	        <div class="form-group">
	        	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	        	<label for="password" class="col-lg-2 control-label"></label>
	        	<div class="col-lg-10">
	        		<input type="submit" name="" class="form-control btn-info" value="Login">
	        	</div>
	        </div>
	      </fieldset>
	    </form>
	  </div>
	</div>
</div>
<?php 

	require_once('footer.php');
?>
