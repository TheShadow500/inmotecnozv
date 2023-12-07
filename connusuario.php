<?php
    // Datos de conexion a la base de datos
    $servername = "localhost";      // Nombre del Servidor
    $username = "usuario";            // Nombre de usuario
    $password = "usuario";            // Contraseña
    $db = "inmotecnozv";             // Nombre de la base de datos
    $table = "inmuebles";           // Listado de inmuebles

    // Creamos conexión
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("USE $db;");
?>