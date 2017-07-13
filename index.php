<?php
require_once('core/init.php');


#$user=DB::getInstance()->get('users',['username','=','ramsey']);
// if (!$user->count()) {
// 	echo "No user";
// }else{
// 	// foreach($user->results() as $user):
// 	// 	echo $user->username;
// 	// endforeach;
// 	echo $user->first()->username;
// }

// $user=DB::getInstance()->update('users', 2,[
// 		'password'=>'newPassword',
// 		'name'=>'ramsey'
// 	]);


	require_once 'header.php';

	require_once 'navigation.php';
		$user=new User();
		if ($user->isLoggedIn()) {

		?>
		<?php
			if ($user->hasPermission('moderator')) {
					echo "You are an admin";
				}
			}else
			{
				echo "You need to log in to proceed";
			}
		//echo Session::get(Config::get('sessions/session_name'));

	require_once 'footer.php';