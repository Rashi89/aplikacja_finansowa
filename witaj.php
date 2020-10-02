<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		
		header('Location: logowanie.php');
		exit();
	}
	else
	{
		$user_id=$_SESSION['id'];
		$username=$_SESSION['username'];
		$password=$_SESSION['password'];
		$email=$_SESSION['email'];
		require_once "connect.php";
					//sposob raportowania bledów
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
					$zapytanie_expense = $polaczenie->query("SELECT SUM(amount) FROM `expenses` WHERE user_id='$user_id' ");
					if(!$zapytanie_expense) throw new Exception ($polaczenie->error);
					$ile_expense = $zapytanie_expense->num_rows;
					if($ile_expense>0)
						{
							$expense=$zapytanie_expense->fetch_assoc();
							$all_expense=$expense['SUM(amount)'];
						}
					else
						{
							$all_expense=0;
						}
					$zapytanie_income = $polaczenie->query("SELECT SUM(amount) FROM `incomes` WHERE user_id='$user_id' ");
					if(!$zapytanie_income) throw new Exception ($polaczenie->error);
					$ile_incomes = $zapytanie_income->num_rows;
					if($ile_incomes>0)
						{
							$income=$zapytanie_income->fetch_assoc();
							$all_income=$income['SUM(amount)'];
						}
					else
						{
							$all_income=0;
						}
														
					$_SESSION['saldo_all']=$all_income-$all_expense;
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
<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<title>Finanse app</title>
	<meta name="description" content="Aplikacja która w łatwy sposó pomoże Ci na kontrolowanie Twoich przychodów jak i wydatków.">
	<meta name="keywords" content="finanse, kasa">
	<meta name="author" content="Rashi">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="witaj.css">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/coin.css">
	<link rel="stylesheet" href="menu.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="zegar.css">
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
				<?php include 'belka.php'; ?>
					<header>	
					<div class="nawigacja">
					<?php include 'menu.html'; ?>
					</div>
					</header>
					
			<main>
			
				<div class="container">
					
					<div class="row">
					
						<div class="welcome">
								<div class="data">
								<?php
									echo "<p>Dzisiejsza data: ".date("d.m.Y")."</p>";
								?>
								</div>
								<div class="data">
								<?php
									echo "<p>Saldo z całego okresu: ".$_SESSION['saldo_all']."</p>";
								?>
								</div>
						</div>
					</div>
					<div class="row">
						<div class="buttons">
								<div class="button">
								<a href="przychod.php" class="income btn">Dodaj przychód</a>
								</div>
								<div class="button">
								<a href="wydatek.php" class="expense btn">Dodaj wydatek</a>
								</div>
								<div class="button">
								<a href="bilans_wybor.php" class="bilans btn">Przeglądaj bilans</a>
								</div>
								<div style="clear:both;"></div>
						</div>
					</div>
					<div class="container-fluid">
						<img src="img/grafa_glowna.png" class="img-fluid"/>
					</div>


			</main>
		
			<div class="container-fluid p-0 mt-4">
				<footer class="page-footer font-small blue fixed-bottom">
							<div class="stopka_menu">
							 <p>Wszelkie prawa zastrzeżone. Copyright &copy; 2020 All Rights Reserved </p>
							</div>
				</footer>
			</div>	
			
		<script src="jquery-3.5.1.min"></script>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
		<script src="js/bootstrap.min.js"></script>
		<script src="submenu.js"></script>
		<script type="text/javascript" src="zegarek.js"></script>
		<script type="text/javascript" src="sticky-menu.js"></script>

</body>
</html>