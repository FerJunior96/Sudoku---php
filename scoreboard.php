<html>
    <head>
        <title>Scoreboard - Sudoku Game</title>
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
            <h1>Scoreboard</h1>
            <?php
            include("conexion.php");
            $query="SELECT * FROM `puntuaciones` INNER JOIN `usuarios` ON puntuaciones.IDUsuario = usuarios.IDUsuario ORDER BY `Puntos` DESC";
            $resultado = mysqli_query($conexion,$query);

            if(mysqli_num_rows($resultado) > 0){
                print("<table id='tablaPuntos'>");
                print("<tr class='tr'><th class='th'>Username</th><th class='th'>Points</th><th class='th'>Level</th><th class='th'>Date</th></tr>");
                for($i=0;$i<mysqli_num_rows($resultado);$i++){
                    if($fila = mysqli_fetch_assoc($resultado)){
                        print("<tr class='tr'><td class='td'>".$fila["Apodo"]."</td><td class='td'>".$fila["Puntos"]."</td><td class='td'>".$fila["IDNivel"]."</td><td class='td'>".$fila["FechaPuntuacion"]."</td></tr>");
                    }
                }
                print("</table>");
            }else{
                print("There are problems with the connection");
            }
            mysqli_close($conexion);
            ?>
        </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>