<?php 
include '../config/conexion.php'; 

// Obtener el ID del libro si viene desde el index
$id_libro_seleccionado = isset($_GET['id']) ? $_GET['id'] : '';

// Consultas para llenar los selects
$libros = mysqli_query($conexion, "SELECT id, titulo FROM libros WHERE cantidad_disponible > 0");
// Consulta para traer nombre y grado
$alumnos = mysqli_query($conexion, "SELECT id, nombre, grado_salon FROM alumnos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Préstamo - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container"><a class="navbar-brand" href="index.php">⬅ Volver al Panel</a></div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Registrar Salida de Libro</h4>
                    </div>
                    <div class="card-body">
                        <form action="../acciones/guardar_prestamo.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Seleccionar Libro:</label>
                                <select name="id_libro" class="form-select" required>
                                    <option value="">-- Seleccione un libro --</option>
                                    <?php while($l = mysqli_fetch_assoc($libros)): ?>
                                        <option value="<?php echo $l['id']; ?>" <?php echo ($l['id'] == $id_libro_seleccionado) ? 'selected' : ''; ?>>
                                            <?php echo $l['titulo']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alumno:</label>
                                <select name="id_alumno" class="form-select" required>
                                    <option value="">-- Seleccione al alumno --</option>
                                    <?php while($a = mysqli_fetch_assoc($alumnos)): ?>
                                        <option value="<?php echo $a['id']; ?>">
                                            <?php echo $a['nombre'] . " (" . $a['grado_salon'] . ")"; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fecha de Devolución:</label>
                                <input type="date" name="fecha_entrega" class="form-control" required 
                                       value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>">
                                <small class="text-muted">Por defecto: 7 días a partir de hoy.</small>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Confirmar Préstamo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>