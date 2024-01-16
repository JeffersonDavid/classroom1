
<?php
require './Utils/validator.php'
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Adminstrador</title>
    <link rel="stylesheet" href="./public/style.css">
    <link rel="stylesheet" href="./public/popup.css">
</head>
<body>



<div style='padding: 10px; width:90%'>

<nav>
        <div>
        <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de usuarios</a>
        <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de productos</a>
        </div>
        <div>
            <span class="usuario-info">Usuario: <?php echo isset($user_data['email']) ? $user_data['email'] : '' ?> </span>
            
            <a class="logout-btn" href="./Vista/logout.php">Logout</a>
        </div>
</nav>




<div style="padding: 10px;">
<h3>GESTION DE USUARIOS</h3>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Role</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
        
                // Iterar sobre el array y mostrar los datos en la tabla
                foreach ( $users as $index => $user ) {
                    echo "<tr>";
                    echo "<td>{$user['name']}</td>";
                    echo "<td>{$user['email']}</td>";
                    echo "<td> ". formaRole($user['role'])." </td>";
                    echo"<td> <a class='button' href='./index.php?page=show-user-edit&user_id=" . $user['id'] . "'> Editar usuario </a> </td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>



</div>

</body>
</html>
