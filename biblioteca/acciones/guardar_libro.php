<?php
include '../config/conexion.php'; // Subimos un nivel para encontrar la carpeta config

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $cantidad = $_POST['cantidad'];

    // Insertamos el libro. La cantidad disponible inicialmente es igual a la total.
    $sql = "INSERT INTO libros (titulo, autor, cantidad_total, cantidad_disponible) 
            VALUES ('$titulo', '$autor', '$cantidad', '$cantidad')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../vistas/inventario.php?msj=ok");
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>