<?php
$servername = "localhost";      // Nombre del Servidor
$username = "root";             // Nombre de usuario
$password = "";                 // Contraseña
$db = "inmotecnozv";            // Nombre de la base de datos
$table = "inmuebles";           // Listado de inmuebles

// Crear conexión
$conn = new PDO("mysql:host=$servername", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
echo 'Conexión con éxito.<br>';

// Eliminamos la base de datos anterior en caso de existir
$sql = $conn->prepare("DROP DATABASE IF EXISTS $db;");
$sql->execute();
echo 'Eliminando base de datos anterior ' . $db . ' en caso de existir.<br>';

// Crear base de datos
$sql = $conn->prepare("CREATE DATABASE $db");
$sql->execute();
echo 'Base de datos ' . $db . ' creada correctamente.<br>';

// Accedemos a la BD recien creada
$conn->exec("USE $db;");
echo 'Acceso correcto a ' . $db . '<br>';

// Creamos la tabla
$sql = $conn->prepare("CREATE TABLE $table (
    id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    localidad VARCHAR(30) NOT NULL,
    provincia VARCHAR(30) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    tipoinmueble VARCHAR(20) NOT NULL,
    tamano INT(4) NOT NULL,
    dormitorios INT(2) NOT NULL,
    wc INT(2) NOT NULL,
    precio INT(7) NOT NULL,
    imagen VARCHAR(40) NOT NULL)
;");
$sql->execute();
echo 'Tabla creada con éxito.<br>';

// Comprobamos si existe el archivo .csv
$archivocsv = 'datos.csv';

if(!file_exists($archivocsv)){
    echo 'No existe el archivo datos.csv<br>';
}
else{
    // En caso de existir se abre en modo lectura
    $archivo = fopen($archivocsv, 'r');

    // Se va extrayendo linea a linea del csv
    while(($fila = fgetcsv($archivo)) !== FALSE){
        // Creamos la sentencia SQL con valores ? que se aclara en el siguiente punto
        $sql = $conn->prepare("INSERT INTO $table (localidad, provincia, direccion, tipoinmueble, tamano, dormitorios, wc, precio, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");

        // Pasamos a parametrizar los valores espceficando el tipo de dato a insertar STR, INT, etc
        $sql->bindParam(1, $fila[0], PDO::PARAM_STR);
        $sql->bindParam(2, $fila[1], PDO::PARAM_STR);
        $sql->bindParam(3, $fila[2], PDO::PARAM_STR);
        $sql->bindParam(4, $fila[3], PDO::PARAM_STR);
        $sql->bindParam(5, $fila[4], PDO::PARAM_INT);
        $sql->bindParam(6, $fila[5], PDO::PARAM_INT);
        $sql->bindParam(7, $fila[6], PDO::PARAM_INT);
        $sql->bindParam(8, $fila[7], PDO::PARAM_INT);
        $sql->bindParam(9, $fila[8], PDO::PARAM_STR);
        $sql->execute();

        // Una vez parametrizado se informa al usuario
        echo 'Añadido con éxito el inmueble de ' . $fila[0] . '<br>';
    }

    // Eliminamos en caso de existir los usuarios antiguos de la base de datos
    $sql = $conn->prepare("DROP USER IF EXISTS 'admin'@'localhost';");
    $sql->execute();
    $sql = $conn->prepare("DROP USER IF EXISTS 'usuario'@'localhost';");
    $sql->execute();
    // Refrescamos los permisos
    $sql = $conn->prepare("FLUSH PRIVILEGES;");
    $sql->execute();
    echo 'Usuarios para ' . $db . ' restablecidos<br>';

    // Ahora creamos el usuario 'admin' con contraseña 'admin'
    $sql = $conn->prepare("CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'admin';");
    $sql->execute();
    echo 'Creado el usuario admin<br>';

    // Establecemos los permisos de administrador para la base de datos completa de la inmobiliaria
    $sql = $conn->prepare("GRANT ALL PRIVILEGES ON $db.* TO 'admin'@'localhost';");
    $sql->execute();
    echo 'Privilegios de admin modificados<br>';

    // Ahora creamos el usuario 'usuario' con contraseña 'usuario'
    $sql = $conn->prepare("CREATE USER IF NOT EXISTS 'usuario'@'localhost' IDENTIFIED BY 'usuario';");
    $sql->execute();
    echo 'Creado el usuario usuario<br>';

    // Establecemos los permisos al usuario para poder visualizar la base de datos
    $sql = $conn->prepare("GRANT SELECT ON " . $db . ".* TO 'usuario'@'localhost';");
    $sql->execute();
    echo 'Privilegios de usuario modificados<br>';

    // Refrescamos los permisos
    $sql = $conn->prepare("FLUSH PRIVILEGES;");
    $sql->execute();
}

// Por ultimo se cierra la conexion con la base de datos
$conn = null;
?>