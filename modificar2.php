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
        // Comprobamos si estamos solicitando los datos del inmueble a modificar o si por el contrario estamos enviando los datos ya modificados
        if(($_SERVER["REQUEST_METHOD"] == 'POST') && isset($_POST['check'])){
            // En caso de estar solicitando los datos del inmueble, realizamos la consulta con el numero de ID
            $sql = $conn->prepare("SELECT * FROM $table WHERE id = :id");
            $sql->bindParam(':id', $_POST['id']);
            $sql->execute();
            $contenido = $sql->fetch(PDO::FETCH_ASSOC);
        }
        else if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // Preparamos la consulta de UPDATE en caso de que el usuario este pasando los datos de modificación
            $sql = $conn->prepare("UPDATE $table SET localidad=?, provincia=?, direccion=?, tipoinmueble=?, tamano=?, dormitorios=?, wc=?, precio=? WHERE id=?;");

            // Pasamos a parametrizar los valores espceficando el tipo de dato a insertar STR, INT, etc
            $sql->bindParam(1, $_POST['localidad'], PDO::PARAM_STR);
            $sql->bindParam(2, $_POST['provincia'], PDO::PARAM_STR);
            $sql->bindParam(3, $_POST['direccion'], PDO::PARAM_STR);
            $sql->bindParam(4, $_POST['tipoinmueble'], PDO::PARAM_STR);
            $sql->bindParam(5, $_POST['tamano'], PDO::PARAM_INT);
            $sql->bindParam(6, $_POST['dormitorios'], PDO::PARAM_INT);
            $sql->bindParam(7, $_POST['wc'], PDO::PARAM_INT);
            $sql->bindParam(8, $_POST['precio'], PDO::PARAM_INT);
            $sql->bindParam(9, $_POST['id'], PDO::PARAM_INT);
            $sql->execute();

            // Cerramos la conexion con el servidor
            $conn = null;
    
            // Redirigimos a la página de modificar para evitar reenvios de formularios con F5
            header("Location: modificar.php");
            exit();
        }
    ?>
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
            <div class="seccion-subtitulo">MODIFICAR DATOS</div>

            <!-- FORMULARIO DE PETICION AL USUARIO -->
            <div class="formulario">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

                <!-- CAMPO DE LOCALIDAD -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="localidad">Localidad</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($contenido['localidad'])){
                                    echo '<input type="text" id="localidad" name="localidad" value="'.$contenido['localidad'].'">';
                                }
                                else if(isset($_POST['localidad'])){
                                    echo '<input type="text" id="localidad" name="localidad" value="'.$_POST['localidad'].'">';
                                }
                                else{
                                    echo '<input type="text" id="localidad" name="localidad">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE PROVINCIA -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="provincia">Provincia</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                $provincias = array(
                                    "A Coruña",
                                    "Álava",
                                    "Albacete",
                                    "Alicante",
                                    "Almería",
                                    "Asturias",
                                    "Ávila",
                                    "Badajoz",
                                    "Baleares",
                                    "Barcelona",
                                    "Bizkaia",
                                    "Burgos",
                                    "Cáceres",
                                    "Cádiz",
                                    "Cantabria",
                                    "Castellón",
                                    "Ciudad Real",
                                    "Córdoba",
                                    "Cuenca",
                                    "Gipuzkoa",
                                    "Girona",
                                    "Granada",
                                    "Guadalajara",
                                    "Huelva",
                                    "Huesca",
                                    "Jaén",
                                    "La Rioja",
                                    "Las Palmas",
                                    "León",
                                    "LLeida",
                                    "Lugo",
                                    "Madrid",
                                    "Málaga",
                                    "Murcia",
                                    "Navarra",
                                    "Ourense",
                                    "Palencia",
                                    "Pontevedra",
                                    "Salamanca",
                                    "Santa Cruz de Tenerife",
                                    "Segovia",
                                    "Sevilla",
                                    "Soria",
                                    "Tarragona",
                                    "Teruel",
                                    "Toledo",
                                    "Valencia",
                                    "Valladolid",
                                    "Zamora",
                                    "Zaragoza"
                                );

                                echo '<select name="provincia" id="provincia">';
                                foreach($provincias as $provincia){
                                    if(isset($contenido['provincia']) && ($contenido['provincia'] == $provincia)){
                                        echo '<option value="'.$provincia.'" selected>'.$provincia.'</option>';
                                    }
                                    else if(isset($_POST['provincia']) && ($_POST['provincia'] == $provincia)){
                                        echo '<option value="'.$provincia.'" selected>'.$provincia.'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$provincia.'">'.$provincia.'</option>';
                                    }
                                }
                                echo '</select>';
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE DIRECCIÓN -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="direccion">Dirección</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($contenido['direccion'])){
                                    echo '<input type="text" id="direccion" name="direccion" value="'.$contenido['direccion'].'">';
                                }
                                else if(isset($_POST['direccion']) && ($_POST['direccion'])){
                                    echo '<input type="text" id="direccion" name="direccion" value="'.$_POST['direccion'].'">';
                                }
                                else{
                                    echo '<input type="text" id="direccion" name="direccion">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE TIPO DE INMUEBLE -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="tipoinmueble">Tipo Inmueble</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                $tiposinmueble = array(
                                    "Adosado",
                                    "Aislado",
                                    "Apartamento",
                                    "Ático",
                                    "Bajo con Jardín",
                                    "Casa",
                                    "Dúplex",
                                    "Estudio",
                                    "Piso",
                                );

                                echo '<select name="tipoinmueble" id="tipoinmueble">';
                                foreach($tiposinmueble as $tipoinmueble){
                                    if(isset($contenido['tipoinmueble']) && ($contenido['tipoinmueble'] == $tipoinmueble)){
                                        echo '<option value="'.$tipoinmueble.'" selected>'.$tipoinmueble.'</option>';
                                    }
                                    if((isset($_POST['tipoinmueble'])) && ($_POST['tipoinmueble'] == $tipoinmueble)){
                                        echo '<option value="'.$tipoinmueble.'" selected>'.$tipoinmueble.'</option>';
                                    }
                                    else{
                                        echo '<option value="'.$tipoinmueble.'">'.$tipoinmueble.'</option>';
                                    }
                                }
                                echo '</select>';
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE METROS -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="tamano">Tamaño m<sup>2</sup></label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($contenido['tamano'])){
                                    echo '<input type="number" id="tamano" name="tamano" inputmode="numeric" pattern="[0-9]+" value="'.$contenido['tamano'].'">';
                                }
                                else if(isset($_POST['tamano'])){
                                    echo '<input type="number" id="tamano" name="tamano" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['tamano'].'">';
                                }
                                else{
                                    echo '<input type="number" id="tamano" name="tamano" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE DORMITORIOS -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <Label for="dormitorios">Dormitorios</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($contenido['dormitorios'])){
                                    echo '<input type="number" id="dormitorios" name="dormitorios" inputmode="numeric" pattern="[0-9]+" value="'.$contenido['dormitorios'].'">';
                                }
                                else if(isset($_POST['dormitorios'])){
                                    echo '<input type="number" id="dormitorios" name="dormitorios" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['dormitorios'].'">';
                                }
                                else{
                                    echo '<input type="number" id="dormitorios" name="dormitorios" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE BAÑOS -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="wc">Baños</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($contenido['wc'])){
                                    echo '<input type="number" id="wc" name="wc" inputmode="numeric" pattern="[0-9]+" value="'.$contenido['wc'].'">';
                                }
                                else if(isset($_POST['wc'])){
                                    echo '<input type="number" id="wc" name="wc" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['wc'].'">';
                                }
                                else{
                                    echo '<input type="number" id="wc" name="wc" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE PRECIO -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="precio">Precio</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($contenido['precio'])){
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+" value="'.$contenido['precio'].'">';
                                }
                                else if(isset($_POST['precio'])){
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['precio'].'">';
                                }
                                else{
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO ID OCULTO -->
                    <?php
                        if(isset($contenido['id'])){
                            echo '<input type="hidden" id="id" name="id" value="'.$contenido['id'].'">';
                        }
                    ?>

                    <!-- BOTON DE ENVIAR -->
                    <div class="formulario-linea">
                        <div class="campo-texto campoboton">
                            <input type="submit" value="ENVIAR" name="submit">
                        </div>
                    </div>

                </form>
            </div>
            <!-- FIN DE FORMULARIO -->
        </div>
        <button onclick="location.href='modificar.php'" type="submit" class="botones">VOLVER</button>
        <div class="footer">©2023 TecnoZV Inmobiliaria. Daniel Amores Corzo<br>DWES - Desarrollo en Entorno Servidor</div>
    </div>
</body>
</html>