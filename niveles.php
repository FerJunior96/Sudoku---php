<?php
session_start();
$nivelusuario = $_SESSION["NivelUsuario"];
$IDUsuario = $_SESSION["IDUsuario"];
?>

<html>
    <head>
        <title>Niveles - Sudoku Game</title>
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
        <div style="text-align:center;">
            <h1>Level selection</h1>
        </div>
        <div class="contNiveles">
            

                <?php
                include("conexion.php");
                $query="SELECT * FROM niveles";
                $resultado = mysqli_query($conexion,$query);



                if(mysqli_num_rows($resultado) > 0){

                    for($i=0;$i<$nivelusuario;$i++){
                        if($fila = mysqli_fetch_assoc($resultado)){
                            $nivelActual=$fila['IDNivel'];
                            $queryPuntos="SELECT * FROM niveles INNER JOIN (puntuaciones INNER JOIN usuarios ON puntuaciones.IDUsuario = usuarios.IDUsuario) ON niveles.IDNivel = puntuaciones.IDNivel WHERE usuarios.IDUsuario='".$IDUsuario."' AND niveles.IDNivel = '".$nivelActual."' ORDER BY `Puntos` DESC LIMIT 1";
                            //$queryPuntos='SELECT * FROM Niveles INNER JOIN puntuaciones ON puntuaciones.IDNivel = niveles.IDNivel WHERE usuarios.IDUsuario='.$IDUsuario.' AND niveles.IDNivel = '.$nivelActual.' ORDER BY `Puntos` DESC LIMIT 1';
                            $resultadoPuntos = mysqli_query($conexion,$queryPuntos);
                            if(mysqli_num_rows($resultadoPuntos) == 0){
                                $puntuacionMax="-";
                            } else{
                                $filaPuntos = mysqli_fetch_assoc($resultadoPuntos);
                                $puntuacionMax=$filaPuntos['Puntos'];
                            }


                            $numerosecreto=(($fila["IDNivel"])*340)+1032;
                            print("<div id='nivel".$fila["IDNivel"]."' class='nivelCompletado'><p class='titNivel'>Level ".$fila["IDNivel"]."</p><a href='Sudoku.php?dato=".$numerosecreto."'><img class='imgNivel' src='img/niveles/".$fila["IDNivel"].".png'></a><p>".$puntuacionMax."</p></div>\n");
                        }
                    }
                    for($j=$nivelusuario+1;$j<mysqli_num_rows($resultado)+1;$j++){
                        print("<div id='nivel".$j."' class='nivelIncompleto'><p class='titNivel'>Level ".$j."</p><img class='imgNivel' src='img/niveles/bloq.png'><p>-</p></div>");
                    }
                }else{
                    print("There are a problem with the connection.");
                }
                mysqli_close($conexion);
                ?>
        </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>