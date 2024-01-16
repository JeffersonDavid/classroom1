
<?php

require_once './Utils/validator.php'

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
            padding: 10px;
        }

        .product-name {
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .product-price {
            color: #4caf50;
        }

        .product-description {
            color: #777;
        }

        nav {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background-color: #d9534f;
            color: #fff;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 16px;
        }

        .usuario-info {
            font-size: 16px;    
            color: #fff;
        }
    </style>
</head>
<body>

    <nav>
        <div>
            <a href="#">Inicio</a>
            <a href="#">Mi historial de compras </a>
        </div>
        
        <div>
            <span class="usuario-info">Usuario: <?php echo isset($user_data['email']) ? $user_data['email'] : '' ?> </span>
            
            <a class="logout-btn" href="./Vista/logout.php"> Logout </a>
        </div>
    </nav>

    <h1> Productos en stock </h1>

    <?php


    
    // Mostrar listado de productos
    echo '<ul>';
    foreach ($productos as $producto) {
        echo '<li>';
        echo '<div class="product-name">' . $producto['nombre'] . '</div>';
        echo '<div class="product-price">Precio: $' . number_format($producto['precio'], 2) . '</div>';
        echo '<div class="product-description">' . $producto['descripcion'] . '</div>';
        echo '</li>';
    }
    echo '</ul>';
    ?>

</body>
</html>
