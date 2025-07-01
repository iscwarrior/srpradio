<?php
// Conexión a la base de datos
$mysqli = new mysqli("localhost", "root", "", "dbr4d10");
if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}

// Obtener la fecha desde el formulario
$fecha = isset($_GET['trip-start']) ? $_GET['trip-start'] : date('Y-m-d');

// Consultar registros para esa fecha
$sql = "SELECT * FROM info_promocionales WHERE fecha_inicial <= ? AND fecha_final >= ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $fecha, $fecha);
$stmt->execute();
$result = $stmt->get_result();

// Crear XML
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Programs></Programs>');

while ($row = $result->fetch_assoc()) {
    $program = $xml->addChild('Program');
    $program->addChild('Source', 'LEDVISION');
    $program->addChild('Width', '448');
    $program->addChild('Height', '256');
    $program->addChild('Duration', $row['tiempo_duracion_seg'] * 1000);

    $pages = $program->addChild('Pages');
    $page = $pages->addChild('Page');
    $page->addChild('Name', $row['nombre_cliente_empresa']);
    $page->addChild('AppointDuration', $row['tiempo_duracion_seg'] * 1000);
    $page->addChild('LoopType', '1');

    $regions = $page->addChild('Regions');
    $region = $regions->addChild('Region');
    $region->addChild('Name', 'Ventana Principal');

    $rect = $region->addChild('Rect');
    $rect->addChild('X', '0');
    $rect->addChild('Y', '0');
    $rect->addChild('Width', '448');
    $rect->addChild('Height', '256');

    $items = $region->addChild('Items');
    $item = $items->addChild('Item');
    $item->addChild('Name', $row['nombre_video']);
    $item->addChild('Type', '3'); // Tipo video
    $item->addChild('Duration', $row['tiempo_duracion_seg'] * 1000);
    $item->addChild('FilePath', $row['ruta_video']);

    $effect = $item->addChild('inEffect');
    $effect->addChild('Type', '1');
    $effect->addChild('Time', '500');
}

// Cabeceras para descargar
header('Content-Type: application/xml');
header('Content-Disposition: attachment; filename="programacion_' . $fecha . '.xml"');

echo $xml->asXML();
?>