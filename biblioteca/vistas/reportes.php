<?php 
include '../config/conexion.php'; 

// Consulta SQL para el ranking de los 5 libros más prestados
$sql_ranking = "SELECT l.titulo, COUNT(p.id) as total_prestamos 
                FROM prestamos p
                JOIN libros l ON p.id_libro = l.id
                GROUP BY l.id
                ORDER BY total_prestamos DESC
                LIMIT 5";

$ranking = mysqli_query($conexion, $sql_ranking);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes - Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container"><a class="navbar-brand" href="index.php">⬅ Volver al Panel</a></div>
    </nav>

    <div class="container">
        <h2 class="mb-4">📊 Análisis de la Biblioteca</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Libros Favoritos (Top 5)</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php 
                            $posicion = 1;
                            while($row = mysqli_fetch_assoc($ranking)): 
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $posicion . ". " . $row['titulo']; ?>
                                    <span class="badge bg-primary rounded-pill">
                                        <?php echo $row['total_prestamos']; ?> lecturas
                                    </span>
                                </li>
                            <?php 
                            $posicion++;
                            endwhile; 
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow border-0 p-4 bg-white">
                    <h5>Resumen General</h5>
                    <hr>
                    <?php
                    // Consultas rápidas para el resumen
                    $t_libros = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM libros"))['total'];
                    $t_prestamos = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM prestamos"))['total'];
                    ?>
                    <p>Total de libros en sistema: <strong><?php echo $t_libros; ?></strong></p>
                    <p>Total de préstamos realizados: <strong><?php echo $t_prestamos; ?></strong></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>