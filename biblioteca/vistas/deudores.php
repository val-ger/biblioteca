<?php 
include '../config/conexion.php'; 

// Consulta para unir las 3 tablas y saber: qué libro tiene quién y cuándo debía entregarlo
$query = "SELECT p.id as id_prestamo, l.titulo, a.nombre, a.grado_salon, p.fecha_devolucion_esperada 
          FROM prestamos p
          JOIN libros l ON p.id_libro = l.id
          JOIN alumnos a ON p.id_alumno = a.id
          WHERE p.estado = 'pendiente'";

$resultado = mysqli_query($conexion, $query);
$hoy = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Deudores - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-danger mb-4">
        <div class="container"><a class="navbar-brand" href="index.php">⬅ Volver al Panel</a></div>
    </nav>

    <div class="container">
        <h2 class="mb-4">⚠️ Libros Pendientes de Devolución</h2>
        
        <div class="card shadow">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Alumno</th>
                            <th>Libro</th>
                            <th>Fecha Límite</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($fila = mysqli_fetch_assoc($resultado)): 
                            $es_tarde = ($hoy > $fila['fecha_devolucion_esperada']);
                        ?>
                        <tr>
                            <td><strong><?php echo $fila['nombre']; ?></strong></td>
                            <td><?php echo $fila['titulo']; ?></td>
                            <td><?php echo $fila['fecha_devolucion_esperada']; ?></td>
                            <td>
                                <?php if($es_tarde): ?>
                                    <span class="badge bg-danger">¡RETRASADO!</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">En tiempo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="../acciones/devolver_libro.php?id=<?php echo $fila['id_prestamo']; ?>" 
                                   class="btn btn-sm btn-success">Marcar Devolución</a>
                            </td>
                            <th>Alumno</th>
                            <th>Salón</th> <th>Libro</th>

                            <td><strong><?php echo $fila['nombre']; ?></strong></td>
                            <td><?php echo $fila['grado_salon']; ?></td> <td><?php echo $fila['titulo']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>