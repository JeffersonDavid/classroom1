<?php

require './Utils/validator.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios</title>
    <link rel="stylesheet" href="./public/popup.css">
    <link rel="stylesheet" href="./public/users_crud.css">
    <style></style>
</head>
<body>

<nav>
    <div>
        <a href="?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de usuarios</a>
        <a href="?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de productos</a>
    </div>
    <div>
        <span class="usuario-info">Usuario: <?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : '' ?> </span>
        <a class="logout-btn" href="./Vista/logout.php">Logout</a>
    </div>
</nav>

<div style="margin: 4%">
    <a href="?page=admin" class="volver-atras">&larr; Volver </a>
</div>

<?php if (isset($message)): ?>
    <div class="popup" id="myPopup">
        <p class="alert-message"><?php echo htmlspecialchars($message); ?></p>
    </div>
<?php endif; ?>

<form name="users_form" onsubmit="return validatePass('users_form')" action="?page=user-edit&user_id=<?= isset($user_data_['id']) ? $user_data_['id'] : 'undefined'; ?>" method="post" style="margin-top:5%">
    <h2>Editar Usuario</h2>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user_data_['id']); ?>">

    <label for="name">Nombre:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user_data_['name']); ?>">

    <label for="email">Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($user_data_['email']); ?>">

    <label for="password">Password:</label>
    <input type="password" name="password" value="<?php echo htmlspecialchars($user_data_['password']); ?>">

    <div style="margin:10px">
        <label for="role">Selecciona una opción:</label>
        <select id="role" name="role">
            <?php
            $opciones = [2 => 'Administrador', 1 => 'Cliente'];

            foreach ($opciones as $i => $opcion) {
                $selected = ($i === (int) $user_data_['role']) ? 'selected' : '';
                echo "<option value='$i' $selected > $opcion </option>";
            }
            ?>
        </select>
    </div>

    <input type="submit" value="Guardar Cambios">
</form>

<script src="./public/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
