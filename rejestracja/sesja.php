<?php

	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: index_rej.php');
		exit();
	}
?>