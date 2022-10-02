<?php

session_start();
if((isset($_SESSION['zalogowany']))&&($_SESSION['zalogowany'] = true))
{
	header('Location: gra.php');
	exit();  #koniec wykonywania pliku zeby reszta sie niewykonywala bo po co... 
}

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - gra przeglądarkowa</title>
</head>
<body>

Tylko martwi ujrzeli koniec wojny - platon 

<br></br>
<a href="rejestracja.php"> Zalóz darmowe konto</a> <br></br>

<form action="zaloguj.php" method=post>

Login: <br/><input type="text" name="login"><br/>
Haslo: <br/><input type="password" name="haslo"><br/>  <br/>  <!-- type password makes the input invisible -->
<input type=submit value="zaloguj sie"/>

<?php

if(isset($_SESSION['blad'])) echo $_SESSION['blad'];

?>


</form>


</body>
</html>