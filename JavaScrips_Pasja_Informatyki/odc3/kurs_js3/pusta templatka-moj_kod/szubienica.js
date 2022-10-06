var haslo = "Bez pracy nie ma kolaczy";
haslo = haslo.toUpperCase();

var dlugosc = haslo.length;  //wlasciwosc hasla

var yes = new Audio("yes.wav");
var no = new Audio("no.wav");


var haslo1 = "";


for (i=0; i<dlugosc; i++)
{
    if(haslo.charAt(i) == " ") haslo1 = haslo1 + " "; // (w wielu jezykach stringi sa tablicami w js nie dlatego charAt :) 
    else haslo1 = haslo1 + "-";
}


function wypisz_haslo()
{
    document.getElementById("plansza").innerHTML = haslo1;

}


window.onload = start;  //alias, nickname, przezwisko funkcji wiec bez nawiasu,  w zasadzie to przeciez podmieniam window.onload...

var litery = new Array(35);

litery[0] = "A";
litery[1] = "Ą";
litery[2] = "B";
litery[3] = "C";
litery[4] = "Ć";
litery[5] = "D";
litery[6] = "E";
litery[7] = "Ę";
litery[8] = "F";
litery[9] = "G";
litery[10] = "H";
litery[11] = "I";
litery[12] = "J";
litery[13] = "K";
litery[14] = "L";
litery[15] = "Ł";
litery[16] = "M";
litery[17] = "N";
litery[18] = "Ń";
litery[19] = "O";
litery[20] = "Ó";
litery[21] = "P";
litery[22] = "Q";
litery[23] = "R";
litery[24] = "S";
litery[25] = "Ś";
litery[26] = "T";
litery[27] = "U";
litery[28] = "V";
litery[29] = "W";
litery[30] = "X";
litery[31] = "Y";
litery[32] = "Z";
litery[33] = "Ż";
litery[34] = "Ź";



function start()
{
    var tresc_diva = "";

    for (i=0; i<=34; i++)
    {
        var element = "lit" + i;
        tresc_diva = tresc_diva + '<div class="litera" onclick="sprawdz('+i+')" id="'+element+'">'+litery[i]+'</div>'; //tutaj mamy doczynienia oczywiscie z tablica a nie stringiem wiec poslugiwanie sie [] jest jak najbardziej doppuszczalne
        if ((i+1) % 7 == 0) tresc_diva = tresc_diva + '<div style=clear:both;"></div>';
    }

    document.getElementById("alfabet").innerHTML = tresc_diva;

    wypisz_haslo();
}

String.prototype.ustawZnak = function(miejsce, znak) // String - klasa ktora obsluguje lancuchy, prototype.ustawZnak to tak jakby dodajemy do klasy String nowa metode, miejsce to pozycja zamienianego znaku a potem znak
{   //this to wskaznik, ktory wskazuje na obiekt na rzecz ktorego wywolano nasza funkcje napis.ustawZnak(0,B); Wskaznik this zawsze wskaze na obiekt po lewej stronie kropkij
    if (miejsce > this.length - 1) return this.toString();   //zwroc "this" czyli w naszym kodzie to bedzie haslo1, czyli to co "weszlo"; w tym przypadku zabezpieczmy sie przed wejscie do nieznanego obszaru pamieci. a toString zeby przegladrka wiedziala ze text poprzejsciu przez metode nadal pozostal
    else return this.substr(0, miejsce) + znak + this.substr(miejsce+1); 

}




//funkcja zamieniajaca znak o podanym numerze w lancuchu na inny.

var ile_skuch = 0;
function sprawdz(nr)
{
    var trafiona = false;
    
    for(i=0; i<dlugosc; i++)
    {
        if(haslo.charAt(i) == litery[nr]) //miales literowke w litry :o
        {
            haslo1 = haslo1.ustawZnak(i, litery[nr]);   //haslo1.charAt(i) == litery[nr];   charAt zapewnie tylko odcyt a zapis juz niesety nie!        replane() zatepuje kazdy znak na inny podany wiec nie moze byc tuzyta
            trafiona = true;
        }
    }

        if (trafiona == true)
            {
            yes.play();
            var element = "lit" + nr;
            document.getElementById(element).style.background = "#003300";
            document.getElementById(element).style.color = "#00C000";
            document.getElementById(element).style.border = "3px solid #00C000";
            document.getElementById(element).style.cursor = "default";

            wypisz_haslo();

            }
        else
        {   
            no.play();
            var element = "lit" + nr;
            
            document.getElementById(element).style.background = "#330000";
            document.getElementById(element).style.color = "#C00000";
            document.getElementById(element).style.border = "3px solid #C00000";
            document.getElementById(element).style.cursor = "default";	
            document.getElementById(element).setAttribute("onclick", ";");  // jesli bedzie kliknieta litera to dezaktywujemy onclicka dla tej litery, cleaver :D

            
            //skucha
            ile_skuch = ile_skuch +1;
            document.getElementById("szubienica").innerHTML = '<img src="img/s'+ile_skuch+'.jpg" alt=""></img>';
            // if(ile_skuch >= 1) 
            // {
            //     document.getElementById("alfabet").innerHTML = "You Lost. You are usless <span class='error'> wanna play again?</span>  <span class='error'> wanna play again?</span>"
            // }
        }

        //wygrana
	if (haslo == haslo1)
	document.getElementById("alfabet").innerHTML  = "Tak jest! Podano prawidłowe hasło: "+haslo+'<br /><br /><span class="reset_gry" onclick="location.reload()">PLAY AGAIN?</span><br /><br /><span class="midget" onclick="location.href=\'https://pl.pornhub.com/video/search?search=midget\';">Midget Porn</span>';
	
	//przegrana
	if (ile_skuch>=2)
	document.getElementById("alfabet").innerHTML  = "You lost. You are usless. Correct answer: "+haslo+'<br /><br /><span class="reset_gry" onclick="location.reload()">PLAY AGAIN?</span> <br /><br /><span class="midget" onclick="location.href=\'https://pl.pornhub.com/video/search?search=midget\';">Midget Porn</span>' ;
}




