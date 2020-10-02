<?php
	session_start();
	
		if(!isset($_SESSION['zalogowany']))
	{
		header('Location: logowanie.php');
		exit();
	}
	
	$user_id=$_SESSION['id'];
	$username=$_SESSION['username'];																		
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
															
	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
					
		if($polaczenie->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else{
			
				$empty=$polaczenie->query("SELECT COUNT(*) FROM expenses WHERE user_id='$user_id'");
				if(!$empty)throw new Exception($polaczenie->error);
				$rows = $empty->fetch_assoc();
				$czy_pusta=$rows['COUNT(*)'];
				if($czy_pusta==0)
				{
					header('Location:brak_rekordu.php');
					exit();
				}
				else
				{
						$rezultat=$polaczenie->query("SELECT MAX(id) FROM incomes WHERE user_id='$user_id'");
						if(!$rezultat)throw new Exception($polaczenie->error);
						$ile_wynikow=$rezultat->num_rows;

						if($ile_wynikow>0)
						{
							$row = $rezultat->fetch_assoc();
							$max_id=$row['MAX(id)'];
							$_SESSION['max_id']=$max_id;
							$zapytanie = $polaczenie->query("SELECT amount,date_of_income,income_comment,incomes_category_assigned_to_users.name FROM incomes INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id WHERE incomes.user_id='$user_id' AND incomes.id='$max_id'");
																							
							$ile_opcji=$zapytanie->num_rows;
																							
							if($ile_opcji>0)
							{
								$result = $zapytanie->fetch_assoc();
								$kwota=$result['amount'];
								$data=$result['date_of_income'];
								$komentarz=$result['income_comment'];
								$nazwa_kategorii=$result['name'];
							}
						}
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
	<link rel="stylesheet" href="modal.css">
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
					
						<div class="zawartosc formularz">
						
								<form action="popraw_przychod_mechanika.php" method="post">
								
										<fieldset class="scheduler-border">
											
											<legend class="scheduler-border">Popraw ostatni wpis</legend>
												
												<div cless="col-10 col-md-8 col-lg-6 col-xl-5 formularz text-center mt-5">
													
											<div >
														
														<div class="opcja"> Kwota </div>
															<div class="kwota active"> <i class="icon-money"></i>  <input class=" col-md-12" type ="number" required placeholder="Kwota"  value='<?php echo $kwota;?>' step="0.01" name="kwota"></div>
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
															<div class="data"> <i class="icon-calendar"></i><input class=" col-md-12" type="date" value='<?php echo $data; ?>'name="data"></div>
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
																			
																			$rezultat=$polaczenie->query("SELECT name FROM `incomes_category_assigned_to_users` WHERE user_id='$user_id' GROUP BY name");
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
																				echo '<span style="color:red";>Dodaj w ustawieniach kategorię przychodu!</span>';;
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
															<textarea class="col-10" name="komentarz" id="komentarz" rows="4" cols="80" name="komentarz"  ><?php echo $komentarz; ?></textarea>
															
													</div>
							

												</div>
												<div class="error">
														<?php
															if(isset($_SESSION['error_edit']))
															{
															echo $_SESSION['error_edit'];
															unset($_SESSION['error_edit']);
															}
														?>
												</div>
											
												<div><a href="#" class="akcept" data-toggle="modal" data-target="#akcept">Popraw</a></div>
												<div><a href="witaj.php" class="reset">Anuluj</a></div>

<!-- The Modal -->
												<div class="modal fade" id="akcept" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
													<div class="modal-dialog modal-dialog-centered" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalCenterTitle"><i class="icon-warning"></i>Uwaga!</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																  <span aria-hidden="true">&times;</span>
																</button>
															</div>
															<div class="modal-body text-center">
										
																	<h4>Jesteś pewny, że chcesz wprawadzić zmiany?</h4>
																		
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
																<button type="submit" class="btn btn-primary">Tak</button>
															</div>
														</div>
													</div>
												</div>
										
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