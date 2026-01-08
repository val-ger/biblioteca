<?php 
include '../config/conexion.php'; 

// 1. Consultas para las tarjetas de estadísticas (Resumen rápido para Marta)
$total_libros = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT SUM(cantidad_total) as total FROM libros"))['total'] ?? 0;
$total_alumnos = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM alumnos"))['total'] ?? 0;
$prestamos_activos = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM prestamos WHERE estado = 'pendiente'"))['total'] ?? 0;

// 2. Lógica de búsqueda corregida
$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $query = "SELECT * FROM libros WHERE titulo LIKE '%$busqueda%' OR autor LIKE '%$busqueda%'";
} else {
    $query = "SELECT * FROM libros ORDER BY id DESC LIMIT 10"; 
}
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Biblioteca - Sra. Marta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="bi bi-book"></i> Biblioteca Marta</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link active" href="index.php">Inicio</a>
                    <a class="nav-link" href="inventario.php">Inventario</a>
                    <a class="nav-link" href="prestar.php">Nuevo Préstamo</a>
                    <a class="nav-link" href="historial.php">Ver Préstamos</a>
                    <a class="nav-link" href="alumnos.php">Alumnos</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1>Hola, Sra. Marta 👋</h1>
                <p class="text-muted">Gestione sus libros y alumnos de forma eficiente.</p>
            </div>
            <div class="col-md-4 text-end">
                <form action="index.php" method="GET" class="d-flex">
                    <input type="text" name="buscar" class="form-control me-2 shadow-sm" placeholder="Buscar libro..." value="<?php echo $busqueda; ?>">
                    <button type="submit" class="btn btn-primary shadow-sm">Buscar</button>
                </form>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-white shadow-sm border-0 border-start border-primary border-4">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Total Libros</h6>
                        <h2 class="mb-0"><?php echo $total_libros; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white shadow-sm border-0 border-start border-success border-4">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Alumnos Registrados</h6>
                        <h2 class="mb-0"><?php echo $total_alumnos; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white shadow-sm border-0 border-start border-warning border-4">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small font-weight-bold">Préstamos Pendientes</h6>
                        <h2 class="mb-0 text-warning"><?php echo $prestamos_activos; ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="bi bi-list-check"></i> Disponibilidad en Estantes</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Stock Disponible</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($libro = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><strong><?php echo $f['titulo'] ?? $libro['titulo']; ?></strong></td>
                            <td><?php echo $libro['autor']; ?></td>
                            <td class="text-center">
                                <?php if($libro['cantidad_disponible'] > 0): ?>
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success">Disponible</span>
                                <?php else: ?>
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger">Agotado</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold"><?php echo $libro['cantidad_disponible']; ?></span> <span class="text-muted">/ <?php echo $libro['cantidad_total']; ?></span>
                            </td>
                            <td class="text-center">
                                <a href="prestar.php?id=<?php echo $libro['id']; ?>" class="btn btn-sm btn-dark <?php echo ($libro['cantidad_disponible'] <= 0) ? 'disabled' : ''; ?>">
                                    <i class="bi bi-arrow-right-short"></i> Prestar
                                </a>
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