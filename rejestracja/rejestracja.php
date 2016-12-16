
<?php

	session_start();
	
	if (isset($_POST['email']))
	{
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['nick'];
		
		
		
		
		//Sprawdzenie długośći nicka
		if ((strlen($nick)<3) || (strlen($nick)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick musi posaidać od 3 do 20 znaków!";
		}
		
		
		
		
		
		//Sprawdź poprawność adresu e-mail
		$email=$_POST['email'];
		$emailB = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB,FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		
		
		
		
		//Sprawdzenie czy nick zawiera poprawne znaki
		if(ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		
		
		
		//Sprawdź poprawność hasła:
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";	
		}
		
		if($haslo1 != $haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";	
		}
		
		//zahashowanie hasla funkcja password_hash()
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
	
		
		//Czy zaakceptowano regulamin?
		if(!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}
		
		
		//Bot or not? Sprawdzenie reCAPTCHA:
		$sekret = "6Ld1gScTAAAAABGMpcQ3uIM80toh3Ysmo1aZXvp0"; //skopiowane ze strony reCAPTCHA
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}
		
		
		
		//łączenie z bazą danych
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		// try, catch - łaczenie z bazą danych, a gdy się nie uda  do rzucamy wyjątek i go łapiemy
		try
		{
			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name); 
			if($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());		// Rzuć nowym wyjątkiem
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)	// jesli znajdzie taki e-mail w bazie to wyswietli blad
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}
				
				
				//Czy nick jest już zarezerowany?
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user='$nick'");
				
				if(!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)	// jesli znajdzie taki e-mail w bazie to wyswietli blad
				{
					$wszystko_OK=false;
					$_SESSION['e_nick']="Istnieje już gracz o taki nicku. Wybierz inny!";
				}
				
				
				
				// If all rules were passed:
				if($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczoe, dodajemy gracza do bazy
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: witamy.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
				}
		
				
				
				
				$polaczenie->close();
			}
		}
		catch(Exception $e)		// Złap wyjątki, które zostały rzucone
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innnym terminie!</span>';
			echo '<br />Informacja develperska: '.$e;
		}
		
		
		
		
		
		
	}
	
	

?>
<!DOCTYPE HTML>
<html lang="pl">

<head>

	<mera charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title> Załóż nowe konto </title>
	
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<link rel="stylesheet" href="rejestracja.css" type="text/css" />
	
	<style>
		.error
		{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;		
		}
		
		body
		{
			background-image: url("../img/geraltt.png");
			color:white;
		}
	
	
	</style>
	

	
	
	</head>
	
	
	
	
	<body>
	
	<div id="container_rej">
		<form method="post">
		
			Nickname: <br /> <input type="text" name ="nick" /> <br />
			
			<?php
			//  w razie erroru e_nick ustalonego powyżej
				if(isset($_SESSION['e_nick']))
				{
					echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
					unset($_SESSION['e_nick']);
				}
				
			?>
			
			
		
			
			E-mail: <br /> <input type="text" name ="email" /> <br />
			
			<?php
			//  w razie erroru e_nick ustalonego powyżej
				if(isset($_SESSION['e_email']))
				{
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
				
			?>
			
			
			
			Twoje hasło: <br /> <input type="password" name ="haslo1" /> <br />
			
			<?php
			//  w razie erroru e_nick ustalonego powyżej
				if(isset($_SESSION['e_haslo']))
				{
					echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
					unset($_SESSION['e_haslo']);
				}
				
			?>
			
			

		
			Powtórz hasło: <br /> <input type="password" name ="haslo2" /> <br />
			
			<label>
			<input type="checkbox" name ="regulamin" /> Akcjeptuję regulamin
			</label>
			<?php
			//  w razie erroru e_nick ustalonego powyżej
				if(isset($_SESSION['e_regulamin']))
				{
					echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
					unset($_SESSION['e_regulamin']);
				}
				
			?>
			
		
			
			<div class="g-recaptcha" data-sitekey="6Ld1gScTAAAAAMynxZAxZtoclUaGfYVdQNJvAn-E"></div>
			
			<?php
			//  w razie erroru e_nick ustalonego powyżej
				if(isset($_SESSION['e_bot']))
				{
					echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
					unset($_SESSION['e_bot']);
				}
				
			?>
			
			
			
			
			<br />
			
			<input type="submit" value="Zarejestruj się" />
			
		</form>
	</div>
	</body>
	
	
	</html>