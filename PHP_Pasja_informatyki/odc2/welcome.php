<?php

session_start();

//jesli user wpisal bezposredio w pasek to....

if((!isset($_SESSION['udanarejestracja'])))
{
	header('Location: index.php');
	exit();  #koniec wykonywania pliku zeby reszta sie niewykonywala bo po co... 
}
else
{
    unset($_SESSION['udanarejestracja']);
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

Thanks for registering on our website, enjoy playing 

<br></br>
<a href="index.php"> Log in</a> <br></br>

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