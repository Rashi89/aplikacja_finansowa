<?php
	session_start();
	
	if(isset($_POST['kwota']))
	{
		$all_ok=true;
		
		$data=$_POST['data'];
		
		//Sprawdzmy czy podał date
		if($data=="")
		{
			$all_ok=false;
			$_SESSION['error_data']='Podaj datę!';
		}
		
		$kwota=$_POST['kwota'];
		
		//Sprawdzamy czy kwota jest liczbą dodatnią
		if($kwota<0)
		{
			$all_ok=false;
			$_SESSION['error_kwota']='Kwota musi być dodatnia!';
		}
		
		$user_id=$_SESSION['id'];
		$kategoria_platnosci=$_POST['sposob_platnosci'];
		$kategoria=$_POST['wybor'];
		$comment=$_POST['komentarz'];
		
		require_once "connect.php";
		//sposob raportowania bledów
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			//nawiązywanie połączenia z bazą danych
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			
			//Jesli nie uda sie nawiazac polaczenia:
			if ($polaczenie->connect_errno!=0)
				{
					//rzuć nowym wyjątkiem
					throw new Exception(mysqli_connect_errno());
				}
			else
			{
				//jeśli się udało nawiązać połączenie to:
				//pobierz id przychodu
				$rezultat = $polaczenie->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id='$user_id' AND name='$kategoria'");
				$zapytanie = $polaczenie->query("SELECT id FROM payment_methods_assigned_to_users WHERE user_id='$user_id' AND name='$kategoria_platnosci'");
				//Jeśli zapytanie było złe to rzuć wyjątkiem
				if(!$rezultat) throw new Exception ($polaczenie->error);
				
					$ile_wynikow = $rezultat->num_rows;
				if(!$zapytanie) throw new Exception ($polaczenie->error);
				
					$ile_rezultatow = $zapytanie->num_rows;				
				if($ile_wynikow>0 && $ile_rezultatow>0)
				{
				
					$wiersz = $rezultat->fetch_assoc();
					$row= $zapytanie->fetch_assoc();
					
					$_SESSION['id_payment']=$row['id'];
					$_SESSION['id_expense'] = $wiersz['id'];
					$id_expense=$_SESSION['id_expense'];
					$id_payment=$_SESSION['id_payment'];
					$all_ok=true;
				
				}
				else
				{
					echo 'blad!';
					$all_ok=false;
				}

				if($all_ok==true)
				{
				$max_id=$_SESSION['max_id'];
				$delete=$polaczenie->query("DELETE FROM expenses WHERE id='$max_id'");
				if(!$delete) throw new Exception ($polaczenie->error);
					//Wszystkie testy zaliczone dodajemy osobe do bazy
					if($polaczenie->query("INSERT INTO expenses VALUES ('$max_id','$user_id','$id_expense','$id_payment','$kwota','$data','$comment')"))
						{
							$_SESSION['addIncome']=true;
							$_SESSION['error_edit']='Udana edycja!';
							
							header('Location: popraw_ost_wydatek.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
					
				}
				unset($_SESSION['max_id']);
				
			}
			//Zamknięcie połączenia z bazą
			$polaczenie->close();
				
		}
		catch (Exception $e)
		{
			echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
			echo '<br/> Informacja developerska: '.$e;
		}
		
		
		
	}
	?>