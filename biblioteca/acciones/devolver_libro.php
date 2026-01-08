<?php
include '../config/conexion.php';

if (isset($_GET['id'])) {
    $id_prestamo = $_GET['id'];

    // 1. Obtener el ID del libro de ese préstamo para devolverlo al stock
    $query_info = "SELECT id_libro, id_alumno FROM prestamos WHERE id = '$id_prestamo'";
    $res_info = mysqli_query($conexion, $query_info);
    $info = mysqli_fetch_assoc($res_info);
    $id_libro = $info['id_libro'];
    $id_alumno = $info['id_alumno'];

    // 2. Actualizar estado del préstamo
    $sql_devuelto = "UPDATE prestamos SET estado = 'devuelto' WHERE id = '$id_prestamo'";
    
    // 3. Devolver el libro al inventario (+1)
    $sql_stock = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = '$id_libro'";

    // 4. Quitar la marca de deuda al alumno (opcional, si solo tenía ese libro)
    $sql_alumno = "UPDATE alumnos SET tiene_deuda = 0 WHERE id = '$id_alumno'";

    if (mysqli_query($conexion, $sql_devuelto) && mysqli_query($conexion, $sql_stock) && mysqli_query($conexion, $sql_alumno)) {
        header("Location: ../vistas/deudores.php?msj=devuelto");
    } else {
        echo "Error al procesar devolución";
    }
}
?>