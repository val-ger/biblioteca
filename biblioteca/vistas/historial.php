<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Préstamos - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        /* Estilos para que la impresión salga limpia */
        @media print {
            .navbar, .btn-print, .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                padding: 0;
            }
            .container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 no-print">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-book"></i> Biblioteca Marta</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Inicio</a>
                <a class="nav-link" href="inventario.php">Inventario</a>
                <a class="nav-link active" href="historial.php">Ver Préstamos</a>
                <a class="nav-link" href="alumnos.php">Alumnos</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <h2 class="mb-0">📋 Relación de Libros Prestados</h2>
            
            <button onclick="window.print()" class="btn btn-danger shadow-sm no-print">
                <i class="bi bi-file-earmark-pdf"></i> Exportar a PDF / Imprimir
            </button>
        </div>

        <div class="card shadow border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>Alumno</th>
                            <th>Grado/Salón</th>
                            <th>Libro</th>
                            <th>Fecha Salida</th>
                            <th>Fecha Devolución</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT a.nombre, a.grado_salon, l.titulo, p.fecha_salida, p.fecha_devolucion_esperada, p.estado 
                                FROM prestamos p
                                JOIN alumnos a ON p.id_alumno = a.id
                                JOIN libros l ON p.id_libro = l.id
                                ORDER BY p.fecha_salida DESC";
                        $res = mysqli_query($conexion, $sql);
                        
                        if (mysqli_num_rows($res) > 0) {
                            while($f = mysqli_fetch_assoc($res)): ?>
                            <tr>
                                <td><strong><?php echo $f['nombre']; ?></strong></td>
                                <td><span class="badge bg-info text-dark"><?php echo $f['grado_salon'] ?: 'Sin asignar'; ?></span></td>
                                <td><?php echo $f['titulo']; ?></td>
                                <td><?php echo $f['fecha_salida']; ?></td>
                                <td><?php echo $f['fecha_devolucion_esperada']; ?></td>
                                <td>
                                    <?php echo ($f['estado'] == 'pendiente') ? 
                                        '<span class="text-danger"><i class="bi bi-clock"></i> Pendiente</span>' : 
                                        '<span class="text-success"><i class="bi bi-check-circle"></i> Devuelto</span>'; ?>
                                </td>
                            </tr>
                            <?php endwhile; 
                        } else {
                            echo "<tr><td colspan='6' class='text-center p-4 text-muted'>No hay registros de préstamos todavía.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="d-none d-print-block mt-4 text-center">
            <p class="text-muted small">Reporte generado el: <?php echo date('d/m/Y H:i'); ?></p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>