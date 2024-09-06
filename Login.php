<?php
session_start();
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['Usuario'];
    $contrasena = $_POST['Contrasena'];

    $sql = "SELECT * FROM usuarios WHERE Email = '$usuario' AND Contrasena = '$contrasena'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) == 1) {


        $_SESSION['Usuario'] = $usuario and $_SESSION['Contrasena'] = $contrasena;
        header("Location: index.html");
        exit();
    } else {
        $error = "Usuario o Contraseña incorrecta";
    }

    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
<link rel="stylesheet" href="Login.css">

<body style="display:flex; align-items:center; justify-content:center;">
    <div class="login-page">
        <div class="form">

            <form class="login-form" method="post">
                <h2></i> Login</h2>
                <?php if (isset($error)) { ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php } ?>
                <input type="email" placeholder="Usuario" name="Usuario" id="Usuario" required />
                <input type="password" placeholder="Contrasena" name="Contrasena" id="Contrasena" required />
                <input type="submit" class="btn" name="Enviar" id="Enviar" value="Ingresar">
                <p class="message">No te has Registrado? <a href="Registro.php">Crea una Cuenta!</a></p>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./main.js"></script>

</body>

</html>