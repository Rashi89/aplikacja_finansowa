<?php
	
	session_start();
	
	if(isset($_POST['new_category']))
	{
		$wszystko_ok=true;
		$login=$_SESSION['username'];
		$id=$_SESSION['id'];
		$new_category=$_POST['new_category'];
		
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
				$rezultat=$polaczenie->query("SELECT id FROM expenses_category_assigned_to_users WHERE name='$new_category' AND user_id='$id'");
				if(!$rezultat) throw new Exception ($polaczenie->error);
				$ile_kategorii=$rezultat->num_rows;
				
				if($ile_kategorii>0)
				{
					$wszystko_ok=false;
					$_SESSION['error_kategoria']="Już istnieje kategoria o podanej nazwie!";
				}
				
				if($wszystko_ok==true)
				{
					if($polaczenie->query("INSERT INTO expenses_category_assigned_to_users VALUES (NULL,'$id','$new_category')"))
						{
							$_SESSION['udaneDodanie']=true;
							$_SESSION['error_kategoria']="Kategoria została dodana!";
							header('Location: dodaj_kat_wydatku.php');
						}
					else
						{
							throw new Exception ($polaczenie->error);
						}
				}
				else
				{
					header('Location: dodaj_kat_wydatku.php');
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