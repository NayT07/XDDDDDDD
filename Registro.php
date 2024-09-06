<?php
session_start();
include_once 'conexion.php';

$error = ""; // Inicializar la variable de error

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre =$_POST['Usuario'];
    $contrasena = $_POST['Contrasena'];
    $email =$_POST['Email'];
    $celular=$_POST['Celular'];

    $sql = "SELECT email, celular FROM usuarios WHERE email = ? OR celular = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $email, $celular);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $row = mysqli_fetch_assoc($resultado);
            if ($row['email'] == $email) {
                $error = "Este email ya está registrado, ingrese otro Email";
            } elseif ($row['celular'] == $celular) {
                $error = "Este celular ya está registrado, ingrese otro número";
            }
        } else {
            // Hash de la contraseña
            $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

            // Insertar nuevo usuario
            $sql_insert = "INSERT INTO usuarios(Usuario, Email, Celular, Contrasena) VALUES('$nombre','$email','$celular' ,'$contrasena')";
            $stmt_insert = mysqli_prepare($conexion, $sql_insert);
            if ($stmt_insert) {

                if (mysqli_stmt_execute($stmt_insert)) {
                    $_SESSION['Usuario'] = $email;
                    header("Location: Login.php");
                    exit();
                } else {
                    $error = "Error al registrar el usuario";
                }
                mysqli_stmt_close($stmt_insert);
            } else {
                $error = "Error en la base de datos";
            }
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Error en la base de datos";
    }

    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        canvas {
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
<link rel="stylesheet" href="Registro.css">

<body style="display:flex; align-items:center; justify-content:center;">
    <div class="login-page">
        <div class="form">
            <form class="register-form" method="POST">
                <h2>Register</h2>
                <input type="text" placeholder="Full Name *" required />
                <input type="text" placeholder="Username *" required />
                <input type="email" placeholder="Email *" required />
                <input type="password" placeholder="Password *" required />
                <a class="btn" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Create
                </a>
            </form>
            <form class="login-form" method="post" action="">
                <h2></i>Registro</h2>
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $error != "") { ?>
                    <div class="error-message"><?php echo $error; ?></div>
                <?php } ?>
                <input type="text" placeholder="Usuario" id="Usuario" name="Usuario" required />
                <input type="email" placeholder="Correo" id="Email" name="Email" required />
                <input type="text" placeholder="Celular" id="Celular" name="Celular" required />
                <input type="password" placeholder="Contraseña" id="Contrasena" name="Contrasena" required />
                <input type="submit" class="btn" name="Enviar" id="Enviar" value="Enviar">

            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./main.js"></script>

</body>

</html>