<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Alumnos - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-book"></i> Biblioteca Marta</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Inicio</a>
                <a class="nav-link" href="inventario.php">Inventario</a>
                <a class="nav-link" href="prestar.php">Nuevo Préstamo</a>
                <a class="nav-link" href="historial.php">Ver Préstamos</a>
                <a class="nav-link active" href="alumnos.php">Alumnos</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-person-plus"></i> Registrar Alumno</h5>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'ok'): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill"></i> ¡Alumno registrado con éxito!
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="../acciones/guardar_alumno.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre" class="form-control" placeholder="Ej: Juan Pérez" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Grado y Salón</label>
                                <input type="text" name="grado" class="form-control" placeholder="Ej: 5to B" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="bi bi-save"></i> Guardar Estudiante
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-dark"><i class="bi bi-people"></i> Lista de Alumnos</h5>
                            <span class="badge bg-secondary">Registrados: 
                                <?php 
                                $count = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM alumnos"));
                                echo $count['total']; 
                                ?>
                            </span>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" id="filtroAlumnos" class="form-control border-start-0 ps-0" placeholder="Escribe un nombre para buscar...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tablaAlumnos">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Grado / Salón</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM alumnos ORDER BY id DESC";
                                $res = mysqli_query($conexion, $sql);
                                while($alumno = mysqli_fetch_assoc($res)): ?>
                                <tr>
                                    <td><strong><?php echo $alumno['nombre']; ?></strong></td>
                                    <td><span class="badge bg-info text-dark"><?php echo $alumno['grado_salon']; ?></span></td>
                                    <td class="text-center">
                                        <span class="text-success"><i class="bi bi-check-circle-fill"></i> Activo</span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('filtroAlumnos').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        let filas = document.querySelectorAll('#tablaAlumnos tbody tr');
        
        filas.forEach(fila => {
            let nombre = fila.querySelector('td').textContent.toLowerCase();
            if (nombre.includes(filtro)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>