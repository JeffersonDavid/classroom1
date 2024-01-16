<?php require './Utils/validator.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador</title>
    <link rel="stylesheet" href="./public/style.css">
</head>
<body>

<nav>
    <div>
        <a href="?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de usuarios</a>
        <a href="?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de productos</a>
    </div>

    <div>
        <span class="usuario-info">Usuario: <?= $user_data['email'] ?? '' ?></span>
        <a class="logout-btn" href="./Vista/logout.php">Logout</a>
    </div>
</nav>

<div style="padding: 10px; width:90%">
    <h3 style="margin-top:7%">GESTION DE PRODUCTOS</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $product): ?>
                <tr>
                    <td><?= $product['nombre'] ?></td>
                    <td><?= $product['precio'] ?></td>
                    <td><?= $product['descripcion'] ?></td>
                    <td>
                        <a class="button" href="./?page=show-edit-product&product_id=<?= $product['id'] ?>">Editar producto</a>
                        <a class='buttonred' href='./index.php?page=product-delete&product_id=<?= $product['id'] ?>'> Borrar </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
