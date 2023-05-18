<?php
session_start(); // Iniciar la sesión
// Verificar si no hay una sesión activa
if (!isset($_SESSION['user'])) {
    // Redireccionar a la página de inicio de sesión u otra página de acceso denegado
    header("Location: http://localhost/webservices/proyectoRESTslim/index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style-indx.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <title>Bienvenido</title>
    <style>
        body {
            background-image: url(../img/fondo.jpg);
        }
    </style>
</head>

<body background="../img/fondo.jpg">
    <form class="form" method="POST">
        <img src="../img/logo.png" alt="">
        <h2>Bienvenido a la biblioteca</h2>
        <p>
            <a class="btn btn-primary" href="index-alm.php" role="button">Almacen</a><br>
            <a class="btn btn-primary" href="index-ven.php" role="button">Ventas</a><br>
            <button type="button" class="btn btn-dark" style="width: 80px;" onclick="cerrarSesion()">🚪 Salir</button>

        </p>
    </form>
    <script>
        function cerrarSesion() {
            // Realizar una solicitud al servidor para cerrar la sesión
            fetch('../sessions/destroy-session.php')
                .then(response => {
                    if (response.ok) {
                        // Si la solicitud fue exitosa, redireccionar a otra página
                        window.location.href = 'http://localhost/webservices/proyectoRESTslim/index.html';
                    } else {
                        // Manejar cualquier error que ocurra durante la solicitud
                        console.error('Error al cerrar la sesión');
                    }
                })
                .catch(error => {
                    // Manejar cualquier error de red u otros errores
                    console.error('Error al cerrar la sesión:', error);
                });
        }
    </script>
    <!-- style="background-color: #1a0d04; border-color: #1a0d04 -->
</body>

</html>