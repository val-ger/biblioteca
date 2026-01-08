<?php
include '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $grado = mysqli_real_escape_string($conexion, $_POST['grado']);

    $sql = "INSERT INTO alumnos (nombre, grado_salon) VALUES ('$nombre', '$grado')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../vistas/alumnos.php?status=ok");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>