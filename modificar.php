<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWES - Tarea Online - ADMIN</title>

    <!-- Hoja de Estilos -->
    <link rel="stylesheet" href="style.css">

    <!-- Cargamos el archivo de conexion a base de datos del admin -->
    <?php include 'connadmin.php'; ?>
    <?php
        // Pasamos los datos a un objeto
        $sql = $conn->prepare("SELECT * FROM $table;");
        $sql->execute();
        $contenido  = $sql->fetchAll(PDO::FETCH_ASSOC);

        // Comprobamos si hemos recibido alguna peticion de eliminado
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            if(isset($_POST['eliminarregistro'])){
                // Primero recuperamos el registro y eliminamos la foto
                $sql = $conn->prepare("SELECT imagen FROM $table WHERE id= :eliminarregistro;");
                $sql->bindParam(':eliminarregistro', $_POST['eliminarregistro']);
                $sql->execute();
                $resultado = $sql->fetch(PDO::FETCH_ASSOC);
                if($resultado){
                    if(file_exists($resultado['imagen'])){
                        unlink($resultado['imagen']);
                    }
                }

                // Acto seguido eliminamos el registro y actualizamos la página
                $sql = $conn->prepare("DELETE FROM $table WHERE id= :eliminarregistro;");
                $sql->bindParam(':eliminarregistro', $_POST['eliminarregistro']);
                $sql->execute();
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            }
        }
    ?>
</head>
<body>
    <div class="container">
        <!-- LOGOTIPO -->
        <div class="logotipo"><a href="index.html"><img src="./logo.png"></a></div>
        <!-- FIN LOGOTIPO -->
        <!-- MAIN -->
        <div class="main">
            <!-- TÍTULO SECCIÓN -->
            <div class="seccion-titulo">ADMIN</div>
            <!-- FIN TÍTULO SECCIÓN -->
            <!-- SUBTITULO SECCIÓN -->
            <div class="seccion-subtitulo">MODIFICAR DATOS</div>
            <!-- FIN SUBTITULO SECCIÓN -->
            <!-- LISTA DE INMUEBLES -->
            <?php foreach($contenido as $fila){ ?>
                <div class="contenedor-borrar">
                    <div class="listado-linea-imagen"><img src=<?= $fila['imagen']; ?>></div>
                    <div class="listado-linea-ciudades"><?= $fila['localidad']; ?></div>
                    <div class="listado-linea-ciudades"><?= $fila['provincia']; ?></div>
                    <div class="listado-linea-borrar"><?= $fila['precio']; ?>€</div>
                    <div class="listado-linea-botoneliminar">
                        <form action="modificar2.php" method="POST">
                            <input type="hidden" name="check" value="true">
                            <button class="boton-modificar" type="submit" value=<?= $fila['id']; ?> name="id">✎
                        </form>
                    </div>
                </div>
            <?php } ?>
            <!-- FIN LISTA DE INMUEBLES -->
        </div>
        <button onclick="location.href='admin.php'" type="submit" class="botones">VOLVER</button>
        <div class="footer">©2023 Inmobiliaria Amores. Daniel Amores Corzo<br>DWES - Desarrollo en Entorno Servidor</div>
    </div>
</body>
</html>