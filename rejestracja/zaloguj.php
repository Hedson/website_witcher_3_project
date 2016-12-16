<?php
	session_start();
	
	
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index_rej.php');
		exit();
	}

	require_once "connect.php";
	
	
	
	//laczenie z baza danych
	try
	{
		$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name); 
		if($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());		// Rzuć nowym wyjątkiem
			}
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innnym terminie! Dokładniej błd przy logowaniu wyłapany Try catchem. </span>';
		echo '<br />Informacja develperska: '.$e;
	}
	
	
	
	
	if($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
		
		
		
		if($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
		mysqli_real_escape_string($polaczenie,$login))))
		
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				//wyjecie z bazy danych calego rekordu(aportowanie) i wlożenie go do pojemnika(tablicy) wiersz.
				$wiersz = $rezultat->fetch_assoc();
				
				if(password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
					
				
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['email'] = $wiersz['email'];
					
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					
					header('Location: index.php');
						
				}//end if
				
				else
				{	
					$_SESSION['blad'] = '<div id="error"><span style="color:red">Nieprawidłowy login lub hasło!</span></div>';
					header('Location: index_rej.php');	
				}
						
			} 
			else
			{
				
				$_SESSION['blad'] = '<div id="error"><span style="color:red">Nieprawidłowy login lub hasło!</span></div>';
				
				header('Location: index_rej.php');
				
			}
				
		}// end if
		
		
		
		$polaczenie->close();
	}




?>