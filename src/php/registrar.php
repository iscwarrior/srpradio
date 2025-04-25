<?php
$mysqli = new mysqli("localhost", "root", "", "dbr4d10");
if ($mysqli->connect_errno) {
    die("Fallo al conectar a MySQL: " . $mysqli->connect_error);
}

    $nombreEmpresa  = $_POST['nombreEmpresa'] ?? 'Empresa no especificada';
    $nombreVideo    = $_POST['nombreVideo'] ?? '';
    $tduracion      = intval($_POST['tduracion'] ?? 0);
    $fechaInicial   = $_POST['fechaInicial'] ?? null;
    $fechaFinal     = $_POST['fechaFinal'] ?? null;
    $vxDia          = intval($_POST['vxDia'] ?? 0);
    $dias           = isset($_POST['dias']) ? implode(',', $_POST['dias']) : '0';
    $tPublicaciones = intval($_POST['tPublicaciones'] ?? 0);
    $comentarios    = $_POST['comentarios'] ?? '';
    $esUrgente      = isset($_POST['esUrgente']) ? 1 : 0;
    $fechaRegistro  = date("Y-m-d");

    $archivo_destino = '';
    if (isset($_FILES['archivoUp']) && $_FILES['archivoUp']['error'] === UPLOAD_ERR_OK) {
        $archivo_tmp     = $_FILES['archivoUp']['tmp_name'];
        $archivo_nombre  = basename($_FILES['archivoUp']['name']);
        $archivo_destino = 'C:/xampp/htdocs/srpradio/uploads/' . $archivo_nombre;

        if (!move_uploaded_file($archivo_tmp, $archivo_destino)) { $archivo_destino = ''; }
    }

    // Prepara consulta
    $sql = "INSERT INTO info_promocionales (
            nombre_cliente_empresa, 
            nombre_video, 
            tiempo_duracion_seg,
            fecha_inicial, 
            fecha_final, 
            veces_x_dia, 
            dias_excluidos,
            total_publicaciones, 
            ruta_video, 
            comentarios, 
            es_urgente, 
            fecha_registro
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("Error en prepare: " . $mysqli->error);
    }

    $stmt->bind_param(
        "ssississssis",
        $nombreEmpresa,
        $nombreVideo,
        $tduracion,
        $fechaInicial,
        $fechaFinal,
        $vxDia,
        $dias,
        $tPublicaciones,
        $archivo_destino,
        $comentarios,
        $esUrgente,
        $fechaRegistro
    );

    // Ejecuta e interpreta resultado
    if ($stmt->execute()) {
        $idFolio = $stmt->insert_id;
        $msjSeg = 'Insert_exitoso';
    } else {
        $idFolio = 0;
        $msjSeg = 'No_insert';
        error_log("Error al insertar: " . $stmt->error); // Para registro en logs
    }

    // Cierra y redirige
    $stmt->close();
    $mysqli->close();

    header("Location: /srpradio/registro.html?idseg=$idFolio&msj=$msjSeg");
    exit;
?>
