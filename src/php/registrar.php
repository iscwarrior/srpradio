<?php
// session_start();
 $mysqli = new mysqli("localhost","root", "", "dbr4d10");
 if ($mysqli->connect_errno) { 
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_error . ") " . $mysqli->connect_error; 
}
    $nombreEmpresa = $_POST['nombreEmpresa'];
    $nombreVideo = $_POST['nombreVideo'];
    $tduracion = $_POST['tduracion'];
    $fechaInicial = $_POST['fechaInicial'];
    $fechaFinal = $_POST['fechaFinal'];
    $vxDia = $_POST['vxDia']; 
    // $dias = implode(',', $_POST['dias']); // Combina los días excluidos en una cadena
    $dias = isset($_POST['dias']) ? implode(',', $_POST['dias']) : ''; // Combina los días excluidos en una cadena
    $tPublicaciones = $_POST['tPublicaciones'];
    // $archivoUp = $FILES['archivoUp']; // Ruta del video
    $comentarios = $_POST['comentarios'];
    $esUrgente = isset($_POST['esUrgente']) ? 1 : 0; // 1 si está marcado, 0 si no
    $fechaRegistro= date("Y-m-d");  // Fecha actual
       
    if ($nombreEmpresa=='') { $nombreEmpresa='Empresa no especificada';}
    if ($dias=='') { $dias=0; }
    if ($tPublicaciones='') {$tPublicaciones ='0'}
    // if ($archivoUp == '') { $archivoUp ='no se cargo ningun archivo';}
    
    // Manejo de la subida de archivos
    if (isset($_FILES['archivoUp']) && $_FILES['archivoUp']['error'] == UPLOAD_ERR_OK) {
        $archivo_tmp = $_FILES['archivoUp']['tmp_name'];
        $archivo_nombre = $_FILES['archivoUp']['name'];
        $archivo_destino = 'C:/xampp/htdocs/srpradio/uploads/' . basename($archivo_nombre); // Cambia esta ruta a donde quieras guardar el archivo

        // Mueve el archivo a la ubicación deseada
        if (move_uploaded_file($archivo_tmp, $archivo_destino)) { echo "El archivo se ha subido correctamente."; } 
            else { echo "Error al mover el archivo."; }
                return $archivo_destino; } 
                    else { echo "No se ha subido ningún archivo o ha ocurrido un error."; }

    // Query de registro de información
    $mysqli -> query ("INSERT INTO info_promocionales (nombre_cliente_empresa, nombre_video, tiempo_duracion_seg, fecha_inicial, fecha_final, veces_x_dia, dias_excluidos, total_publicaciones, ruta_video, comentarios, es_urgente, fecha_registro ) 
                      VALUES ('$nombreEmpresa', '$nombreVideo', $tduracion, '$fechaInicial', '$fechaFinal', $vxDia, '$dias', $tPublicaciones, '$archivo_destino','$comentarios', $esUrgente, '$fechaRegistro')");

    // $mysqli -> query ("INSERT INTO info_promocionales (nombre_cliente_empresa, nombre_video, tiempo_duracion_seg, fecha_inicial, fecha_final, veces_x_dia, dias_excluidos, total_publicaciones, ruta_video, comentarios, es_urgente, fecha_registro ) 
    // VALUES ('Maximo 123', 'audio', 10, '2024-04-17', '2024-04-17', 2, 'Lunes', 2, 'aaaassssaaaa','121212', 'true', '2025-12-12')");

    // Prepara la consulta SQL
    // $stmt = $mysqli->prepare("INSERT INTO info_promocionales (nombre_cliente_empresa, nombre_video, tiempo_duracion_seg, fecha_inicial, fecha_final, veces_x_dia, dias_excluidos, total_publicaciones, comentarios, es_urgente, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    // $stmt->bind_param("ssississsis", $nombre_cliente_empresa, $nombre_video, $tiempo_duracion_seg, $fecha_inicial, $fecha_final, $veces_x_dia, $dias_excluidos, $total_publicaciones, $comentarios, $es_urgente, $fecha_registro);

    // Ejecuta la consulta
    // if ($mysqli->execute()) {
    //     echo "Registro insertado correctamente.";
    // } else {
    //     echo "Error al insertar el registro: " . $mysqli->error;
    // }

    // // Cierra la conexión
    // $stmt->close();
    // $mysqli->close();

    $idFolio=mysqli_insert_id($mysqli); // obtengo el id del insert anterior 
    if($idFolio==0) {$msjSeg = 'No_insert';} else { $msjSeg ='Insert_exitoso';}  

    header("location: registrar.php?idseg=$idFolio&msj=$msjSeg");
?>
