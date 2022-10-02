

// BLAD znaleziony, drugie wystapienie zmiennej secret bylo napisane przez "k".
<!-- 

<?php
//Bot or not? Oto jest pytanie!
		$sekret = "PODAJ WŁASNY SEKRET!";
		
		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
		$odpowiedz = json_decode($sprawdz);
		
		if ($odpowiedz->success==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_bot']="Potwierdź, że nie jesteś botem!";
		}		
?>

<?php

    $secret = "6LcqrSciAAAAACwNHtkSRzih_yI-zfvvVTWYeXYS";
	$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);
		
	$odpowiedz = json_decode($check);

	if ($odpowiedz->success==false)
	{
		$wszystko_ok = false;
		$_SESSION['e_recaptcha'] = "Confirm you are not a robot";
	}
?> -->