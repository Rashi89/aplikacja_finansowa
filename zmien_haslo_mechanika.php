<?php
	session_start();
	
		if ((isset($_POST['new_password'])))
	{
		$wszystko_OK=true;
		$new_password=$_POST['new_password'];
		$new_password = htmlentities($new_password, ENT_QUOTES, "UTF-8");
		$old_password=$_POST['old_password'];
		$old_password = htmlentities($old_password, ENT_QUOTES, "UTF-8");
		$login=$_SESSION['username'];
		$id=$_SESSION['id'];
		$password=$_SESSION['password'];
		
		if(strlen($new_password)<5 || strlen($new_password)>15)
		{
			$wszystko_OK=false;
			$_SESSION['error_password']="Hasło powinno zawierać od 5 do 15 znaków!";
		}
		
		
		if($old_password!=$password)
		{
			$wszystko_OK=false;
			$_SESSION['error_password']="Błędne stare hasło!";
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
				if($wszystko_OK==true)
				{
					if($polaczenie->query("UPDATE `users` SET `password`='$new_password' WHERE id='$id'"))
						{
							$_SESSION['udanaZmiana']=true;
							$_SESSION['error_password']="Hasło zostało zmienione!";
							header('Location: zmien_haslo.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
					if($_SESSION['udanaZmiana']==true)
					{
						unset($_SESSION['password']);
						$_SESSION['password']=$new_password;
					}
				}
				else
				{
					header('Location: zmien_haslo.php');
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