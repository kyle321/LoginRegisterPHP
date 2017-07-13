<?php

class Redirect{
	public static function to($location=null)
	{
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case 404:
						header('Http/1.0 404 Not Found');
						include('includes/errors/404.php');
						break;
						exit();
				}
			}
			header("Location: $location");
			exit();
		}
	}
}