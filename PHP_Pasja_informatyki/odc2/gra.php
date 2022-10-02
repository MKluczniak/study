<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Osadnicy - gra przeglądarkowa</title>
</head>
<body>

<?php
session_start();
#sprawdzamy czy zalogowany zeby nie wyswietlac smieci...
if(!isset($_SESSION['zalogowany'])){

	header("Location: index.php");
	exit();  # skoro nie zalogowany to po co dalej meczyc server//

}
#kopie kodu powyzej mozemy dokleic do kazdej strony ktora zobaczy moze tylko zalogowany user ;)

echo '<a href="logout.php"> Wyloguj sie</a>';
echo "<p> Witaj ".$_SESSION['user']."!</p>";
echo "<p><b>Drewno</b>:".$_SESSION['drewno'];
echo " | <b>Kamien</b>:".$_SESSION['kamien'];
echo " | <b>Zboze</b>:".$_SESSION['zboze']."<br></br></p>";
echo "<p><b>E-mail</b>: ".$_SESSION['email'];
echo "<p><b>Dnipremium</b>: ".$_SESSION['dnipremium'];
?>



</body>
</html>