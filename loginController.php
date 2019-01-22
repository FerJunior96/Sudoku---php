<?php
    $email=$_POST["email"];
    $password=hash("SHA256", $_POST["password"]);

    include("conexion.php");
    
    $query="SELECT * FROM usuarios WHERE Email='$email' AND Password='$password'";
    $resultado = mysqli_query($conexion,$query);
    if($resultado){
        if(mysqli_num_rows($resultado)==1){
            //Correct login:
            $usuario = mysqli_fetch_assoc($resultado);
            session_start();
            $_SESSION["NombreUsuario"]=$usuario['Nombre'];
            $_SESSION["ApellidosUsuario"]=$usuario['Apellidos'];
            $_SESSION["IDUsuario"]=$usuario['IDUsuario'];
            $_SESSION["Email"]=$usuario['Email'];
            $_SESSION["Apodo"]=$usuario['Apodo'];
            $_SESSION["NivelUsuario"]=$usuario['NivelUsuario'];
            header("location: indice.php");
        }else{
            //No matches:
            print("The email or password you have entered are incorrect.");
            print("<a href='login.php'>Try again.</a>");
        }
    }else{
        //Error with query:
        print("Error with query");
    }
    mysqli_close($conexion);
?>