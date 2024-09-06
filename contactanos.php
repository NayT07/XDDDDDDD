<?php
session_start();
include_once 'conexion.php';

// Verificar si el formulario se ha enviado mediante POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si los datos están presentes y no están vacíos
    $Nombre = isset($_POST['Nombre']) ? trim($_POST['Nombre']) : '';
    $Correo = isset($_POST['Correo']) ? trim($_POST['Correo']) : '';
    $Mensaje = isset($_POST['Mensaje']) ? trim($_POST['Mensaje']) : '';

    // Verificar si los datos están presentes
    if (!empty($Nombre) && !empty($Correo) && !empty($Mensaje)) {
        // Insertar en la base de datos
        $sql_insert = "INSERT INTO contacto (Nombre, Correo, Mensaje) VALUES ('$Nombre', '$Correo', '$Mensaje')";

        if (mysqli_query($conexion, $sql_insert)) {
            $mensaje = "Registro exitoso.";
        } else {
            $mensaje = "Error: " . mysqli_error($conexion);
        }
    } else {
        $mensaje = "Todos los campos son obligatorios.";
    }

    mysqli_close($conexion);

    // Redirigir y mostrar mensaje
    echo "<script>
        alert('$mensaje');
        window.location.href = 'contact.html';
    </script>";
} else {
    // Redirigir si no es una solicitud POST
    header('Location: contactanos.php');
    exit();
}
?>
