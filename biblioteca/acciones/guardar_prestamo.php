<?php
include '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = $_POST['id_libro'];
    $id_alumno = $_POST['id_alumno'];
    $fecha_salida = date('Y-m-d');
    $fecha_entrega = $_POST['fecha_entrega'];

    // 1. Insertar el préstamo
    $sql_prestamo = "INSERT INTO prestamos (id_libro, id_alumno, fecha_salida, fecha_devolucion_esperada, estado) 
                     VALUES ('$id_libro', '$id_alumno', '$fecha_salida', '$fecha_entrega', 'pendiente')";
    
    // 2. Restar 1 al stock disponible
    $sql_update_libro = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = '$id_libro'";

    // 3. Marcar deuda al alumno
    $sql_update_alumno = "UPDATE alumnos SET tiene_deuda = 1 WHERE id = '$id_alumno'";

    // Ejecutar todo (lo ideal es usar transacciones, pero para empezar así está bien)
    if (mysqli_query($conexion, $sql_prestamo) && 
        mysqli_query($conexion, $sql_update_libro) && 
        mysqli_query($conexion, $sql_update_alumno)) {
        
        header("Location: ../vistas/index.php?status=prestado");
    } else {
        echo "Error al procesar el préstamo: " . mysqli_error($conexion);
    }
}
?>