<?php
	session_start();
	
	$wszystko_ok=true;
	$user_id=$_SESSION['id'];
	$_SESSION['ok']=$wszystko_ok;
	
	if(isset($_POST['opcja_bilansu']))
	{		
			$rodzaj_bilansu=$_POST['opcja_bilansu'];
			
			if($rodzaj_bilansu==4)
			{
				$data_poczatkowa=$_POST['start_date'];
				$data_koncowa=$_POST['end_date'];
				//echo $data_poczatkowa.' '.$data_koncowa;
				if(strtotime($data_poczatkowa)>strtotime($data_koncowa)||$data_poczatkowa==""||$data_koncowa=="")
				{
					$wszystko_ok=false;
					header('Location: bilans_wybor.php');
					$_SESSION['error_data'] = "Złe ustawienie dat!";
					exit();
				}
				else
				{
					$_SESSION['start_date']=$data_poczatkowa;
					$_SESSION['end_date']=$data_koncowa;
				}
			}
			header('Location: bilans_tabela.php');
			if($wszystko_ok==true)
			{
					header('Location: bilans_tabela.php');
					require_once "connect.php";
					//sposob raportowania bledów
					mysqli_report(MYSQLI_REPORT_STRICT);
				try
				{
					//nawiązywanie połączenia z bazą danych
					$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
					
					if($polaczenie->connect_errno!=0)
					{
						//rzuć nowym wyjątkiem
						throw new Exception(mysqli_connect_errno());
					}
					else{
						
								$kategorie_przychodu=$polaczenie->query("SELECT id FROM incomes_category_assigned_to_users WHERE user_id='$user_id'");
								if(!$kategorie_przychodu)throw new Exception($polaczenie->error);
								$ile_kategorii_przychodu=$kategorie_przychodu->num_rows;
								
								$kategorie_wydatku=$polaczenie->query("SELECT id FROM expenses_category_assigned_to_users WHERE user_id='$user_id'");
								if(!$kategorie_wydatku) throw new Exception($polaczenie->error);
								$ile_kategorii_wydatku=$kategorie_wydatku->num_rows;
						
								if($rodzaj_bilansu==1){
									$biezacy_miesiac=date('n');
									$biezacy_slownie=date('F');
									$_SESSION['zakres']="";
									//echo $biezacy_miesiac;
									$rezultat=$polaczenie->query("SELECT income_category_assigned_to_user_id,SUM(amount), incomes_category_assigned_to_users.name FROM `incomes`INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id WHERE MONTH(date_of_income)='$biezacy_miesiac' AND incomes.user_id='$user_id' GROUP BY income_category_assigned_to_user_id");
									if(!$rezultat) throw new Exception ($polaczenie->error);
									$_SESSION['rezultat']=$rezultat;
									$ile_wynikow = $rezultat->num_rows;
									
									$rezultaty=$polaczenie->query("SELECT expense_category_assigned_to_user_id,SUM(amount),expenses_category_assigned_to_users.name FROM `expenses` INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id WHERE MONTH(date_of_expense)='$biezacy_miesiac' AND expenses.user_id='$user_id' GROUP BY expense_category_assigned_to_user_id");
									if(!$rezultaty) throw new Exception ($polaczenie->error);
									$ile_rezultatow = $rezultaty->num_rows;

								}
								else if($rodzaj_bilansu==2){
									$poprzedni_miesiac=date('n')-1;
									
									$dateObj   = DateTime::createFromFormat('!m', $poprzedni_miesiac);
									$monthName = $dateObj->format('F');
									$_SESSION['zakres']="";
									
									
									$_SESSION['poprzedni_miesiac']=$poprzedni_miesiac;
									$rezultat=$polaczenie->query("SELECT income_category_assigned_to_user_id,SUM(amount), incomes_category_assigned_to_users.name FROM `incomes`INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id WHERE MONTH(date_of_income)='$poprzedni_miesiac' AND incomes.user_id='$user_id' GROUP BY income_category_assigned_to_user_id");
									if(!$rezultat) throw new Exception ($polaczenie->error);
									$ile_wynikow = $rezultat->num_rows;
									
									$rezultaty=$polaczenie->query("SELECT expense_category_assigned_to_user_id,SUM(amount),expenses_category_assigned_to_users.name FROM `expenses` INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id WHERE MONTH(date_of_expense)='$poprzedni_miesiac' AND expenses.user_id='$user_id' GROUP BY expense_category_assigned_to_user_id");
									if(!$rezultaty) throw new Exception ($polaczenie->error);
									$ile_rezultatow = $rezultaty->num_rows;
								}
								else if($rodzaj_bilansu==3){
									$biezacy_rok=date('Y');
									$_SESSION['rok']=$biezacy_rok;
									
									$_SESSION['zakres']="Rok ".$biezacy_rok;
									
									$rezultat=$polaczenie->query("SELECT income_category_assigned_to_user_id,SUM(amount), incomes_category_assigned_to_users.name FROM `incomes`INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id WHERE YEAR(date_of_income)='$biezacy_rok' AND incomes.user_id='$user_id' GROUP BY income_category_assigned_to_user_id");
									if(!$rezultat) throw new Exception ($polaczenie->error);
									$ile_wynikow = $rezultat->num_rows;
									
									$rezultaty=$polaczenie->query("SELECT expense_category_assigned_to_user_id,SUM(amount),expenses_category_assigned_to_users.name FROM `expenses` INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id WHERE YEAR(date_of_expense)='$biezacy_rok' AND expenses.user_id='$user_id' GROUP BY expense_category_assigned_to_user_id");
									if(!$rezultaty) throw new Exception ($polaczenie->error);
									$ile_rezultatow = $rezultaty->num_rows;
								}
								else if($rodzaj_bilansu==4){
									
									$_SESSION['zakres']="Od ".$data_poczatkowa." do ".$data_koncowa;
									
									$rezultat=$polaczenie->query("SELECT income_category_assigned_to_user_id,SUM(amount), incomes_category_assigned_to_users.name FROM `incomes`INNER JOIN incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id=incomes_category_assigned_to_users.id WHERE date_of_income BETWEEN '$data_poczatkowa' AND '$data_koncowa' AND incomes.user_id='$user_id' GROUP BY income_category_assigned_to_user_id");
									if(!$rezultat)throw new Exception($polaczenie->error);
									$ile_wynikow=$rezultat->num_rows;
									
									$rezultaty=$polaczenie->query("SELECT expense_category_assigned_to_user_id,SUM(amount),expenses_category_assigned_to_users.name FROM `expenses` INNER JOIN expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id=expenses_category_assigned_to_users.id WHERE date_of_expense BETWEEN '$data_poczatkowa' AND '$data_koncowa' AND expenses.user_id='$user_id' GROUP BY expense_category_assigned_to_user_id");
									if(!$rezultaty) throw new Exception ($polaczenie->error);
									$ile_rezultatow = $rezultaty->num_rows;
								}
								
									if($ile_wynikow>=0){
											$i=0;

											for($k=0;$k<$ile_kategorii_przychodu;$k++){
												$tablica_przychodow[$k]=0;
											}
											$name_przychodu = array();
											$tablica_przychodow = array();
											
											while($row = $rezultat->fetch_assoc()){
													
													$id_kategorii_przychodu[$i]=$row['income_category_assigned_to_user_id'];
													$name_przychodu[$i]=$row['name'];
													$tablica_przychodow[$i] = $row['SUM(amount)'];
													
													$i++;
											}
											
											$_SESSION['nazwa_przychodu']=$name_przychodu;
											$_SESSION['przychod']=$tablica_przychodow;
											$_SESSION['ile_wynikow']=$ile_wynikow;
						
											$suma_przychodow=0;
											for($k=0; $k<=$ile_kategorii_przychodu; $k++){
												$suma_przychodow=$suma_przychodow+$tablica_przychodow[$k];
											}
											$_SESSION['suma_przychodow']=round($suma_przychodow,2);
										}
										else{
											echo 'blad';
										}
										
										if($ile_rezultatow>=0){
											$i=0;

											for($k=0;$k<$ile_kategorii_wydatku;$k++){
												$tablica_wydatkow[$k]=0;
											}
											$name_wydatku = array();
											$tablica_wydatkow = array();
											
											while($row = $rezultaty->fetch_assoc()){
													$id_kategorii_wydatku[$i]=$row['expense_category_assigned_to_user_id'];
													$name_wydatku[$i]=$row['name'];
													$tablica_wydatkow[$i] = $row['SUM(amount)'];
													$i++;
											}
											
											$_SESSION['nazwa_wydatku']=$name_wydatku;
											$_SESSION['wydatek']=$tablica_wydatkow;
											$_SESSION['ile_rezultatow']=$ile_rezultatow;

											
											$suma_wydatkow=0;
											for($k=0; $k<=$ile_kategorii_wydatku; $k++){
												$suma_wydatkow=$suma_wydatkow+$tablica_wydatkow[$k];
											}
											$_SESSION['suma_wydatkow']=round($suma_wydatkow,2);
											}
											else{
												echo 'blad';
											}
											
											$saldo=round($suma_przychodow-$suma_wydatkow,2);
											$_SESSION['saldo']=$saldo;
											if($saldo>=0)
											{
												$_SESSION['info_saldo']="Gratulacje ".$_SESSION['username']."! Świetnie zarządzasz finansami!";
											}
											else
											{
												$_SESSION['info_saldo']="Uważaj ".$_SESSION['username'].", wpadasz w długi!";
											}

									header('Location: bilans_tabela.php');

					}
						
					$polaczenie->close();			
		
				}
				catch(Exception $e)
				{
					echo '<span style="color:red";>Błąd serwera! Przepraszamy za niedogodności!</span>';
					echo '<br/> Informacja developerska: '.$e;
				}
			}
	}

?>