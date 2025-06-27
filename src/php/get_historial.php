<?php
$mysqli = new mysqli("localhost", "root", "", "dbr4d10");

if ($mysqli->connect_error) {
  die("Conexión fallida: " . $mysqli->connect_error);
}

$query = "SELECT * FROM info_promocionales";
$result = $mysqli->query($query);

$data = array();
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode(["data" => $data]);

$mysqli->close();
?>
