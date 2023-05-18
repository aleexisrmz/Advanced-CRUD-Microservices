<?php
session_start(); // Iniciar la sesión si aún no está iniciada

// Destruir la sesión
session_destroy();

// Redireccionar a otra página después de eliminar la sesión si es necesario
header("Location: http://localhost/webservices/proyectoRESTslim/index.html");
exit();
