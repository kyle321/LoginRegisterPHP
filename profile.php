<?php
require_once('core/init.php');
if (!$username=Input::get('user')) {
	Redirect::to('index.php');
}else{
$user=new User($username);
	if (!$user->exists()) {
		Redirect::to(404);
	}else{
		$data=$user->data();
	}

require_once 'header.php';
require_once 'navigation.php';
?>

<div class="jumbotron">
	<div class="container">
	  <div class="row">
	    <div class="col-md-8">
	    	<h3>Welcome:: <?php echo escape($data->username);?> </h3>
	    	<p><?php echo escape($data->name);?></p>
	    </div>
	    <div class="col-md-4">
	    	<h2>Profile image here</h2>
	    </div>
	  </div>
	</div>
</div>
	

	<?php
}
require_once 'footer.php';