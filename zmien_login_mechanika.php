<?php
	session_start();
	
	if (isset($_POST['new_login']))
	{
		$wszystko_OK=true;
		$new_login=$_POST['new_login'];
		$new_login = htmlentities($new_login, ENT_QUOTES, "UTF-8");
		$login=$_SESSION['username'];
		$id=$_SESSION['id'];
		if(strlen($new_login)<3 || strlen($new_login)>20)
		{
			$wszystko_OK=false;
			$_SESSION['error_login']="Login musi posiadać od 3 do 20 znaków!";
		}
		
		//sprawdzenie czy w niku sa tylko znaki alfanumeryczne funkcja ctype_alnum()
		
		if(ctype_alnum($new_login)==false)
		{
			$wszystko_OK=false;
			$_SESSION['error_login']="Login może składać sie tylko z liter i cyfr (bez polskich znaków)!";
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
				{
					//rzuć nowym wyjątkiem
					throw new Exception(mysqli_connect_errno());
				}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM users WHERE BINARY username='$new_login'");
				
				//Jeśli zapytanie było złe to rzuć wyjątkiem
				if(!$rezultat) throw new Exception ($polaczenie->error);
				
				//zbadamy ile jest w bazie loginów
				$ile_loginow=$rezultat->num_rows;
				
				if($ile_loginow>0)
				{
					$wszystko_OK=false;
					$_SESSION['error_login'] ="Istnieje już osoba o takim loginie!";
				}
				
				if($wszystko_OK==true)
				{
					if($polaczenie->query("UPDATE `users` SET `username`='$new_login' WHERE id='$id'"))
						{
							$_SESSION['udanaZmianaLoginu']=true;
							$_SESSION['error_login']="Login został zmieniony!";
							unset($_SESSION['username']);
							header('Location: zmien_login.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
						if($_SESSION['udanaZmianaLoginu']==true)
					{
						if(!isset($_SESSION['username']))
						$_SESSION['username']=$new_login;
					}
				}
				else
				{
					header('Location: zmien_login.php');
				}
	
			}
			$polaczenie->close();
		}
		catch (Exception $e)
		{
			echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br/> Informacja developerska: '.$e;
		}
	}
	
	
?>