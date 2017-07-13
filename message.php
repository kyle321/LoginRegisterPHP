<?php 
if (Session::exists('success')) {
	?>
	<div class="alert alert-dismissible alert-success">
		<p><?php echo Session::flash('success');?></p>
	</div>
	<?php 
	}