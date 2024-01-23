<?php
require_once './Utils/validator.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="public/dash.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
</head>
<body>
    <nav>
        <div>
            <a href="#">Inicio</a>
            <a href="./?page=user-history&user_id=<?= $user_data['id']?>" >Mi historial de compras</a>
        </div>
        
        <div>
            <span class="usuario-info">Usuario: <?= $user_data['email'] ?? '' ?></span>
            <a class="logout-btn" href="./Vista/logout.php">Logout</a>
        </div>
    </nav>

    <div id="overlay" class="overlay"></div>

    <h3 style="margin:10px;">Productos en stock</h3>

    <ul>
        <?php foreach ($productos as $producto): ?>
            <?php
            $id = "prid_".$producto['id'];
            $idt = "tprid_".$producto['id'];
            $precio = (int) $producto['precio'];
            ?>

            <div id=<?= $id ?> class="card border-custom popup" style="display:none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000; max-width: 400px; text-align: center;">
            <!--
                <div id="alert_msg_<?= $idt ?>" class="alerta">¡Alerta! Este es un mensaje de alerta con fondo rojo.</div>
            -->

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
                <button style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-right: 5px;" onclick="procesarPago('<?= $idt ?>')">Procesar pago</button>
                <button onclick="cerrarPopup('<?= $id ?>')" style="background-color: #f44336; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Volver</button>
            </div>

            <li class="list-group-item border p-2">
                <div class="product-name"><?= $producto['nombre'] ?></div>
                <div class="product-price">Precio: $ <?= number_format($precio, 2) ?></div>
                <div class="product-description"><?= $producto['descripcion'] ?></div>
                <div class="product-buy-container">
                    <div class="product-description" style="text-align: right;" data_id="<?= $producto['id'] ?>">
                        <button class="button btn btn-primary btn-lg" onclick="mostrarPopup('<?= $id ?>')">Comprar</button>
                    </div>
                </div>
            </li>

        <?php endforeach; ?>
    </ul>

    <script>

        window.addEventListener('beforeunload', function() { localStorage.clear(); });

        async function procesarPago(idInput) {

            let cantidad = document.getElementById('cantidad_' + idInput).value;
            let precio = document.getElementById('cantidad_' + idInput).getAttribute('dataprice');

            let credit_number = document.getElementById('numeroTarjeta_' + idInput ).value
            let total = cantidad * precio;

            var url = new URL(window.location.href);

            // Obtener el valor del parámetro user_id
            var userId = url.searchParams.get("user_id");

            let cartObj = {
                pr_quantity: cantidad,
                pr_price: precio,
                pr_total: total,
                pr_id: parseInt(idInput.match(/\d+$/)[0], 10),
                user_id : userId
            };

            if (credit_number === '' ||credit_number === null ||credit_number === ''){
                Swal.fire({
                    title: 'Error!',
                    text: 'Introduce un numero de credito válido',
                    icon: 'error',
                    confirmButtonText: 'Volver'
                })
                return
            }

            if( cartObj.pr_total === 0 ){
                 
                Swal.fire({title: 'Error!',text: 'La cantidad debe ser distinta a 0',icon: 'error',confirmButtonText: 'Cool'})

                return

            }else{

               

                  // Construir la URL con parámetros
                let url = `http://localhost/esteban/Controlador/ApiController.php?${new URLSearchParams(cartObj).toString()}`;
                // Realizar la solicitud GET
                let response = await fetch(url);
                // Parsear la respuesta JSON
                //let responseData = await response.json();
                console.log(response)

        


                let timerInterval;
                Swal.fire({
                title: "Realizando transaccion",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 1000);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
                }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Transaccion realizada correctamente",
                    showConfirmButton: false,
                    timer: 1500
                    });
                }
                });

              

            }
        }

        function mostrarPopup(id_product) {
            document.getElementById(id_product).style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function cerrarPopup(id_product) {
            document.getElementById(id_product).style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
            localStorage.removeItem('cart');
        }

        function calculateTotal(idInput, id_product) {

            let event = document.getElementById('cantidad_' + idInput);
            let cant = parseInt(event.value);
            let price = parseInt(event.getAttribute('dataprice'));
            let total = cant * price;
            document.getElementById(idInput).value = `${total} €`;

            let cartObj = {
                pr_quantity: cant,
                pr_price: price,
                pr_total: total,
                pr_id: id_product
            }

            localStorage.setItem('cart', JSON.stringify(cartObj));
        }

       

    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
