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
	
	<link rel="stylesheet" href="styl_przychod.css">
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
			
							<div class = "logo"> <p>Aplikacja Finansowa</p></div>
			
		</div>
		
			<header>	
					<nav class="navbar navbar-dark bg-menu navbar-expand-xl">
								
									<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
										<span class="navbar-toggler-icon"></span>
									</button>
								
									<div class="collapse navbar-collapse" id="mainmenu">
									
										<ul class="navbar-nav mr-auto">
										
											<li class="nav-item ">
												<a class="nav-link color-text active" href="przychod.php"><i class="icon-credit-card"></i> Dodaj przychód </a>
											</li>
											
											<li class="nav-item">
												<a class="nav-link color-text" href="wydatek.php"><i class="icon-basket"></i> Dodaj wydatek </a>
											</li>
											
											<li class="nav-item">
												<a class="nav-link color-text" href="bilans_wybor.php"><i class="icon-chart-bar"></i> Przeglądaj bilans </a>
											</li>
											
											<li class="nav-item">
												<a class="nav-link color-text" href="#"> <i class="icon-cog-alt"></i> Ustawienia </a>
											</li>
											
											<li class="nav-item">
												<a class="nav-link color-text" href="logout.php"> <i class="icon-logout"></i> Wyloguj się </a>
											</li>
										
										</ul>
									
									</div>
		
					</nav>

			</header>
	<main>
		<div class="container">
				<div class="row">
							<div class="zawartosc formularz">
							
								<form action="dodaj_przychod.php" method="post">
								
										<fieldset class="scheduler-border">
											
											<legend class="scheduler-border"> Przychód </legend>
												
												<div >
														
														<div class="opcja"> Kwota </div>
															<div class="kwota active"> <i class="icon-money"></i>  <input class=" col-md-12" type ="number" required placeholder="Kwota" onfocus="this.placeholder=''" 	onblur="this.placeholder='Kwota'" step="0.01" name="kwota"></div>
														<div class="error">
														<?php
															if(isset($_SESSION['error_kwota']))
															{
															echo $_SESSION['error_kwota'];
															unset($_SESSION['error_kwota']);
															}
														?>
														</div>
												</div>
														
												<div>
														
														<div class="opcja"> Data </div>
															<div class="data"> <i class="icon-calendar"></i><input class=" col-md-12" type="date" name="data"></div>
														<div class="error">
														<?php
															if(isset($_SESSION['error_data']))
															{
															echo $_SESSION['error_data'];
															unset($_SESSION['error_data']);
															}
														?>
														</div>
												</div>


												
												<div>
												
														<div class="opcja"><label for="kategoria"> Kategoria </label></div>
															<i class="icon-list"></i>
																<select class="opcja_1 col-8 col-sm-12 col-md-12 col-lg-12" id="kategoria" name="wybor">
															
																	<option value="Salary" selected>Wynagrodzenie</option>
																	<option value="Interest">Odsetki bankowe</option>
																	<option value="Allegro">Sprzedaż na allegro</option>
																	<option value="Another">Inne</option>
									
																</select>
													
												</div>
												
												<div>	
													
													<div class="Komentarz">
															
															<div class="opcja"><label for="komentarz">Komentarz</label></div>
															<textarea class="col-10" name="komentarz" id="komentarz" rows="4" cols="80" name="komentarz"></textarea>
															
													</div>
							

												</div>
											
												<div class="dodaj"><input type = "submit" value="Dodaj"></div>
												<div class="reset"><input type = "reset" value="Anuluj"></div>		
											
												
										
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

</body>
</html>