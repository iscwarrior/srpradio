<?php

$mysqli = new mysqli("localhost", "root", "", "dbr4d10");
if ($mysqli->connect_errno) { echo "Fallo al conectar a MySQL: (" . $mysqli->connect_error . ") " . $mysqli->connect_error; }

?>