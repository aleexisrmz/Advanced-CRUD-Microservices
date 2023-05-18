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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/style-indx-ven.css">
    <title>Ventas</title>
    <style>
        body {
            background-image: url(../img/fondo.jpg);
        }
    </style>
</head>

<body>
    <form class="form" method="POST">
        <img src="../img/logo.png" alt="">
        <h2>Sistema de ventas</h2>
        <p>
            <a class="btn btn-primary" href="ven-watch-prod.php" role="button">Ver productos de una categoria</a><br>
            <a class="btn btn-primary" href="ven-watch-details.php" role="button">Ver producto a detalle</a>
            <br><br><a href="javascript:history.back(-1);" title="Ir la página anterior">← Volver</a>
            <br><button type="button" class="btn btn-dark" style="width: 80px;" onclick="cerrarSesion()">🚪 Salir</button>
            <br><br>
        </p>
    </form>
</body>

</html>