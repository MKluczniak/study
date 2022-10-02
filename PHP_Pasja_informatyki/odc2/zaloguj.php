<?php

session_start();


#"jesli nie jest ustawiona zmienna w globalnej tablicy post.."
if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
	header('Location: index.php');
	exit();
}

require_once "connect.php";
// @ przed new wycisza bledy (w tym przypadku to my zajmiemy sie okodowaniem bledow)

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);  
  
// $polaczenie jest obiektem a connect_errno jest wlasciwoscia 
if ($polaczenie->connect_errno!=0)  
{
	echo "Errorgfsgfs: ".$polaczenie->connect_errno;
}

else
{
	$login = $_POST['login'];
	$haslo = $_POST['haslo'];

	#htmlentities sanityzuje kod, zamienia znaki specjalne co jest mechanizmem zabezpieczajaym
	$login = htmlentities($login, ENT_QUOTES, "UTF-8"); #ENT_QUOTES zamienia takze cudzyslowia i ', NOQUOTES niezamienila by.
	// $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8"); 

	
	$sql = "SELECT * FROM uzytkownicy WHERE user = '$login' AND pass = '$haslo';";

#SPRINTF AND MYSQLI_REAL_ESCAPE_STRING SLOZY DO ZABEZPIECZENIA PRZED ATAKAMI SQL INJECTION
	if ($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE user='%s'",
	 mysqli_real_escape_string($polaczenie, $login))))
	 
	 
	 #ten if jest poto aby sprawdzic czy zapytanie zostalo wyslane 
	{
		$ilu_userow = $rezultat->num_rows;

		if($ilu_userow>0)
		{
			$wiersz = $rezultat->fetch_assoc();    //aportujemy wiersz z bazy

			if(password_verify($haslo, $wiersz['pass']))    //weryfikujemy hashowane haslo
			{
				$_SESSION['zalogowany'] = true;
				
				$_SESSION['id'] = $wiersz['id']; #przyda sie przy przydzielaniu nowych zasobow etc
				$_SESSION['user'] = $wiersz['user'];   #sesion to tez tablica asosjacyjana, nadajemy nazwe "user, drewno etc.) dostepna bedzie w trakcie sesji takze w innych plikach na serwerze, zeby zadzialala na poczatj=ky session_start()
				$_SESSION['drewno'] = $wiersz['drewno'];
				$_SESSION['kamien'] = $wiersz['kamien'];
				$_SESSION['zboze']  = $wiersz['zboze'];
				$_SESSION['dnipremium'] = $wiersz['dnipremium'];
				$_SESSION['email'] = $wiersz['email'];

				unset($_SESSION['blad']);
				$rezultat->free_result(); #sprawdz po co to w filmiku

				header('Location: gra.php');
			}
			else
			{
				$_SESSION["blad"] = '<span style="color:red"> Nieprawidlowy login lub haslo! </span>';
				header("Location: index.php");
			}
		}
		else
		{ 
			$_SESSION["blad"] = '<span style="color:red"> Nieprawidlowy login lub haslo! </span>';
			header("Location: index.php");
		}
} else 
{
		echo "niewykonalo sie";
	}

	$polaczenie->close();


$login = $_POST['login'];
$haslo =$_POST['haslo'];

echo "koniec";

}
?>