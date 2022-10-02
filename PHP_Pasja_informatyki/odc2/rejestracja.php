<?php

session_start();

//zmienne $_Post beda istniec tylko w tedy gdy ktos juz kliknal "submit"

if(isset($_POST['email']))
 {
	//udana walidacja? zalozmy,ze tak!
	$wszystko_ok = true;
	
	$nick = $_POST["nick"];  //utworz pomocnicza zmienna
	// Sprawdz poprawnosc nickname //sprawdzenie dlugosci nicka
	if((strlen($nick)<3) || (strlen($nick)>20))
	{
		$wszystko_ok = false;
		$_SESSION["e_nick"] = "Nick must be between 3 - 20 char"; // uzywamy zmiennje sesynej error_nick dzieki czemu bedziemy mogli jej uzyc aby pokazac ja uzytkownikowi

	}
	if (ctype_alnum($nick)==false)
	{
		$wszystko_ok = false;
		$_SESSION["e_nick"] = "Incorrect nick, only small are letters allowed";   //tylko jeden komunikat, bo po co wiecej meczy usera	
	}
	$email = $_POST["email"];
	$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);  //funkcja chroni przed zabronionym w adresie znakiem ale jeszcze nie sprawdza ze email jest poprawny
	
	
	if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))   //sprawdzanie spojnosci i poprawnosci email
	{
		$wszystko_ok=false;
		$_SESSION['e_email'] = "invalid e-mial"; 

	}

	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];

	if ($haslo1!=$haslo2)
	{
		$_SESSION['e_haslo'] = 'Passwords arent the same!';
	}

	$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);     //hashowanie hasla przed wlozeniem go do bazy niweluje potrzebe sanityzacji hasla
	
	$regulamin = $_POST['regulamin']; 
	
	if (!isset($_POST['regulamin'])) //sprawdzamy czy zmienna w ogole zostala storzona (wstawion do zminnej nic nie zwraca... swoja droga ciekawe???)
	{
		$wszystko_ok = false;
		$_SESSION["e_regulamin"] = "T&C not accepted";

	}

	$secret = "6LcqrSciAAAAACwNHtkSRzih_yI-zfvvVTWYeXYS";
	$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
	$odpowiedz = json_decode($check);

	if ($odpowiedz->success==false)
	{
		$wszystko_ok = false;
		$_SESSION['e_recaptcha'] = "Confirm you are not a robot";
	}

// check if no one the same in databse

	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT); //sposob raportowanie bledow


	try
	{
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if ($polaczenie->connect_errno!=0)  
			{
				throw new Exception(mysqli_connect_errno());
			}
		else
		{
			//Czy email juz istnieje
			$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email ='$email'");  //jesli query bedzie nie poprawne np. eeemail to rzuci wyjatkiem

			if(!$rezultat) throw new Exception($polaczenie->error);

			$how_many_emails = $rezultat->num_rows;

			if($how_many_emails > 0)
			{
				$wszystko_ok=false;
				$_SESSION['e_email'] = 'Email already exists';
			}

			// Czy nick juz istnieje
			$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE user ='$nick'");

			if(!$rezultat) throw new Exception($polaczenie->error);

			$how_many_nick = $rezultat->num_rows;
			if($how_many_nick > 0)
			{
				$wszystko_ok=false;
				$_SESSION['e_nick'] = 'Nick already exists';
			}

			if($wszystko_ok==true)
			{
				if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)")) //1.brakowalo ci single apostroph przy $zmiennych, 2.zamkniecie nawiasu kwerendy bylo za ", 3.brakowalo ostaniego nawiasu
					{
						$_SESSION['udanarejestracja'] = true;
						header("Location: welcome.php");
					}
				else
				{
					throw new Exception($polaczenie->error);
				}
				

			}
			$polaczenie->close();
		}	

	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Server error, we are so sorry</span>'; //produkcja
		echo '<br/> Informacja developerska: '.$e; //developing stage
	}


	// jezeli po wszystkich testach flaga o nazwie wszy_ok jest true... jesli walidacja sie nie uda..nawet nie musimu pisac elsa 
	// if($wszystko_ok == true)
	// {
	// 	echo "udana walidacja"; exit();
	// 	//hurra wszystko ok! mozna dodac do bazy
	// }
}




?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>zaloz darmowe konto</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<style>
		.error
		{
			color:red;
			margin-top:10px;
			margin-bottom:10px;
		}
	</style>
</head>
<body>

 <!-- NP ATRIBUTE ACTION!! -> NIECH ten sam plik przetworzy nam formularz!!! -->
<form method=POST>  

Nickname:<br/><input name=nick></input><br/>
<?php
if(isset($_SESSION['e_nick']))
{
	echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
	unset($_SESSION['e_nick']);
}

?>

Email:<br/><input name=email></input><br/>

<?php
if(isset($_SESSION['e_email']))
{
	echo '<div class="error">'.$_SESSION['e_email'].'</div>';
	unset($_SESSION['e_email']);
}

?>

Twoje haslo:<br/><input type=password name=haslo1></input><br/>
Powtorz haslo:<br/><input type=password name=haslo2></input><br/>

<?php
if(isset($_SESSION['e_haslo']))
{
	echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
	unset($_SESSION['e_haslo']);
}
?>

<label>
<input type="checkbox" name=regulamin /> I accept T&C. 
</label>
<?php
if(isset($_SESSION['e_regulamin']))
{
	echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
	unset($_SESSION['e_regulamin']);
}
?>

<div class="g-recaptcha" data-sitekey="6LcqrSciAAAAAL-BD6Bz9716v6W1kNmpZXrcaDoz"></div><br/>
<input type="submit" value="Submit">

<?php
if(isset($_SESSION['e_recaptcha']))
{
		echo '<div class="error">'.$_SESSION['e_recaptcha'].'</div>';
		unset($_SESSION['e_recaptcha']);

}
?>

</form> 




</body>
</html>




