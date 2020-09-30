<?php
	session_start();
	
		if ((isset($_POST['new_password'])))
	{
		$wszystko_OK=true;
		$new_password=$_POST['new_password'];
		$new_password_hash=password_hash($new_password, PASSWORD_DEFAULT);
		$old_password=$_POST['old_password'];
		$password=$_SESSION['password'];
		$login=$_SESSION['username'];
		$id=$_SESSION['id'];
		if(password_verify($old_password, $password))
		{
			$wszystko_OK=true;
		}
		else
		{
			$wszystko_OK=false;
			$_SESSION['error_password']="Błędne stare hasło!";
		}

		
		
		if(strlen($new_password)<5 || strlen($new_password)>15)
		{
			$wszystko_OK=false;
			$_SESSION['error_password']="Hasło powinno zawierać od 5 do 15 znaków!";
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
					if($polaczenie->query("UPDATE `users` SET `password`='$new_password_hash' WHERE id='$id'"))
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
						$_SESSION['password']=$new_password_hash;
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