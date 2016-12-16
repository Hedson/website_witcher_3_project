
<?php

	session_start();

	if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true))
	{
		header('Location: index.php');
		exit();
	}
	
?>
<!DOCTYPE HTML>
<html lang="pl">

<head>

	<mera charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title> Wiedzmin 3 - logowanie </title>
	
	
		<link rel="stylesheet" href="rejestracja.css" type="text/css" />
	

</head>
	
	
	
	
	<body>
	
		<div id="text">
			<p1 style="font-size: 25px;">Witaj wiedźminie! Zaloguj się. <br /></p1>
		</div>
		<div id="container">
			<form action="zaloguj.php" method="post">
	
				<input type="text" name="login" placeholder="login" onfocus="this.placeholder=' ' " 
				onblur="this.placeholder='login' ">
			
			
				<input type="password" name="haslo" placeholder="hasło" onfocus="this.placeholder=' ' " 
				onblur="this.placeholder='password'">

				<input type="submit" value="Zaloguj się" />
			
			</form>
		</div>
		
		<div id="text2">	
			<p2 style="font-size: 35px;"><a href="rejestracja.php" >Nie masz konta? - załóż darmowe konto!</a>  <br /></p2>
		</div>
		
		<?php
			
			if(isset($_SESSION['user']))		echo $_SESSION['user'];
			
			if(isset($_SESSION['blad']))		echo $_SESSION['blad'];

		?>
	
	</body>
	
	
	</html>