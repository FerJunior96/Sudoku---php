<html>
    <head>
        <title>Login - Sudoku Game</title>
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
            <form action="loginController.php" class="form" method="POST">
                <h1>Login</h1>
                <label>Email:<br><input type="text" name="email" class="input" placeholder="Email" required></label>
                <br>
                <label>Password:<br><input type="password" name="password" class="input" placeholder="Password" required></label>
                <br>
                <input type="submit" class="button" value="Login">
            </form>
        </div>
        <footer>
            <p>Pau Coll - Fernando Junior Carrillo - Jonathan Garcia</p>
        </footer>
    </body>
</html>