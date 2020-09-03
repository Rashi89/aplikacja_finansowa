<?php
	session_start();

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
	
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
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
				<h1 class = "logo"> Aplikacja finansowa </h1>
			</header>
		
			
				<div class="row">
				
						<div class="col-10 col-md-8 col-lg-6 col-xl-5 formularz text-center mt-5">
									<form action="zaloguj.php" method="post">
											<h2> Logowanie i&nbsp;rejestracja </h2>
											<div class="col-1 d-inline" ><i class="icon-user-1"></i></div>
											<div class="login d-inline"><input type ="text" placeholder="Login" onfocus="this.placeholder=''" onblur="this.placeholder='Login'" name="login"></div>
											<div></div>
											<div class="klodka col-1 d-inline"><i class="icon-lock"></i></div>
											<div class="haslo d-inline"><input type ="password" placeholder="Password" onfocus="this.placeholder=''" onblur="this.placeholder='Password'" name="haslo"></div>
											<div>
											<?php
												if(isset($_SESSION['blad']))
												echo $_SESSION['blad'];
											?>
											</div>
											<div class="rejestracja"> <input type = "submit" value="Zaloguj się"></div>
											
											<a href="rejestracja.php" class="inpRejestracja">Zarejestruj się!!</a>	
									</form>	
						</div>					
				</div>
		</div>


	</main>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
	<script src="js/bootstrap.min.js"></script>


</body>
</html>