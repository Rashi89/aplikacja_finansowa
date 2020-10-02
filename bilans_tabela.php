<?php
	session_start();
	
	if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}
	$suma_przych=$_SESSION['suma_przychodow'];
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
	<link rel="stylesheet" href="dist/chartist.min.css">
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
					
							<div class="zawartosc2">
							<fieldset class="ramka">
								<legend class="scheduler-border bilans">Bilans </legend>
										<div class="zakres"><?php echo $_SESSION['zakres'];?></div>
							
								<div class="row">
								
										<div class="wydatek col-sm-12 col-md-6">

												<fieldset class="scheduler-border">
													<legend class="scheduler-border">Wydatki</legend>
													<?php
															$tab_names = $_SESSION['nazwa_wydatku'];
															$ile_rezultatow=$_SESSION['ile_rezultatow'];
															$tab_costs = $_SESSION['wydatek'];
															
															echo '<table>';
															echo '<tr>';
															echo '<td>Kategoria wydatku </td><td>Koszt</td>';
															echo '</tr>';
																	for($i=0;$i<$ile_rezultatow;$i++)
																				{
																					echo '<tr>';
																					echo '<td>'.$tab_names["$i"].'</td><td>'.$tab_costs["$i"].'</td>';
																					echo '</tr>';
																				}
															echo '<tr>';
															echo '<td>Suma</td> <td>'.$_SESSION['suma_wydatkow'].'</td>';
															echo '</tr>';
															echo '</table>';
													
													?>

												</fieldset>
											
										</div>
										
										<div class="col-sm-12 col-md-6">
												<fieldset class="scheduler-border">
													<legend class="scheduler-border"> Przychody </legend>
													<?php
															$tab_name = $_SESSION['nazwa_przychodu'];
															$ile_wynikow=$_SESSION['ile_wynikow'];
															$tab_cost = $_SESSION['przychod'];
															
															echo '<table>';
															echo '<tr>';
															echo '<td>Kategoria przychodu </td><td>Koszt</td>';
															echo '</tr>';
																	for($i=0;$i<$ile_wynikow;$i++)
																				{
																					echo '<tr>';
																					echo '<td>'.$tab_name["$i"].'</td><td>'.$tab_cost["$i"].'</td>';
																					echo '</tr>';
																				}
															echo '<tr>';
															echo '<td>Suma</td> <td>'.$_SESSION['suma_przychodow'].'</td>';
															echo '</tr>';
															echo '</table>';
													
													?>

													</fieldset>
													
											
										</div>
										
										
								</div>
								<div class="row">
									<div class="info_dla_uzytkownika">
													<fieldset class="scheduler-border">
													<legend class="scheduler-border"> Podsumowanie </legend>
																<h2 class="saldo"> Saldo:</h2>
																<div id="saldo">
																		<?php
																			echo $_SESSION['saldo']." zł";
																			
																		?>
																</div>
													
													<div id="informacja">
													<?php
													echo $_SESSION['info_saldo'];
													?>
													</div>
													</fieldset>
									</div>
								</div>
								<div class="row">
										<div class="wykres col-12">
										Wykres kołowy wydatków i&nbsp;przychodów
										</div>
								</div>
										<div class="row">
															<div class="ct-chart ct-golden-section col-12 col-md-6" id="chart1"></div>
																<div class="col-12 col-md-6">
																
																	<fieldset class="scheduler-border">
																		<legend class="scheduler-border"> Legenda </legend>
																		<div class="row justify-content-center">
																				<div class="col-auto ">
																					<img src="img/kolor1.png" class="square"/>
																				</div>
																				<div class="col-auto legenda_koloru">
																					Przychód
																				</div>
																		</div>
																		<div class="row justify-content-center">
																				<div class="col-auto ">
																					<img src="img/kolor2.png" class="square"/>
																				</div>
																				<div class="col-auto legenda_koloru">
																					Wydatek
																				</div>
																		</div>
																	
																	</fieldset>
																
															</div>
										</div>
								</div>
							</fieldset>
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
		<script src="dist/chartist.min.js"></script>
		<script>
		
		var przychody = <?php echo $_SESSION['suma_przychodow']; ?>;
		var wydatki = <?php echo $_SESSION['suma_wydatkow']; ?>;

		var data = {
		  series: [przychody, wydatki]
		};

		var sum = function(a, b) { return a + b };

		new Chartist.Pie('.ct-chart', data, {
		labelInterpolationFnc: function(value) {
		return Math.round(value / data.series.reduce(sum) * 100) + '%';
  }
});

		</script>
		<script type="text/javascript" src="sticky-menu.js"></script>
</body>
</html>