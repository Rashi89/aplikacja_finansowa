<?php
	session_start();
	if(isset($_SESSION['zalogowany']))
	{
		header('Location: bilans_tabela.php');
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
	<link rel="stylesheet" href="logowanie.css">
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
				
						<div class="col-md-4">
							<img src="img/logo.png" class="logotyp" />
						</div>
				
				
						<div class="col-sm-10 col-md-8 col-lg-7 formularz text-left mt-5">
									<form action="zaloguj.php" method="post">
											<h2 class="napis"> LOGOWANIE I REJESTRACJA</h2>
											<div class="col-1 d-inline" ><i class="icon-user-1"></i></div>
											<div class="login d-inline"><input type ="text" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'" name="login"></div>
											<div></div>
											<div class="klodka col-1 d-inline"><i class="icon-lock"></i></div>
											<div class="haslo d-inline"><input type ="password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'" name="haslo"></div>
											<div class="blad">
											<?php
												if(isset($_SESSION['blad']))
												{
												echo $_SESSION['blad'];
												unset($_SESSION['blad']);
												}
											
											?>
											</div>
											<div class="rejestracja1"> <input type = "submit" value="Zaloguj się"></div>
											<div class ="info">Dołącz do <b>CashPoint</b> i pozwól uporządkować swoje finanse! </div>
											
											<a href="rejestracja.php" class="inpRejestracja">Zarejestruj się!!</a>	
									</form>	 
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