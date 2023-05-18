<?php
session_start();

if (isset($_POST['user'])) {
  $user = $_POST['user'];
  // Guardar el valor en la sesión
  $_SESSION['user'] = $user;
  
  echo 'Valor guardado en sesión correctamente.';
} else {
  echo 'No se recibió ningún valor de usuario.';
}
