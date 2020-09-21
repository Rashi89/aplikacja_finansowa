<?php
	session_start();
	
	if (isset($_POST['new_email']))
	{
		$wszystko_OK=true;
		$new_email=$_POST['new_email'];
		$login=$_SESSION['username'];
		$id=$_SESSION['id'];
		
		$emailSafe = filter_var($new_email,FILTER_SANITIZE_EMAIL);
		
		if(filter_var($emailSafe,FILTER_VALIDATE_EMAIL)==false || $emailSafe!=$new_email)
		{
			$wszystko_OK=false;
			$_SESSION['error_email']="Podaj poprawny adres e-mail!";
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
				$rezultat=$polaczenie->query("SELECT id FROM users WHERE BINARY email='$new_email'");
				if(!$rezultat) throw new Exception ($polaczenie->error);
				$ile_emaili=$rezultat->num_rows;
				
				if($ile_emaili>0)
				{
					$wszystko_OK=false;
					$_SESSION['error_email']="Istnieje już osoba z takim adresem e-mail!";
				}
				
				if($wszystko_OK==true)
				{
					if($polaczenie->query("UPDATE `users` SET `email`='$new_email' WHERE id='$id'"))
						{
							$_SESSION['udanaZmianaEmail']=true;
							$_SESSION['error_email']="E-mail został zmieniony!";
							unset($_SESSION['email']);
							header('Location: zmien_email.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
						if($_SESSION['udanaZmianaEmail']==true)
					{
						if(!isset($_SESSION['email']))
						$_SESSION['email']=$new_email;
					}
				}
				else
				{
					header('Location: zmien_email.php');
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