<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $date = $_POST['date'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['file']['name'];
        $fileTmpPath = $_FILES['file']['tmp_name'];
        
        // Mover archivo a una carpeta específica
        $uploadDir = 'uploads/';
        $uploadPath = $uploadDir . basename($fileName);

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($fileTmpPath, $uploadPath)) {
            echo "Archivo subido exitosamente: $fileName<br>";
        } else {
            echo "Error al subir el archivo.<br>";
        }
    }

    echo "<h2>Datos recibidos:</h2>";
    echo "<p><strong>Nombre:</strong> $name</p>";
    echo "<p><strong>Fecha:</strong> $date</p>";
}
?>
