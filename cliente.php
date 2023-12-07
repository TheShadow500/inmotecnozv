<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWES - Tarea Online - CLIENTE</title>
    <link rel="stylesheet" href="style.css">
    <!-- Cargamos el archivo de conexion a base de datos del usuario -->
    <?php include 'connusuario.php'; ?>
    <?php
        // Comprobamos si el cliente filtra informacion y se realiza la búsqueda al respecto
        $sql = "SELECT * FROM $table WHERE 1";

        if(isset($_POST['submit'])){
            // Creamos el array para añadir los filtros del usuario
            $condiciones = array();

            // Rellenamos el array con las opciones introducidas por el cliente
            if($_POST['localidad'] != null){
                $condiciones[] = "localidad = :localidad";
            }
            if($_POST['provincia'] != null){
                $condiciones[] = "provincia = :provincia";
            }
            if($_POST['tipoinmueble'] != null){
                $condiciones[] = "tipoinmueble = :tipoinmueble";
            }
            if($_POST['dormitorios'] != null){
                $condiciones[] = "dormitorios >= :dormitorios";
            }
            if($_POST['wc'] != null){
                $condiciones[] = "wc >= :wc";
            }
            if($_POST['precio'] != null){
                $condiciones[] = "precio <= :precio";
            }

            // Añadimos las opciones a la consulta
            if(!empty($condiciones)){
                $sql .= " AND " . implode(" AND ", $condiciones);
            }

            // Preparamos la consulta con los filtros
            $filtros = $conn->prepare($sql);

            // Parametrizamos los valores filtrados en caso de estar establecidos
            if($_POST['localidad']){
                $filtros->bindParam(':localidad', $_POST['localidad']);
            }
            if($_POST['provincia']){
                $filtros->bindParam(':provincia', $_POST['provincia']);
            }
            if($_POST['tipoinmueble']){
                $filtros->bindParam(':tipoinmueble', $_POST['tipoinmueble']);
            }
            if($_POST['dormitorios']){
                $filtros->bindParam(':dormitorios', $_POST['dormitorios']);
            }
            if($_POST['wc']){
                $filtros->bindParam(':wc', $_POST['wc']);
            }
            if($_POST['precio']){
                $filtros->bindParam(':precio', $_POST['precio']);
            }

            // Ejecutamos la consulta
            $filtros->execute();
        }
        else{
            $filtros = $conn->prepare($sql);
            $filtros->execute();
        }

        // Extraemos los resultados a un array
        $contenido  = $filtros->fetchAll(PDO::FETCH_ASSOC);

        // Cerramos la conexión
        $conn = null;
    ?>
</head>
<body>
    <div class="container">
        <!-- LOGOTIPO -->
        <div class="logotipo"><a href="index.html"><img src="./logo.png"></a></div>

        <!-- MAIN -->
        <div class="main">
            <!-- TÍTULO SECCIÓN -->
            <div class="seccion-titulo">CLIENTE</div>

            <!-- SUBTÍTULO SECCIÓN -->
            <div class="seccion-subtitulo">FILTRO DE BÚSQUEDA</div>

            <!-- FILTRO DE BÚSQUEDA -->
            <div class="busqueda">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                    <!-- LOCALIDAD -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campo">
                            <label for="localidad">Localidad</label>
                        </div>
                        <div class="busqueda-campo-texto">
                            <?php
                                if((isset($_POST['localidad'])) && ($_POST['localidad'] != null)){
                                    echo '<input type="text" id="localidad" name="localidad" value="'.$_POST['localidad'].'">';
                                }
                                else{
                                    echo '<input type="text" id="localidad" name="localidad">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- PROVINCIA -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campo">
                            <label for="provincia">Provincia</label>
                        </div>
                        <div class="busqueda-campo-texto">
                            <?php
                                if((isset($_POST['provincia'])) && ($_POST['provincia'] != null)){
                                    echo '<input type="text" id="provincia" name="provincia" value="'.$_POST['provincia'].'">';
                                }
                                else{
                                    echo '<input type="text" id="provincia" name="provincia">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- TIPO INMUEBLE -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campo">
                            <label for="tipoinmueble">Tipo Inmueble</label>
                        </div>
                        <div class="busqueda-campo-texto">
                            <?php
                                if((isset($_POST['tipoinmueble'])) && ($_POST['tipoinmueble'] != null)){
                                    echo '<input type="text" id="tipoinmueble" name="tipoinmueble" value="'.$_POST['tipoinmueble'].'">';
                                }
                                else{
                                    echo '<input type="text" id="tipoinmueble" name="tipoinmueble">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- NUMERO DE DORMITORIOS -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campo">
                            <label for="dormitorios">Dormitorios Min.</label>
                        </div>
                        <div class="busqueda-campo-texto">
                            <?php
                                if((isset($_POST['dormitorios'])) && ($_POST['dormitorios'] != null)){
                                    echo '<input type="number" id="dormitorios" name="dormitorios" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['dormitorios'].'">';
                                }
                                else{
                                    echo '<input type="number" id="dormitorios" name="dormitorios" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- NUMERO DE BAÑOS -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campo">
                            <label for="wc">Baños Min.</label>
                        </div>
                        <div class="busqueda-campo-texto">
                            <?php
                                if((isset($_POST['wc'])) && ($_POST['wc'] != null)){
                                    echo '<input type="number" id="wc" name="wc" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['wc'].'">';
                                }
                                else{
                                    echo '<input type="number" id="wc" name="wc" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- PRECIO MAXIMO -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campo">
                            <label for="precio">Precio Max.</label>
                        </div>
                        <div class="busqueda-campo-texto">
                            <?php
                                if((isset($_POST['precio'])) && ($_POST['precio'] != null)){
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['precio'].'">';
                                }
                                else{
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- BOTON DE ENVIAR -->
                    <div class="busqueda-linea">
                        <div class="busqueda-campoboton">
                            <input type="submit" value="ENVIAR" name="submit">
                        </div>
                    </div>
                </form>
            </div>

            <!-- SUBTÍTULO SECCIÓN -->
            <div class="seccion-subtitulo">INMUEBLES DISPONIBLES: <?= count($contenido); ?></div>

            <!-- LISTA DE INMUEBLES -->
            <?php foreach($contenido as $fila){ ?>
            <div class="listado">
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Localidad:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['localidad']; ?>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Provincia:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['provincia']; ?>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Dirección:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['direccion']; ?>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Tipo Inmueble:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['tipoinmueble']; ?>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Tamaño m<sup>2</sup>:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['tamano']; ?>m<sup>2</sup>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Dormitorios:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['dormitorios']; ?>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Baños:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['wc']; ?>
                    </div>
                </div>
                <div class="listado-linea">
                    <div class="listado-texto-titulo">
                        Precio:
                    </div>
                    <div class="listado-texto">
                        <?= $fila['precio']; ?>€
                    </div>
                </div>
                <div class="listado-imagen">
                    <img src=<?= $fila['imagen']; ?>>
                </div>
            </div>
            <?php } ?>

        </div>
        <button onclick="location.href='index.html'" type="submit" class="botones">VOLVER</button>
        <div class="footer">©2023 TecnoZV Inmobiliaria. Daniel Amores Corzo<br>DWES - Desarrollo en Entorno Servidor</div>
    </div>
</body>
</html>