<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
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
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            color: #4caf50;
            text-decoration: none;
        }
    </style>
    </head>
    <body>
        <div>
          
        <?php echo isset($errmessage) ? '<div style="padding:10px"><span style="background:red;color:white">'.$errmessage.'</span></div>' : ''; ?>
        <?php echo isset($message) ? '<div style="padding:10px"><span style="background:green;color:white">'.$message.'</span></div>' : ''; ?>

        <form action="index.php?page=create/user" method="post">
        <fieldset>
            <legend>Formulario de Registro</legend>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" placeholder="Escriba aquí su nombre" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Escriba aquí su email" required>

            <label for="pass1">Contraseña:</label>
            <input type="password" id="pass1" name="password" placeholder="Escriba aquí su contraseña" required>

            <input type="submit" name="Registrarse" value="Registrarse">

            <a href="index.php">Menú inicio</a>
        </fieldset>
    </form>
            </div> 
    </body>
</html>