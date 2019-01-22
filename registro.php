<html>
    <head>
        <title>Register - Sudoku Game</title>
        <link rel="icon" type="image/vnd.microsoft.icon" href="img/sudoku.ico" sizes="32x32">
        <link rel="stylesheet" type="text/css" href="css.css">
    </head>
    <body>
        <nav>
            <ul>
                <li><img src="img/logoNAV.png" class="logonav"></li>
                <li><a href="indice.php">Back to main page</a></li>
            </ul>
            
        </nav>
        <div class="contCentral">
        <form action="registro.php" class="form" method="POST">
        <h1>Register</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include("conexion.php");
            $apodo=$_POST["apodo"];
            $email=$_POST["email"];
            $nombre=$_POST["nombre"];
            $apellidos=$_POST["apellidos"];
            $password=hash("SHA256", $_POST["password"]);
            $nivelUsuario=1;
            $fecha=date('Y-m-d H:i:s');

            $query="INSERT INTO `usuarios`(`Apodo`, `Password`, `Email`, `Nombre`, `Apellidos`, `NivelUsuario`, `FechaCreacion`) VALUES ('$apodo','$password','$email','$nombre','$apellidos','$nivelUsuario','$fecha')";
            
            if (mysqli_query($conexion,$query) === TRUE) {
                //It worked:
                print("<div><p style=color:green;>Congratulations! You are registered!</p></div>");
            } else {
                //Error:
                print("<div><p style=color:red;>Please, check the entered data<br> and try again.</p></div>");
            }

            mysqli_close($conexion);
        }
        ?>
            
                
                <label>Username: <br><input type="text" class="input" name="apodo" placeholder="Username" required></label><br>
                <label>Email: <br><input type="text" class="input" name="email" placeholder="Email" required></label><br>
                <label>Name: <br><input type="text" class="input" name="nombre" placeholder="Name" required></label><br>
                <label>Surname: <br><input type="text" class="input" name="apellidos" placeholder="Surname" required></label><br>
                <label>Password: <br><input type="password" class="input" name="password" placeholder="Password" required></label><br>
                <input type="submit" class="button">
            </form>
        </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>