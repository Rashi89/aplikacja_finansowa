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
				$rezultat = $polaczenie->query("SELECT id FROM incomes_category_assigned_to_users WHERE user_id='$user_id' AND name='$kategoria'");
				
				//Jeśli zapytanie było złe to rzuć wyjątkiem
				if(!$rezultat) throw new Exception ($polaczenie->error);
				
					$ile_wynikow = $rezultat->num_rows;
				
				if($ile_wynikow>0)
				{
				
					$wiersz = $rezultat->fetch_assoc();
					
					$_SESSION['id_incomes'] = $wiersz['id'];
					$id_incomes=$_SESSION['id_incomes'];
				
				}
				else
				{
					echo 'blad';
				}
				
				if($all_ok==true)
				{
					//Wszystkie testy zaliczone dodajemy osobe do bazy
					if($polaczenie->query("INSERT INTO incomes VALUES (NULL,'$user_id','$id_incomes','$kwota','$data','$comment')"))
						{
							$_SESSION['addIncome']=true;
							header('Location: przychod.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
					
				}
				
				
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