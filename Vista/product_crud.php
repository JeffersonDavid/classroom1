<?php
require './Utils/validator.php';
$producto = $product_data;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>

    <!-- Agrega estilos CSS aquí -->
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .volver-atras {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #45a049;
            color: #fff;
            border-radius: 5px;
            display: inline-block;
        }

        .volver-atras:hover {
            background-color: #45a049;
        }


        nav {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 99%;
            z-index: 1000;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
            transition: text-decoration 0.3s ease;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .alert-container {
            position: fixed;
            top: 70px;
            right: 10px;
            background-color: #f2f2f2;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: <?php echo isset($data_view['message']) ? 'block' : 'none'; ?>;
        }

        .alert-message {
            margin: 0;
            color: #333;
        }
    </style>
</head>
<body>
 
<nav>
        <div>
        <a href="?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de Usuarios</a>
        <a href="?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de Posts</a>
        </div>
        <div>
            <span class="usuario-info">Usuario: <?php echo isset($user_data['email']) ? $user_data['email'] : '' ?> </span>
            
            <a class="logout-btn" href="./../index.php"> Logout </a>
        </div>
</nav>


<div style="margin: 4%">
    <a href="Vista/adminProducts.php" class="volver-atras">&larr; Volver a productos </a>
</div>


<div class="alert-container">
    <p class="alert-message"><?php echo isset($data_view['message']) ? $data_view['message'] : ''; ?></p>
</div>


<form action="?page=edit-product&product_id=<?php echo isset($producto['id']) ? $producto['id'] : 'undefined'; ?>" method="post" style="margin-top:5%">

      
        <h2>Editar Producto</h2>
            <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

            <label for="nombre">Nombre del producto:</label>
            <input type="text" name="product_name" value="<?php echo $producto['nombre']; ?>">

            <label for="precio">Precio:</label>
            <input type="text" name="product_price" value="<?php echo $producto['precio']; ?>">

            <label for="descripcion">Descripción:</label>
            <textarea name="product_desc"><?php echo $producto['descripcion']; ?></textarea>

            <!-- Puedes agregar más campos según tus necesidades -->

            <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
