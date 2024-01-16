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

    <div id="overlay" class="overlay"></div>

    <h1>Productos en stock</h1>

    <ul>
        <?php foreach ($productos as $producto): ?>
            <?php
            $id = "prid_".$producto['id'];
            $idt = "tprid_".$producto['id'];
            $precio = (int) $producto['precio'];
            ?>

            <div id=<?= $id ?> class="popup" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000; max-width: 400px; text-align: center;">
                <div id="alert_msg_<?= $idt ?>" class="alerta">¡Alerta! Este es un mensaje de alerta con fondo rojo.</div>
                <p>Producto: <b><?= $producto['nombre'] ?></b></p>
                <p>Precio: <b> $ <?= number_format($precio, 2) ?> </b></p>
                <p>Por favor, introduzca la cantidad:</p>
                <label for="cantidad">Cantidad:</label>
                <input type="number"
                       min="0"
                       value="0"
                       id="cantidad_<?= $idt ?>"
                       dataprice="<?= $precio ?>"
                       placeholder="Cantidad"
                       style="width: 100%; margin-bottom: 10px; padding: 5px;"
                       onchange="calculateTotal('<?= $idt ?>', <?= $producto['id'] ?>)">
                <label for="total">Total:</label>
                <input type="text" id="<?= $idt ?>" value="0 €" placeholder="Total" readonly style="width: 100%; margin-bottom: 10px; padding: 5px;">
                <label for="numeroTarjeta">Número de Tarjeta:</label>
                <input type="text" id="numeroTarjeta_<?= $idt ?>" placeholder="Número de Tarjeta" style="width: 100%; margin-bottom: 10px; padding: 5px;">
                <button style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-right: 5px;">Procesar pago</button>
                <button onclick="cerrarPopup('<?= $id ?>')" style="background-color: #f44336; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Cancelar</button>
            </div>

            <li>
                <div class="product-name"><?= $producto['nombre'] ?></div>
                <div class="product-price">Precio: $ <?= number_format($precio, 2) ?></div>
                <div class="product-description"><?= $producto['descripcion'] ?></div>
                <div class="product-buy-container">
                    <div class="product-description" style="text-align: right;" data_id="<?= $producto['id'] ?>">
                        <button class="button" onclick="mostrarPopup('<?= $id ?>')">Comprar</button>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        function mostrarPopup(id_product) {

            document.getElementById(id_product).style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function cerrarPopup(id_product) {
            document.getElementById(id_product).style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function calculateTotal(idInput, id_product) {
            
            let event = document.getElementById('cantidad_' + idInput);
            let cant = parseInt(event.value);
            let price = parseInt(event.getAttribute('dataprice'));
            let total = cant * price;
            document.getElementById(idInput).value = `${total} €`;

            let cartObj = {
                pr_quantity: cant,
                pr_prince: price,
                pr_total: total,
                pr_id: id_product
            }

            localStorage.setItem('cart', JSON.stringify(cartObj));
        }
    </script>
</body>
</html>
