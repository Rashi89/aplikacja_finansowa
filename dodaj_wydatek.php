<?php

	session_start();
	
	if(isset($_POST['kwota']))
	{
		$all_ok=true;
		$kwota_wydatku=$_POST['kwota'];
		
		//Sprawdzimy czy kwota wydatku jest dodatnia
		if($kwota_wydatku<0)
		{
			$all_ok=false;
			$_SESSION['error_kwota']='Kwota musi być dodatnia!';
		}
		
		$data_wydatku=$_POST['data'];
		
		if($data_wydatku=="")
		{
			$all_ok=false;
			$_SESSION['error_data']='Podaj datę!';
		}
		
		$user_id=$_SESSION['id'];
		$platnosc=$_POST['sposob_platnosci'];
		$kategoria_wydatku=$_POST['wybor'];
		$comment=$_POST['komentarz'];
		
		require_once "connect.php";
		//sposob raportowania bledów
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			//nawiązywanie połączenia z bazą danych
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			
			if($polaczenie->connect_errno!=0)
			{
				//rzuć nowym wyjątkiem
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//jeśli się udało nawiązać połączenie to:
				//pobierz id wydatku
				$rezultat=$polaczenie->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id='$user_id' AND name='$kategoria_wydatku'");
				//Jeśli zapytanie było złe to rzuć wyjątkiem
				if(!$rezultat) throw new Exception ($polaczenie->error);
				
				$ile_wynikow = $rezultat->num_rows;
				
				if($ile_wynikow>0)
				{
					$wiersz = $rezultat->fetch_assoc();
					$_SESSION['id_expense'] = $wiersz['id'];
					$id_expense=$_SESSION['id_expense'];
				}
				else
				{
					echo 'Błąd';
				}
				
				$rezultat2=$polaczenie->query("SELECT id FROM payment_methods_assigned_to_users WHERE user_id='$user_id' AND name='$platnosc'");
				
				if(!$rezultat2)throw new Exception ($polaczenie->error);
				
				$ile_rezultatow = $rezultat->num_rows;
				
				if($ile_rezultatow>0)
				{
					$wiersz2 = $rezultat2->fetch_assoc();
					$_SESSION['id_payment'] = $wiersz2['id'];
					$id_payment = $_SESSION['id_payment'];
				}
				else
				{
					echo 'Błąd!';
				}
				
				if($all_ok==true)
				{
					if($polaczenie->query("INSERT INTO expenses VALUES (NULL,'$user_id','$id_expense','$id_payment','$kwota_wydatku','$data_wydatku','$comment')"))
						{
							$_SESSION['addExpense']=true;
							header('Location: wydatek.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
				}
				
			}
			$polaczenie->close();
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br/> Informacja developerska: '.$e;
		}
		
	}

?>