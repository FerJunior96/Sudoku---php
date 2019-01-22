<?php
session_start();
$IDUsuario=$_SESSION["IDUsuario"];
$nivelDB=$_SESSION["NivelUsuario"];
$nivelSudoku=$_SESSION["NivelSudoku"];

$horas=$_SESSION["Horas"];
$minutos=$_SESSION["Minutos"];
$segundos=$_SESSION["Segundos"];

$vidas=$_SESSION["Vidas"];
$vidasPerdidas=3-$vidas;

$puntuacion=$_SESSION["Puntuacion"];



?>
<html>
    <head>
        <title>Victory - Sudoku Game</title>
        <link rel="icon" type="image/vnd.microsoft.icon" href="img/sudoku.ico" sizes="32x32">
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
    <nav>
        <ul>
            <li><img src="img/logoNAV.png" class="logonav"></li>
            <li><a href="indice.php">Back to the main page</a></li>
        </ul>
    </nav>
    <div class="contCentral">
        <h1>Congratulations!</h1>
        <div class="textoPrinc">
            <?php
            print("You have completed the level ".$nivelSudoku.".<br>");
            print("You have finished in");
            print("<br>");
            print("<br>");
            print("<div id='tiempo'>".$horas.":".$minutos.":".$segundos."</div>");
            print("<br>");
            print("You have achieved a total of");
            print("<br><br>");
            print("<div id='tiempo'>".$puntuacion." Points</div>");
            print("<br><br>");
            ?>
            <a class="button" href="niveles.php">Back to the main page</a>
        </div>
    </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>