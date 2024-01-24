<?php
require_once './Utils/validator.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi historial de compras</title>
    <!-- Agrega la hoja de estilos de Bootstrap (puedes cambiar la URL según tu configuración) -->
    <link rel="stylesheet" href="public/dash.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<nav>
    <div>
        <a href="?page=user-default&user_id=<?= $user_data['id']?>">Inicio</a>
        <a href="./?page=user-history&user_id=<?= $user_data['id']?>">Mi historial de compras</a>
    </div>
    
    <div>
        <span class="usuario-info">Usuario: <?= $user_data['email'] ?? '' ?></span>
        <a class="logout-btn" href="./Vista/logout.php">Logout</a>
    </div>
</nav>

<div class="container mt-5">
    <h3>Tabla de Datos</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php foreach ($data[0] as $clave => $valor) : ?>
                        <th><?= ucfirst($clave) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $fila) : ?>
                    <tr>
                        <?php foreach ($fila as $valor) : ?>
                            <td><?= $valor ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
