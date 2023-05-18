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
    <link rel="stylesheet" href="../css/style-watch-details.css">
    <title>Ver detalles</title>
    <style>
        body {
            background-image: url(../img/fondo.jpg);
        }
    </style>
</head>

<body>
    <form class="form" id="formulario" method="GET">
        <img src="../img/logo.png" alt="">
        <h2>Ver detalles de un producto</h2>
        <p type="Usuario:"><input type="input" name="user" id="user" placeholder="Digita tu usuario"></input></p>
        <p type="Contraseña:"><input type="input" name="pass" id="pass" placeholder="Digita tu contraseña"></input></p>
        <br>
        <p>¿De qué producto vemos sus detalles?...</p>
        <p type="ISBN:"><input type="input" name="isbn" id="isbn" placeholder="Digita el ISBN del producto para ver sus detalles"></input></p>
        <br><br>
        <button id="btn" value="enviar" class="btn btn-outline-light">Enviar</button><br>
        <a href="javascript:history.back(-1);" title="Ir la página anterior" class="a-volver">← Volver</a>
    </form>

    <script src="../js/watch-details.js"></script>
</body>

</html>