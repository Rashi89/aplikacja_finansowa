<?php
	session_start();
	
		if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
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
	<link rel="stylesheet" href="styl_tabel.css">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/coin.css">
	<link rel="stylesheet" href="menu.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
		

				<div class="container-fluid p-0">
				
						
							 <div class = "logo">  
									Witaj Agata
							 </div>
						
			
				</div>
		
					<header>	
						<?php include 'menu.html'; ?>

					</header>
					
			<main>
			
				<div class="container">
					
					<div class="row">
					
						<div class="zawartosc formularz">
						
								<form action="zmien_email_mechanika.php" method="post">
								
										<fieldset class="scheduler-border">
											
											<legend class="scheduler-border"> Zmiana adresu e-mail </legend>
												
												<div cless="col-10 col-md-8 col-lg-6 col-xl-5 formularz text-center mt-5">
													
													<h2>Podaj podaj nowy adres e-mail:</h2>
														<div class="email col-1 d-inline"><i class="icon-mail-alt"></i></div>
														<div class="email d-inline"><input type ="email" placeholder="E-mail" onfocus="this.placeholder=''" onblur="this.placeholder='E-mail'" name="new_email"></div>
														<div></div>
																<?php
																	if(isset($_SESSION['error_email']))
																	{
																		//wyrzuć error na ekran
																		echo '<div class="error">'.$_SESSION['error_email'].'</div>';
																		//zniszcz zmienną sesyjną
																		unset($_SESSION['error_email']);
																	}
																?>														
												</div>
	
												<div class="dodaj"><input type = "submit" value="Zmień"></div>
												<a href="witaj.php" class="reset">Anuluj</a>

										</fieldset>
								
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
		<script src="submenu.js"></script>							

</body>
</html>