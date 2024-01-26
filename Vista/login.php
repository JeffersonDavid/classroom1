<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Online</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #989898;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        div {
            width: 30%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        legend {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            text-align: right;
            margin-top: 10px;
            text-decoration: none;
            color: #3498db;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            padding: 10px;
            background: #ff5c5c;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .success-message {
            padding: 10px;
            background: #5cb85c;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>



<div>
    <?php echo isset($errmessage) ? '<div class="error-message">'.$errmessage.'</div>' : ''; ?>
    <?php echo isset($message) ? '<div class="success-message">'.$message.'</div>' : ''; ?>

    <form action="index.php?page=authenticate" method="post">
        <fieldset>
            <legend>Acceso online</legend>
            <label for="email">Nombre:</label>
            <input type="text" id="email" name="email" placeholder="Escriba aquí su nombre" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" placeholder="Escriba aquí su contraseña" required>

            <input  style='font-size:20px' type="submit" id="acceso" name="acceso" value="Acceder">
            <a href="index.php?page=register">Registrarse</a>
        </fieldset>
    </form>

</div>

</body>
</html>
