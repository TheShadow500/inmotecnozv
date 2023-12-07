<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWES - Tarea Online - ADMIN</title>

    <!-- Hoja de Estilos -->
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="container">
        <!-- LOGOTIPO -->
        <div class="logotipo"><a href="index.html"><img src="./logo.png"></a></div>

        <!-- MAIN -->
        <div class="main">
            <!-- TÍTULO SECCIÓN -->
            <div class="seccion-titulo">ADMINISTRADOR</div>

            <!-- SUBTITULO SECCIÓN -->
            <div class="seccion-subtitulo">SELECCIONE LA OPCIÓN</div>

            <!-- OPCIONES -->
            <div class="formulario">
                <button onclick="location.href='insertar.php'" type="submit" class="botones" title="Insertar Inmuebles">INSERTAR</button>
                <button onclick="location.href='modificar.php'" type="submit" class="botones" title="Modificar Inmuebles">MODIFICAR</button>
                <button onclick="location.href='eliminar.php'" type="submit" class="botones" title="Eliminar Inmuebles">ELIMINAR</button>
            </div>

        </div>
        <button onclick="location.href='index.html'" type="submit" class="botones">VOLVER</button>
        <div class="footer">©2023 TecnoZV Inmobiliaria. Daniel Amores Corzo<br>DWES - Desarrollo en Entorno Servidor</div>
    </div>
</body>
</html>