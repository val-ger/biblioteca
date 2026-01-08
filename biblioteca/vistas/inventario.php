<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-book"></i> Biblioteca Marta</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Inicio</a>
                <a class="nav-link active" href="inventario.php">Inventario</a>
                <a class="nav-link" href="prestar.php">Nuevo Préstamo</a>
                <a class="nav-link" href="historial.php">Ver Préstamos</a>
                <a class="nav-link" href="alumnos.php">Alumnos</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-box-seam"></i> Inventario de Libros</h2>
            <a href="index.php" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-house-door"></i> Volver al Inicio
            </a>
        </div>
        
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Registrar Nuevo Libro</h5>
            </div>
            <div class="card-body bg-white">
                <form action="../acciones/guardar_libro.php" method="POST" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Título del Libro</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Don Quijote" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Autor</label>
                        <input type="text" name="autor" class="form-control" placeholder="Nombre del autor" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Cantidad Inicial</label>
                        <input type="number" name="cantidad" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-success px-5 shadow-sm">
                            <i class="bi bi-save"></i> Guardar en Sistema
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-dark">Libros en Existencia</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th class="text-center">Total en Sistema</th>
                            <th class="text-center">Disponibles ahora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM libros ORDER BY id DESC";
                        $resultado = mysqli_query($conexion, $query);
                        while($fila = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><strong><?php echo $fila['titulo']; ?></strong></td>
                                <td><?php echo $fila['autor']; ?></td>
                                <td class="text-center"><?php echo $fila['cantidad_total']; ?></td>
                                <td class="text-center">
                                    <span class="badge bg-primary rounded-pill px-3">
                                        <?php echo $fila['cantidad_disponible']; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>