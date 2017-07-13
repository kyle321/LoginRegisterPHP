<?php

require_once 'core/init.php';

$user=new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}
require_once 'header.php';
require_once 'navigation.php';
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate=new Validate();
		$validation=$validate->check($_POST, [
			'name'=>[
				'required'=>true,
				'min'=>6,
				'max'=>50
			]
			]);
		if ($validation->passed()) {
			try{
				$user->update([
					'name'=>Input::get('name')
					]);
				Session::flash('success','Your details have been updated');
				Redirect::to('index.php');
			}catch(Exception $e){
				die($e->getMessage());
			}
		}else{
			foreach ($validation->errors() as $errors) {
				echo $errors;
			}
		}
	}
}
?>
<div class="container">
	<form action="" method="post" class="form-horizontal">
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">Name</label>
		<input type="text"  class="form-control" name="name" id="name" value="<?php echo escape($user->data()->name);?>">
	</div>
	<div class="form-group">
		<input type="submit" class="form-control btn-info" name="submit" value="Update">
		<input type="hidden"  name="token" value="<?php echo Token::generate();?>">
	</div>
</form>

</div>

<?php 
require_once 'footer.php';
