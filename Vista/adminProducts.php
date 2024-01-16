<?php
require './Utils/validator.php';
?>

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
            <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de usuarios</a>
            <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de productos</a>
        </div>

        <div>
            <span class="usuario-info">Usuario: <?= isset($user_data['email']) ? $user_data['email'] : '' ?></span>
            <a class="logout-btn" href="./../index.php">Logout</a>
        </div>
    </nav>

    <div style="padding: 10px; width:90%">
    <h3 style="margin-top:10%">GESTION DE PRODUCTOS</h3>
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
            <?php
            // Supongamos que tienes un array de datos en PHP

            // Iterar sobre el array y mostrar los datos en la tabla
            foreach ( $productos as $index => $product ) {
                echo "<tr>";
                echo "<td>{$product['nombre']}</td>";
                echo "<td>{$product['precio']}</td>";
                echo "<td>{$product['descripcion']}</td>";
                echo"<td> <a class='button' href='./../index.php?page=show-edit-product&product_id=" . $product['id'] . "'> Editar producto </a> </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

</body>
</html>
