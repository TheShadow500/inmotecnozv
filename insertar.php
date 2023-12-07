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
        // Comprobamos si se ha enviado el formulario
        if($_SERVER["REQUEST_METHOD"] == 'POST'){
            // Comprobamos que se haya enviado un archivo (luego comprobaremos que sea una imagen)
            if(isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK){
                // Asignamos un nombre unico interno para el archivo
                $archivo_info = pathinfo($_FILES['foto']['name']);
                $nombre_archivo = uniqid('foto_') . '.' . $archivo_info['extension'];
                $target_dir = 'fotos/';
                $target_file = $target_dir . $nombre_archivo;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
                // Comprobamos que sea una imagen, que el archivo no exista, que cumpla el tamaño maximo y el tipo de archivo
                $uploadOk = 0;
                if(isset($_POST['submit'])){
                    $check = getimagesize($_FILES['foto']['tmp_name']);
                    if(!$check){
                        echo '<script>alert("El archivo no es una imagen");</script>';
                    }    
                    else if(file_exists($target_file)){
                        echo '<script>alert("El archivo ya existe");</script>';
                    }
                    else if($_FILES['foto']['size'] > 2000000){
                        echo '<script>alert("El archivo es demasiado grande (Max. 2Mb)");</script>';
                    }
                    else if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif'){
                        echo '<script>alert("Solo se aceptan archivos JPG, JPEG, PNG y GIF");</script>';
                    }
                    else{
                        $uploadOk = 1;
                    }

                    // En caso de que algo haya fallado lo mostramos por pantalla y en caso contrario almacenamos en el CSV la informacion
                    if($uploadOk == 0){
                        echo '<script>alert("El archivo no ha podido ser subido");</script>';
                    }
                    else{
                        // En el caso de haber podido mover bien la imagen, tomamos los datos y los pasamos a un array
                        if(move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)){
                            // Preparamos la consulta de INSERT
                            $sql = $conn->prepare("INSERT INTO $table (localidad, provincia, direccion, tipoinmueble, tamano, dormitorios, wc, precio, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);");

                            // Pasamos a parametrizar los valores espceficando el tipo de dato a insertar STR, INT, etc
                            $sql->bindParam(1, $_POST['localidad'], PDO::PARAM_STR);
                            $sql->bindParam(2, $_POST['provincia'], PDO::PARAM_STR);
                            $sql->bindParam(3, $_POST['direccion'], PDO::PARAM_STR);
                            $sql->bindParam(4, $_POST['tipoinmueble'], PDO::PARAM_STR);
                            $sql->bindParam(5, $_POST['tamano'], PDO::PARAM_INT);
                            $sql->bindParam(6, $_POST['dormitorios'], PDO::PARAM_INT);
                            $sql->bindParam(7, $_POST['wc'], PDO::PARAM_INT);
                            $sql->bindParam(8, $_POST['precio'], PDO::PARAM_INT);
                            $sql->bindParam(9, $target_file, PDO::PARAM_STR);
                            $sql->execute();
                    
                            // Cerramos la conexion con el servidor
                            $conn = null;

                            // Informamos al usuario que se ha almacenado con éxito y redirigimos a la página de inicio para evitar reenvios de formularios con F5
                            header("Location: ".$_SERVER['PHP_SELF']);
                            exit();
                        }
                        else{
                            echo '<script>alert("Ha habido un error subiendo el archivo");</script>';
                        }
                    }
                }
            }
            else{
                echo '<script>';
                echo 'alert("No se ha seleccionado ninguna imagen");';
                echo '</script>';
            }
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
            <div class="seccion-subtitulo">DATOS DEL INMUEBLE</div>

            <!-- FORMULARIO DE PETICION AL USUARIO -->
            <div class="formulario">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

                    <!-- CAMPO DE LOCALIDAD -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label for="localidad">Localidad</label>
                        </div>
                        <div class="campo-texto">
                            <?php
                                if(isset($_POST['localidad'])){
                                    echo '<input type="text" id="localidad" name="localidad" value='.$_POST['localidad'].'>';
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
                                    if(isset($_POST['provincia']) && ($_POST['provincia'] == $provincia)){
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
                                if(isset($_POST['direccion'])){
                                    echo '<input type="text" id="direccion" name="direccion" value='.$_POST['direccion'].'>';
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
                                if(isset($_POST['tamano'])){
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
                                if(isset($_POST['dormitorios'])){
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
                                if(isset($_POST['wc'])){
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
                                if(isset($_POST['precio'])){
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+" value="'.$_POST['precio'].'">';
                                }
                                else{
                                    echo '<input type="number" id="precio" name="precio" inputmode="numeric" pattern="[0-9]+">';
                                }
                            ?>
                        </div>
                    </div>

                    <!-- CAMPO DE IMAGEN -->
                    <div class="formulario-linea">
                        <div class="campo">
                            <label>Imagen:</label>
                        </div>
                        <div class="campo-texto-file">
                            <label for="foto" class="custom-input-file">Examinar</label>
                            <input type="file" id="foto" name="foto">
                        </div>
                    </div>

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
        <button onclick="location.href='admin.php'" type="submit" class="botones">VOLVER</button>
        <div class="footer">©2023 TecnoZV Inmobiliaria. Daniel Amores Corzo<br>DWES - Desarrollo en Entorno Servidor</div>
    </div>
</body>
</html>