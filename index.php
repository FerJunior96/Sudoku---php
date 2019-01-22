<?php
session_start();
?>
<html>
    <head>
        <title>Sudoku Game</title>
        <link rel="icon" type="image/vnd.microsoft.icon" href="img/sudoku.ico" sizes="32x32">
        <link rel="stylesheet" type="text/css" href="cssIndex.css">
    </head>
    <body>
        <img src="img/sudokuBack.jpg" id="imgTitulo">
        <img src="img/logo3.png" id="imgLogoTitulo">
        <nav><?php if(isset($_SESSION['NombreUsuario'])){print("<ul><li><a href='niveles.php'>Levels</a></li><li><a href='scoreboard.php'>Scoreboard</a></li><li><a href='logout.php'>Log Out</a></li></ul>");} else {print("<ul><li><a href='scoreboard.php'>Scoreboard</a></li><li><a href='login.php'>Login</a></li><li><a href='registro.php'>Register</a></li>");}?></nav>
        <div class=contCentral>
            <?php if(isset($_SESSION['NombreUsuario'])){print("<h1>¡Welcome ".$_SESSION['NombreUsuario']."!</h1>");}else{print("<h1>Welcome! Register or log in to start to play!</h1>");} ?>
                <p class="textoPrinc">This puzzle is composed of a grid of 9x9 squares, divided into regions of 3x3 squares. Starting from some numbers already shown, you must complete the empty boxes with digits from 1 to 9. These should not be repeated in the same row, column or region of 3x3 cells. In short, you have to fill in the grid so that: each row, each column and each region contains the numbers from 1 to 9, without repeating.</p>
        </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>