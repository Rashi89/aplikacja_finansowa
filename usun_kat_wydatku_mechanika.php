<?php
	
	session_start();
	$nazwa=$_POST['wybor'];
	//echo $nazwa;
	
	$user_id=$_SESSION['id'];
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
					
		if($polaczenie->connect_errno!=0)
		{
																			//rzuć nowym wyjątkiem
		throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$rezultat=$polaczenie->query("SELECT id FROM `expenses_category_assigned_to_users` WHERE user_id='$user_id' AND name='$nazwa'");
			if(!$rezultat)throw new Exception($polaczenie->error);
			$ile_wynikow=$rezultat->num_rows;
			
			if($ile_wynikow>0)
			{
				$row = $rezultat->fetch_assoc();
				$id_wydatku=$row['id'];
				$mozna_usuwac=true;
			}
			else
			{
				$mozna_usuwac=false;
				header('Location: usun_kat_wydatku.php');
			}
			if($mozna_usuwac==true)
			{
				$rezultat=$polaczenie->query("DELETE FROM `expenses` WHERE user_id='$user_id' AND expense_category_assigned_to_user_id='$id_wydatku'");
				if(!$rezultat)throw new Exception($polaczenie->error);
				
				$zapytanie=$polaczenie->query("DELETE FROM expenses_category_assigned_to_users WHERE user_id='$user_id' AND name='$nazwa'");
				if(!$zapytanie)throw new Exception($polaczenie->error);
				$_SESSION['informacja']="Udane usunięcie!";
				header('Location: usun_kat_wydatku.php');
			}
			
			
		}
		$polaczenie->close();
	}
	catch(Exception $e)
	{
		echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
		echo '<br/> Informacja developerska: '.$e;
	}
	
?>