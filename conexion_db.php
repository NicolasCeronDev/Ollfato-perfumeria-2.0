<?php

// Configuraci\u00F3n de la base de datos
$servidor = "localhost"; // Generalmente es 'localhost' cuando usas XAMPP
$usuario_db = "root"; // El usuario predeterminado de XAMPP es 'root'
$password_db = ""; // La contrase\u00F1a predeterminada de XAMPP est\u00E1 vac\u00EDa (puedes haberla cambiado)
$nombre_db = "olfatoperfumeria"; // <-- ¡Nombre de tu base de datos confirmado!

// Crear la conexi\u00F3n
$conexion = new mysqli($servidor, $usuario_db, $password_db, $nombre_db);

// Verificar la conexi\u00F3n
if ($conexion->connect_error) {
    die("Error de conexi\u00F3n a la base de datos: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8");

?>