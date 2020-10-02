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
				<div class="row no-gutter ">
					<div class="order-12 order-lg-1 col-lg-4 my-auto p-0 d-none d-lg-block">
						<div class="picture" id="picture"><img src="img/wydatek.png" class="obraz  mt-1"></div>
					</div>
							<div class="col-lg-8 order-1 order-lg-12  zawartosc formularz" style="position: relative; z-index: 2;">
							
								<form action="dodaj_wydatek.php" method="post">
								
										<fieldset class="scheduler-border">
											
											<legend class="scheduler-border"> Wydatek </legend>
												
												<div >
														
														<div class="opcja"> Kwota </div>
															<div class="kwota active"> <i class="icon-money"></i> <label class=""> <input class=" col-md-12" type ="number" required placeholder="Kwota" onfocus="this.placeholder=''" 	onblur="this.placeholder='Kwota'" step="0.01" name="kwota"></label></div>
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
															<div class="data"> <i class="icon-calendar"></i><label><input class=" col-md-12" type="date" name="data"></label></div>
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
														
														<div class="opcja"><label for="platnosc"> Sposób płatności </label></div>
														<i class="icon-cc-visa"></i>
														<?php
																$user_id=$_SESSION['id'];
																
																require_once "connect.php";
																mysqli_report(MYSQLI_REPORT_STRICT);
															
																try
																{
																	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
					
																		if($polaczenie->connect_errno!=0)
																		{
																			//rzuć nowym wyjątkiem
																			throw new Exception(mysqli_connect_errno());
																		}
																		else{
																			
																			$rezultat=$polaczenie->query("SELECT name FROM `payment_methods_assigned_to_users` WHERE user_id='$user_id' GROUP BY name");
																			if(!$rezultat)throw new Exception($polaczenie->error);
																			$ile_wynikow=$rezultat->num_rows;

																			if($ile_wynikow>0)
																			{
																				$i=0;
																				while($row = $rezultat->fetch_assoc()){
																						$nazwa[$i]=$row['name'];
																						$i++;
																				}
																				echo '<select class="opcja_1 col-8 col-sm-12 col-md-12 col-lg-12" id="platnosc" name="sposob_platnosci">';
																				for($i=0;$i<$ile_wynikow;$i++)
																				{
																					echo '<option value="'.$nazwa[$i].'">'.$nazwa[$i].'</option>';
																				}
																				echo '</select>';
																			}
																			else
																			{
																				echo '<span style="color:red";>Dodaj w ustawieniach formę płatności!</span>';;
																			}
																		}
																		$polaczenie->close();	
																}
																catch(Exception $e)
																{
																	echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
																	echo '<br/> Informacja developerska: '.$e;
																}
															?>
												</div>
												
												<div>
												
														<div class="opcja"><label for="kategoria"> Kategoria </label></div>
															<i class="icon-list"></i>
															<?php
																$user_id=$_SESSION['id'];
																
																require_once "connect.php";
																mysqli_report(MYSQLI_REPORT_STRICT);
															
																try
																{
																	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
					
																		if($polaczenie->connect_errno!=0)
																		{
																			//rzuć nowym wyjątkiem
																			throw new Exception(mysqli_connect_errno());
																		}
																		else{
																			
																			$rezultat=$polaczenie->query("SELECT name FROM `expenses_category_assigned_to_users` WHERE user_id='$user_id' GROUP BY name");
																			if(!$rezultat)throw new Exception($polaczenie->error);
																			$ile_wynikow=$rezultat->num_rows;

																			if($ile_wynikow>0)
																			{
																				$i=0;
																				while($row = $rezultat->fetch_assoc()){
																						$nazwa[$i]=$row['name'];
																						$i++;
																				}
																				echo '<select class="opcja_2 col-8 col-sm-12 col-md-12 col-lg-12" id="kategoria" name="wybor">';
																				for($i=0;$i<$ile_wynikow;$i++)
																				{
																					echo '<option value="'.$nazwa[$i].'">'.$nazwa[$i].'</option>';
																				}
																				echo '</select>';
																			}
																			else
																			{
																				echo '<span style="color:red";>Dodaj w ustawieniach kategorię wydatku!</span>';;
																			}
																		}
																		$polaczenie->close();	
																}
																catch(Exception $e)
																{
																	echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
																	echo '<br/> Informacja developerska: '.$e;
																}
															?>
													
												</div>
												
												<div>	
													
													<div class="Komentarz">
															
															<div class="opcja"><label for="komentarz">Komentarz</label></div>
															<textarea class="col-10" name="komentarz" id="komentarz" rows="4" cols="80"></textarea>
															
													</div>
							

												</div>
											
												<div class="dodaj"><input type = "submit" value="Dodaj"></div>
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
							 <p>Wszelkie prawa zastrzeżone. Copyright &copy; 2020 All Rights Reserved </p>
							</div>
				</footer>
			</div>	
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
		<script src="js/bootstrap.min.js"></script>
		<script src="submenu.js"></script>
		<script type="text/javascript" src="zegarek.js"></script>
		<script type="text/javascript" src="sticky-menu.js"></script>	
					

</body>
</html>