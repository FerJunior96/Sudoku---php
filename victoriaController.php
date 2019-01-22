<?php
include("conexion.php");
session_start();
$IDUsuario=$_SESSION["IDUsuario"];
$nivelDB=$_SESSION["NivelUsuario"];
$nivelSudoku=$_SESSION["NivelSudoku"];



$horas=$_POST["Horas"];
$minutos=$_POST["Minutos"];
$segundos=$_POST["Segundos"];

$vidas=$_POST["vidas"];
$vidasPerdidas=3-$vidas;


$punMax = 15000;
$bonusAcabar=1400;
$bonusporVida=1200;

$segTotal=($horas*3600)+($minutos*60)+$segundos;
if($segTotal>3600){
    $puntuacion=$bonusAcabar+($bonusporVida*$vidas);
}else{
    $puntuacion=$punMax-$segTotal+$bonusAcabar+($bonusporVida*$vidas);
}

$_SESSION["Horas"]=$horas;
$_SESSION["Minutos"]=$minutos;
$_SESSION["Segundos"]=$segundos;
$_SESSION["Vidas"]=$vidas;
$_SESSION["Puntuacion"]=$puntuacion;


//Level up user
    
    $nivelUsuarioFinal=$nivelSudoku+1;
    if($nivelDB<=$nivelSudoku){
        $sql="UPDATE usuarios SET NivelUsuario='$nivelUsuarioFinal' WHERE IDUsuario='$IDUsuario'";
        if (mysqli_query($conexion,$sql) === TRUE) {
            //Ha funcionado. Actualizar:
            $query="SELECT * FROM Usuarios WHERE IDUsuario='$IDUsuario'";
            $resultado = mysqli_query($conexion,$query);
            if($resultado){
                if(mysqli_num_rows($resultado)==1){
                    //Lo ha encontrado correcto:
                    $usuario = mysqli_fetch_assoc($resultado);
                    $_SESSION["NivelUsuario"]=$usuario['NivelUsuario'];
                }
            }    
        } else {
            //Error:
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }

    //insert punctuation:
    $fecha=date('Y-m-d H:i:s');
    $IDNivel=$nivelSudoku;

    $query="INSERT INTO `puntuaciones`(`Puntos`, `FechaPuntuacion`, `IDUsuario`, `IDNivel`) VALUES ('$puntuacion','$fecha','$IDUsuario','$nivelSudoku')";
    
    if (mysqli_query($conexion,$query) === TRUE) {
        //It worked:
        mysqli_close($conexion);
        header("location: victoria.php");
    } else {
        //Error:
        echo "Error: " . $query . "<br>" . $conexion->error;
        mysqli_close($conexion);
        header("location: victoria.php");
    }


?>