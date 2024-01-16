<?php
require_once './Utils/validator.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="public/dash.css">
</head>
<body>
    <nav>
        <div>
            <a href="#">Inicio</a>
            <a href="./?user-history">Mi historial de compras</a>
        </div>
        
        <div>
            <span class="usuario-info">Usuario: <?= $user_data['email'] ?? '' ?></span>
            <a class="logout-btn" href="./Vista/logout.php">Logout</a>
        </div>
    </nav>

    <h1>Productos en stock</h1>

    <ul>
        <?php foreach ($productos as $producto): ?>
            <li>
                <div class="product-name"><?= $producto['nombre'] ?></div>
                <div class="product-price">Precio: $<?= number_format($producto['precio'], 2) ?></div>
                <div class="product-description"><?= $producto['descripcion'] ?></div>
                <div class="product-buy-container">
                <div class="product-description" style="text-align: right;"><button class='button'>Comprar</button> </div></div>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
