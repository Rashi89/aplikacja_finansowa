<?php
	session_start();
	
	if(isset($_POST['email']))
	{
		//udana walidacja? Załóżmy ze tak
		$wszystko_OK=true;
		
		//Login testy
		
		$login=$_POST['login'];
		
		//długość loginu ma byc od 3 do 20 znaków strlen() sprawdza dlugość łańcucha znaków
		
		if(strlen($login)<3 || strlen($login)>20)
		{
			$wszystko_OK=false;
			$_SESSION['error_login']="Login musi posiadać od 3 do 20 znaków!";
		}
		
		//sprawdzenie czy w niku sa tylko znaki alfanumeryczne funkcja ctype_alnum()
		
		if(ctype_alnum($login)==false)
		{
			$wszystko_OK=false;
			$_SESSION['error_login']="Login może składać sie tylko z liter i cyfr (bez polskich znaków)!";
		}
		
		//Sprawdzenie poprawności adresu e-mail
		
		$email=$_POST['email'];
		
		//filtrowanie zmiennej $email 
		
		$emailBezpieczny = filter_var($email,FILTER_SANITIZE_EMAIL);
		
		if(filter_var($emailBezpieczny,FILTER_VALIDATE_EMAIL)==false || $emailBezpieczny!=$email)
		{
			$wszystko_OK=false;
			$_SESSION['error_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdzenie długości hasła
		
		$haslo=$_POST['pass'];
		
		//długość hasla ma byc od 5 do 15 znaków
		
		if(strlen($haslo)<5 || strlen($haslo)>15)
		{
			$wszystko_OK=false;
			$_SESSION['error_haslo']="Hasło powinno zawierać od 5 do 15 znaków!";
		}
		
		//haszowanie haseł to must have!
		$haslo_hash=password_hash($haslo, PASSWORD_DEFAULT);
		//echo $haslo_hash;
		
		require_once "connect.php";
		//sposob raportowania bledów
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		//try...catch
		
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
				//sprawdzimy czy podany login już istnieje w bazie zapytaniem do bazy:
				$rezultat = $polaczenie->query("SELECT id FROM users WHERE username='$login'");
				
				//Jeśli zapytanie było złe to rzuć wyjątkiem
				if(!$rezultat) throw new Exception ($polaczenie->error);
				
				//zbadamy ile jest w bazie loginów
				$ile_loginow=$rezultat->num_rows;
				
				if($ile_loginow>0)
				{
					$wszystko_OK=false;
					$_SESSION['error_login'] ="Istnieje już osoba o takim loginie!";
				}
				
				//sprawdzimy czy dany adres e-mail istnieje w bazie
				$rezultat=$polaczenie->query("SELECT id FROM users WHERE email='$email'");
				
				//Jeśli zapytanie było złe to rzuć wyjątkiem
				if(!$rezultat) throw new Exception ($polaczenie->error);
				
				//zbadamy ile jest w bazie emaili
				$ile_emaili=$rezultat->num_rows;
				
				if($ile_emaili>0)
				{
					$wszystko_OK=false;
					$_SESSION['error_email']="Istnieje już osoba z takim adresem e-mail!";
				}
				
				if($wszystko_OK==true)
				{
					//Wszystkie testy zaliczone dodajemy osobe do bazy
					if($polaczenie->query("INSERT INTO users VALUES (NULL,'$login','$haslo_hash','$email')"))
						{
							$_SESSION['udanaRejestracja']=true;
							header('Location: logowanie.php');
						}
						else
						{
							throw new Exception ($polaczenie->error);
						}
					
					$query = "
					
						INSERT INTO incomes_category_assigned_to_users (user_id, name) SELECT users.id,incomes_category_default.name FROM incomes_category_default, users WHERE users.username='$login';
						SET @max_id = (SELECT MAX(id) FROM incomes_category_assigned_to_users) + 1;
						#SELECT @max_id;
						SET @sql = CONCAT('ALTER TABLE `incomes_category_assigned_to_users` AUTO_INCREMENT = ', @max_id);
						PREPARE stmt FROM @sql;
						EXECUTE stmt;
						
						INSERT INTO payment_methods_assigned_to_users (user_id, name) SELECT users.id,payment_methods_default.name FROM payment_methods_default, users WHERE users.username='$login';
						SET @max_id = (SELECT MAX(id) FROM payment_methods_assigned_to_users) + 1;
						#SELECT @max_id;
						SET @sql = CONCAT('ALTER TABLE `payment_methods_assigned_to_users` AUTO_INCREMENT = ', @max_id);
						PREPARE stmt FROM @sql;
						EXECUTE stmt;
						
						INSERT INTO expenses_category_assigned_to_users (user_id, name) SELECT users.id,expenses_category_default.name FROM expenses_category_default, users WHERE users.username='$login';
						SET @max_id = (SELECT MAX(id) FROM expenses_category_assigned_to_users) + 1;
						#SELECT @max_id;
						SET @sql = CONCAT('ALTER TABLE `expenses_category_assigned_to_users` AUTO_INCREMENT = ', @max_id);
						PREPARE stmt FROM @sql;
						EXECUTE stmt;
					
					";

					$result=$polaczenie->multi_query($query);
					
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
<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Finanse app</title>
	<meta name="description" content="Aplikacja która w łatwy sposó pomoże Ci na kontrolowanie Twoich przychodów jak i wydatków.">
	<meta name="keywords" content="finanse, kasa">
	<meta name="author" content="Rashi">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">

	<link rel="stylesheet" href="rejestracja.css">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/coin.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>

		
	
		<main>
			
			<div class="container">
				<header>
					<div style="height:40px;"></div>
				</header>
		
		
				<div class="row justify-content-around">
				
					<div class="col-sm-12 col-lg-5">
						<img src="img/logo.png" class="logotyp" />
					</div>
						<div class="col-sm-12 col-lg-7 formularz text-left mt-5">
							<div class="row">
									<form method="post">
											<div class="napis">REJESTRACJA</div>
											<div class="col-1 d-inline" ><i class="icon-user-1"></i></div>
											<div class="login d-inline"><input type ="text" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'" name="login"></div>
											<?php
													if(isset($_SESSION['error_login']))
													{
														//wyrzuć error na ekran
														echo '<div class="error">'.$_SESSION['error_login'].'</div>';
														//zniszcz zmienną sesyjną
														unset($_SESSION['error_login']);
													}
											?>
											<div></div>
											<div class="klodka col-1 d-inline"><i class="icon-lock"></i></div>
											<div class="haslo d-inline"><input type ="password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'" name="pass"></div>
											<?php
													if(isset($_SESSION['error_haslo']))
													{
														//wyrzuć error na ekran
														echo '<div class="error">'.$_SESSION['error_haslo'].'</div>';
														//zniszcz zmienną sesyjną
														unset($_SESSION['error_haslo']);
													}
											?>
											<div></div>
											<div class="email col-1 d-inline"><i class="icon-mail-alt"></i></div>
											<div class="email d-inline"><input type ="email" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'" name="email"></div>
											<?php
													if(isset($_SESSION['error_email']))
													{
														//wyrzuć error na ekran
														echo '<div class="error">'.$_SESSION['error_email'].'</div>';
														//zniszcz zmienną sesyjną
														unset($_SESSION['error_email']);
													}
											?>
											<div class="rejestracja"> <input type = "submit" value="Zarejestruj się!"></div>
											<a href="logowanie.php" class="anuluj">Anuluj!</a>
									</form>
															
								</div>
						</div>
					</div>

			</div>
	
		</main>
					<div class="container-fluid p-0 mt-4">
				<footer class="page-footer font-small blue fixed-bottom">
							<div class="stopka_menu">
							 <p>Rashi Lavi na prezydenta Polszy! Wszelkie prawa zastrzeżone. Aplikacja w wykonaniu Rashi &copy;</p>
							</div>
				</footer>
			</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>


</body>
</html>