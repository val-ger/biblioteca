<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Deudores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>⚠️ Lista de Deudores - Biblioteca</h2>
        <button onclick="window.print()" class="btn btn-dark no-print">Imprimir Reporte</button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Grado</th>
                <th>Libro</th>
                <th>Fecha Límite</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT a.nombre, a.grado_salon, l.titulo, p.fecha_devolucion_esperada 
                    FROM prestamos p
                    JOIN alumnos a ON p.id_alumno = a.id
                    JOIN libros l ON p.id_libro = l.id
                    WHERE p.estado = 'pendiente'";
            $res = mysqli_query($conexion, $sql);
            while($f = mysqli_fetch_assoc($res)): ?>
            <tr>
                <td><?php echo $f['nombre']; ?></td>
                <td><?php echo $f['grado_salon']; ?></td>
                <td><?php echo $f['titulo']; ?></td>
                <td class="text-danger"><strong><?php echo $f['fecha_devolucion_esperada']; ?></strong></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <p class="mt-4 text-muted small text-center">Reporte generado el: <?php echo date('d/m/Y'); ?></p>
</body>
</html>