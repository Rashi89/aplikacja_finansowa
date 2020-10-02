<?php
		session_start();
			if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}
	$username=$_SESSION['username'];
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
	
	<link rel="stylesheet" href="styl_tabel.css">
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/coin.css">
	<link rel="stylesheet" href="menu.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="zegar.css">
	<link rel="stylesheet" href="witaj.css">
	
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
							<div class="zawartosc1 formularz">
							
								<form action="bilans_daty.php" method="post">
								
										<fieldset class="scheduler-border">
											
											<legend class="scheduler-border"> Bilans </legend>
											
													<article>
														<h3 class="napis">Wybierz interesujący Cię okres czasu z jakiego chcesz przejrzeć swój bilans</h3>
													</article>
												
												<div >
														
														<div class="bilans_opcja"><label><input type="radio"  name="opcja_bilansu" value="1" checked> Bieżący miesiąc </label></div>
														<div class="bilans_opcja"><label><input type="radio"  name="opcja_bilansu" value="2" > Poprzedni miesiąc </label></div>
														<div class="bilans_opcja"><label><input type="radio"  name="opcja_bilansu" value="3" > Bieżący rok </label></div>
														<div class="bilans_opcja"><label><input type="radio"  name="opcja_bilansu" value="4" class="btn btn-primary" data-toggle="modal" data-target="#daty" > Niestandardowy </label></div>
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
											
												<div class="dodaj"><input type = "submit" value="OK"></div>
												<a href="witaj.php" class="reset">Anuluj</a>
												
												<div class="modal fade" id="daty" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"data-backdrop="static">
													<div class="modal-dialog modal-dialog-centered" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalCenterTitle">Ustawienie dat</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																  <span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body text-center">
										
																		<div class="opcja">Data początkowa</div>
																		<div class="data text-center"><i class="icon-calendar"></i><label><input type="date" name="start_date"></label></div>
																		<div class="opcja">Data końcowa</div>
																		<div class="data text-center"><i class="icon-calendar"></i><label><input type="date" name="end_date"></label></div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
																<button type="submit" class="btn btn-primary">Zapisz</button>
															</div>
														</div>
													</div>
												</div>
											</div>

										</fieldset>
												<!-- Modal -->
												
								</form>
							
							</div>
				</div>



				
		</div>
		

				
	</main>
		
			<div class="container-fluid p-0 mt-4">
				<footer class="page-footer font-small blue fixed-bottom">
							<div class="stopka_menu">
							 <p>Wszelkie prawa zastrzeżone. Copyright &copy; 2020 All Rights Reserved </p>
							</div>
				</footer>
			</div>	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
		<script src="js/bootstrap.min.js"></script>				
		<script src="submenu.js"></script>
		<script type="text/javascript" src="zegarek.js"></script>		
</body>
</html>