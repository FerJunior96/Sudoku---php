<?php
session_start();
//Declaration of variables:
    //Obtain ID SUDOKU:
    $url= $_SERVER["REQUEST_URI"];
    $url2=explode("?",$url);
    $url3=explode("=",$url2[1]);
    $numsecreto=$url3[1];
    $IDSudoku=(($numsecreto-1032)/340);
    $_SESSION["NivelSudoku"]=$IDSudoku;
    //Obtain Sudoku:
        include("conexion.php");
        $query="SELECT * FROM niveles WHERE IDNivel=$IDSudoku";
        $resultado = mysqli_query($conexion,$query);
        if(mysqli_num_rows($resultado) == 0){
            //doesn't exist
            header ("Location: https://youtu.be/6xsDdIByh8A?t=83"); 
        }
        $fila = mysqli_fetch_assoc($resultado);
        $sudoku = str_split($fila["Sudoku"]);
        $IDNivel=$fila["IDNivel"];
        mysqli_close($conexion);
    //Victory / defeat variables:
    $victoria=false;
    $derrota=false;
    //Time
    $tiempoJuego=true;
    //Variables to identify the cells:
        $filas= ["a","b","c","d","e","f","g","h","i"];
        $sudoKeys = [];

    //Variables to identify the rows:
        $fila1=['a1','b1','c1','d1','e1','f1','g1','h1','i1'];
        $fila2=['a2','b2','c2','d2','e2','f2','g2','h2','i2'];
        $fila3=['a3','b3','c3','d3','e3','f3','g3','h3','i3'];
        $fila4=['a4','b4','c4','d4','e4','f4','g4','h4','i4'];
        $fila5=['a5','b5','c5','d5','e5','f5','g5','h5','i5'];
        $fila6=['a6','b6','c6','d6','e6','f6','g6','h6','i6'];
        $fila7=['a7','b7','c7','d7','e7','f7','g7','h7','i7'];
        $fila8=['a8','b8','c8','d8','e8','f8','g8','h8','i8'];
        $fila9=['a9','b9','c9','d9','e9','f9','g9','h9','i9'];
        $todasFilas=[$fila1,$fila2,$fila3,$fila4,$fila5,$fila6,$fila7,$fila8,$fila9];

    //Variables to identify the columns:
        $columna1=['a1','a2','a3','a4','a5','a6','a7','a8','a9'];
        $columna2=['b1','b2','b3','b4','b5','b6','b7','b8','b9'];
        $columna3=['c1','c2','c3','c4','c5','c6','c7','c8','c9'];
        $columna4=['d1','d2','d3','d4','d5','d6','d7','d8','d9'];
        $columna5=['e1','e2','e3','e4','e5','e6','e7','e8','e9'];
        $columna6=['f1','f2','f3','f4','f5','f6','f7','f8','f9'];
        $columna7=['g1','g2','g3','g4','g5','g6','g7','g8','g9'];
        $columna8=['h1','h2','h3','h4','h5','h6','h7','h8','h9'];
        $columna9=['i1','i2','i3','i4','i5','i6','i7','i8','i9'];
        $todasColumnas=[$columna1,$columna2,$columna3,$columna4,$columna5,$columna6,$columna7,$columna8,$columna9];

    //Variables to identify the blocks:
        $bloque1=['a1','b1','c1','a2','b2','c2','a3','b3','c3'];
        $bloque2=['d1','e1','f1','d2','e2','f2','d3','e3','f3'];
        $bloque3=['g1','h1','i1','g2','h2','i2','g3','h3','i3'];
        $bloque4=['a4','b4','c4','a5','b5','c5','a6','b6','c6'];
        $bloque5=['d4','e4','f4','d5','e5','f5','d6','e6','f6'];
        $bloque6=['g4','h4','i4','g5','h5','i5','g6','h6','i6'];
        $bloque7=['a7','b7','c7','a8','b8','c8','a9','b9','c9'];
        $bloque8=['d7','e7','f7','d8','e8','f8','d9','e9','f9'];
        $bloque9=['g7','h7','i7','g8','h8','i8','g9','h9','i9'];
        $todosBloques=[$bloque1,$bloque2,$bloque3,$bloque4,$bloque5,$bloque6,$bloque7,$bloque8,$bloque9];

    //Build the Array SudoKeys:
        $cont=0;
        for($j=0;$j<9;$j++){
            for($i=0;$i<9;$i++){
                $inputID= $filas[$i].($j+1);
                $sudoKeys[$inputID]=$sudoku[$cont];
                $cont++;
            }
        }

//Function print sudoku:
    function imprimirTabla($sudoku){
            $filas= ["a","b","c","d","e","f","g","h","i"];

            //Print sudoku:

            print("<table>");
            $celdaID = 1;
            for($j=0;$j<9;$j++){
                print("<tr>");
                for($i=0;$i<9;$i++){
                    $inputID= $filas[$i].($j+1);
                    if($sudoku[$celdaID-1]==0){
                        $sudoku[$celdaID-1]=NULL;
                        print("<td id=celda".$celdaID."><input id='".$inputID."' name='".$inputID."' maxlength='1' class='inputTabla' type=text value='");
                        if (isset($_POST[$inputID])) echo $_POST[$inputID];
                        print("' autocomplete='off'></td>");
                    }else{
                    print("<td id=celda".$celdaID."><input id='".$inputID."' name='".$inputID."' class='numFijo' maxlength='1' type=text value='".$sudoku[$celdaID-1]."' readonly  autocomplete='off'></td>");
                    }
                    $celdaID++;
                }
                print("</tr>");
            }
            print("</table>");
    }

//Function that upon being called checks one row/column/block
    function comprobarColeccion($coleccion,$sudoKeys){
                $errores = [];
                //We take a box and compare it with the others.
                for($j=0;$j<count($coleccion);$j++){
                    //We check that it isn't a fixed number:
                    if($sudoKeys[$coleccion[$j]]==0){
                        //it's not a fixed number-> We compare with the other numbers.
                        for($i=0;$i<count($coleccion);$i++){
                            if($_POST[$coleccion[$j]]==$_POST[$coleccion[$i]]){
                                //Its wrong, numbers match:
                                if($coleccion[$i]!=$coleccion[$j]){
                                    //print("La casilla ".$coleccion[$j]." está mal. Coinciden: ".$coleccion[$j]." Con: ".$coleccion[$i]." . ");
                                    //print("La casilla ".$coleccion[$j]." está mal");
                                    $errores[] = $coleccion[$j];
                                }
                            }else{
                                //It's all right, it doesn't match.
                            }
                        }
                    }
                    //print("<br>");
                }
                
                if(count(array_unique($errores))==0){
                    return "correcto";
                }else{
                    //return false;
                    return $errores;
                }
    }
            
//Function that upon being called checks all rows/columns/blocks
    function comprobarTodasColecciones($todasColecciones,$sudoKeys){
                $erroresColeccion = [];
                for($i=0;$i<count($todasColecciones);$i++){
                    if(comprobarColeccion($todasColecciones[$i],$sudoKeys)!="correcto"){
                        //print("mal");
                        //$aux=comprobarFila($todasColecciones[$i],$sudoKeys);
                        //array_merge($erroresColeccion,$aux);
                        $erroresColeccion = array_merge($erroresColeccion,comprobarColeccion($todasColecciones[$i],$sudoKeys));
                    }else{
                        //print("Estamos bien");
                    }
                }
            
                    return array_unique($erroresColeccion);
    }


//POST Solve sudoku:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
    //When you press the button:
    //Check remaining lives:
    $vidas = $_POST["vidas"];
    //Error variables:
    $erroresColumnas = comprobarTodasColecciones($todasColumnas,$sudoKeys);
    $erroresFilas = comprobarTodasColecciones($todasFilas,$sudoKeys);
    $erroresBloque = comprobarTodasColecciones($todosBloques,$sudoKeys);
            
    //Both arrays fusion
    $arrayAux=array_unique(array_merge($erroresFilas,$erroresColumnas));
    $arrayTotal=array_unique(array_merge($arrayAux,$erroresBloque));
    if(count($arrayTotal)==0){
        $tiempoJuego=false;
        $horaFin=$_POST["Horas"];
        $minutoFin=$_POST["Minutos"];
        $segundoFin=$_POST["Segundos"];
        $victoria=true;
        $msg="You won! You have achieved a time of: ".$horaFin.":".$minutoFin.":".$segundoFin.".<br>Click on 'Confirm victory' to check your score.";
    }else{
        $vidas--;
        if($vidas<=0){
            $tiempoJuego=false;
            $derrota=true;
            $msg="Sorry, you lost.<br>Click on 'Back to main page' to return.";
        }
    }

}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Sudoku Game</title>
        <link rel="icon" type="image/vnd.microsoft.icon" href="img/sudoku.ico" sizes="32x32">
        <!--<link rel="stylesheet" type="text/css" href="cssSudoku.css">-->
        <style>
            
            body{
                margin:0 auto;
                background-color:#EFEFEF;
                font-family:Arial;
            }

            #contenedor{
                text-align: center;
            }

            table {
              border-collapse: collapse;
              border: 3px solid black;
              table-layout: fixed;
              margin:0 auto;
              box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.404);

            }
            td {
                width:40px;
                border: 1px solid black;
                padding:0;
            }
            tr{
                height:40px;
            }

            .inputTabla{
                outline:0px;
                border: none;
                text-align:center;
                font-size:25;
                cursor: context-menu;
                width:40px;
                height:40px;
            }

            .numFijo{
                font-weight:bold;
                outline:0px;
                border: none;
                text-align:center;
                font-size:25;
                cursor: context-menu;
                width:40px;
                height:40px;
            }

            h1{
                color:#B63D32;
            }
            nav{
                background-color:#B63D32;
                height:auto;
                color:white;
                font-weight:bold;
                text-align:center;

            }

            ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
                background-color: #B63D32;
                margin-left:5%;

            }

            li {
                float: left;
            }

            li a {
                display: inline-block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;

            }

            li a:hover {
            background-color: #8c2f26;
            }
            li:last-child {
                border-right: none;
            }

            .logonav{
                height:35px;
                margin-top:5px;
                margin-right:75px;
            }

            #contExtras{
                display: flex;
                flex-wrap: wrap;
                margin-left:41%;
                margin-right:40%;
                margin-bottom:10px;
                font-size:20;
            }

            #contReloj{
                margin-right:25%;
                background-color:#d9d9d9;
                padding:5px 2px 2px 5px;
                border: 3px solid DimGrey;
                border-radius: 12px;
                box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.404);
            }

            .inputReloj{
                background-color:#d9d9d9;
                font-size:20;
                outline:0px;
                border: none;
                text-align:center;
                cursor: context-menu;
                width:40px;
                height:40px;
            }

            #contVidas{
                background-color:#d9d9d9;
                padding:5px 2px 2px 5px;
                border: 3px solid DimGrey;
                border-radius: 12px;
                box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.404);
            }

            .inputVidas{
                background-color:#d9d9d9;
                font-size:20;
                outline:0px;
                border: none;
                text-align:center;
                cursor: context-menu;
                width:40px;
                height:40px;
            }




            .button {
                -moz-box-shadow:inset 0px 1px 0px 0px #cf866c;
                -webkit-box-shadow:inset 0px 1px 0px 0px #cf866c;
                box-shadow:inset 0px 1px 0px 0px #cf866c;
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #b63d32), color-stop(1, #8c2e26));
                background:-moz-linear-gradient(top, #b63d32 5%, #8c2e26 100%);
                background:-webkit-linear-gradient(top, #b63d32 5%, #8c2e26 100%);
                background:-o-linear-gradient(top, #b63d32 5%, #8c2e26 100%);
                background:-ms-linear-gradient(top, #b63d32 5%, #8c2e26 100%);
                background:linear-gradient(to bottom, #b63d32 5%, #8c2e26 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#b63d32', endColorstr='#8c2e26',GradientType=0);
                margin-top:20px;
                background-color:#b63d32;
                border-radius:11px;
                border:1px solid #942911;
                color:#ffffff;
                font-family:Arial;
                font-size:13px;
                font-weight:bold;
                padding:6px 24px;
                text-decoration:none;
                text-shadow:0px 1px 0px #854629;
                margin-bottom:30px;
            }
            .button:hover {
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #8c2e26), color-stop(1, #b63d32));
                background:-moz-linear-gradient(top, #8c2e26 5%, #b63d32 100%);
                background:-webkit-linear-gradient(top, #8c2e26 5%, #b63d32 100%);
                background:-o-linear-gradient(top, #8c2e26 5%, #b63d32 100%);
                background:-ms-linear-gradient(top, #8c2e26 5%, #b63d32 100%);
                background:linear-gradient(to bottom, #8c2e26 5%, #b63d32 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8c2e26', endColorstr='#b63d32',GradientType=0);
                background-color:#8c2e26;
            }
            .button:active {
                position:relative;
                top:1px;
            }

            .buttonVic {
                -moz-box-shadow:inset 0px 1px 0px 0px #3e7327;
                -webkit-box-shadow:inset 0px 1px 0px 0px #3e7327;
                box-shadow:inset 0px 1px 0px 0px #3e7327;
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #77b55a), color-stop(1, #4f7d38));
                background:-moz-linear-gradient(top, #77b55a 5%, #4f7d38 100%);
                background:-webkit-linear-gradient(top, #77b55a 5%, #4f7d38 100%);
                background:-o-linear-gradient(top, #77b55a 5%, #4f7d38 100%);
                background:-ms-linear-gradient(top, #77b55a 5%, #4f7d38 100%);
                background:linear-gradient(to bottom, #77b55a 5%, #4f7d38 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77b55a', endColorstr='#4f7d38',GradientType=0);
                margin-top:20px;
                background-color:#77b55a;
                border-radius:11px;
                border:1px solid #4b8f29;
                color:#ffffff;
                font-family:Arial;
                font-size:13px;
                font-weight:bold;
                padding:6px 24px;
                text-decoration:none;
                text-shadow:0px 1px 0px #5b8a3c;
                margin-bottom:30px;
            }
            .buttonVic:hover {
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #4f7d38), color-stop(1, #77b55a));
                background:-moz-linear-gradient(top, #4f7d38 5%, #77b55a 100%);
                background:-webkit-linear-gradient(top, #4f7d38 5%, #77b55a 100%);
                background:-o-linear-gradient(top, #4f7d38 5%, #77b55a 100%);
                background:-ms-linear-gradient(top, #4f7d38 5%, #77b55a 100%);
                background:linear-gradient(to bottom, #4f7d38 5%, #77b55a 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#4f7d38', endColorstr='#77b55a',GradientType=0);
                background-color:#4f7d38;
            }
            .buttonVic:active {
                position:relative;
                top:1px;
            }

            footer {
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                background-color: #8c2f26;
                color: white;
                font-weight:bold;
                text-align: center;
            }
            
            
            <?php
            //POST COLORES CSS INCORRECTO
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                print("#".$arrayTotal[0]);
                for($i=1;$i<count($arrayTotal);$i++){
                    print(",#".$arrayTotal[$i]);
                }
            }?>{
                background-color:#e7b8b2;
            }
            
            #celda3<?php
            for($k=6;$k<82;$hola){
                print(",#celda".$k);
                $k = $k + 6;
                print(",#celda".$k);
                $k = $k + 3;
            }
            ?>{
                border-right:2px solid black;
            }
            
            #celda19<?php 
            for($l=20;$l<=27;$hola){
                print(",#celda".$l);
                $l = $l + 1;
            }
            for($l=46;$l<=54;$hola){
                print(",#celda".$l);
                $l = $l + 1;
            }
            ?>{
                border-bottom:2px solid black;
            }

            
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            var segundos = <?php if(isset($_POST['Segundos'])) {echo $_POST['Segundos'];} else{print(0);} ?>;
            var minutos = <?php if(isset($_POST['Minutos'])) {echo $_POST['Minutos'];} else{print(0);} ?>;
            var horas = <?php if(isset($_POST["Horas"])) {echo $_POST["Horas"];} else{print(0);} ?>;
            function cronometro () {
                if (segundos < 59) {
                    segundos ++;
                    if (segundos < 10) { segundos = "0"+segundos }
                    document.getElementById("Segundos").value=segundos;
                }
                if (segundos == 59) {
                    segundos = -1;
                }
                if (segundos == 0) {
                    minutos++;
                    if (minutos < 10) { minutos = "0"+minutos }
                    document.getElementById("Minutos").value=minutos;
                }
                if (minutos == 59) {
                    minutos = -1;
                }
                if ((segundos == 0)&&(minutos == 0) ) {
                    horas ++;
                    if (horas < 10) { horas = "0"+horas }
                    document.getElementById("Horas").value=horas;                }
            }

            function inicio () {
                setInterval(cronometro,1000);
            }

            function validar() {
                var cont=0;
                inputsIDs=[];
                var letras=["a","b","c","d","e","f","g","h","i"];
                for (var j = 0; j < letras.length; j++) {
                    for (var i = 0; i < 9; i++) {
                        inputsIDs.push(letras[j]+(i+1));
                    }
                }

                for (var k = 0; k < inputsIDs.length; k++){
                    if (($('#'+inputsIDs[k]).val().length == 0) || (isNaN($('#'+inputsIDs[k]).val())) || ($('#'+inputsIDs[k]).val() == " ") || ($('#'+inputsIDs[k]).val() == 0)) {
                        cont++;
                    }
                }
                if(cont!=0){
                    alert('Please, check that you have entered all the numbers correctly.');
                    return false;
                }else{
                    return true;
                }
            }

            $( document ).ready(function() {
                <?php if($tiempoJuego!=false){echo "inicio();";} ?>

            });

        </script>
    </head>
    <body>
        <nav>
            <ul>
                <li><img src="img/logoNAV.png" class="logonav"></li>
                <li><a href="niveles.php">Back to main page</a></li>
            </ul>
        </nav>
        <div id="contenedor">
            <h1>Nivel <?php print($IDNivel); ?></h1>
            <form action='<?php if($victoria==true){echo "victoriaController.php";}elseif($derrota==true){echo "niveles.php";}else{print("Sudoku.php?dato=".$numsecreto);} ?>' method='post' onsubmit='return validar();'>
                <div id="contExtras">
                    <div id="contReloj">
                        <input type="text" id="Horas" class="inputReloj" name="Horas" value="<?php if(isset($_POST["Horas"])) {echo $_POST["Horas"];} else{print("00");} ?>" readonly>:
                        <input type="text" id="Minutos" class="inputReloj" name="Minutos" value="<?php if(isset($_POST["Minutos"])) {echo $_POST["Minutos"];} else{print("00");} ?>" readonly>:
                        <input type="text" id="Segundos" class="inputReloj" name="Segundos" value="<?php if(isset($_POST["Segundos"])) {echo $_POST["Segundos"];} else{print("00");} ?>" readonly>
                    </div>
                    <br>
                    <div id="contVidas">
                        Lives:<input type="text" id="vidas" class="inputVidas" name="vidas" value="<?php if(isset($_POST["vidas"])) {echo $vidas;} else{print("3");} ?>" readonly>
                    </div>
                </div>
                <?php
                if($victoria==true){
                    print("<p style=color:#51ad23;font-weight:bold;>".$msg."</p>");
                }elseif($derrota==true){
                    print("<p style=color:#b63d32;font-weight:bold;>".$msg."</p>");
                }
                
                imprimirTabla($sudoku);
                ?>

                <input type='submit' class='<?php if($victoria==true){echo "buttonVic";}elseif($derrota==true){echo "button";}else{echo "button";} ?>' value='<?php if($victoria==true){echo "Confirm victory!";}elseif($derrota==true){echo "Back to level selection.";}else{echo "Solve";} ?>'>
            </form>
        </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>