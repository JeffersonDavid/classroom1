
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-rlR5ePZ6p5vNcFp2jNII6JSwIq3l2pF5OKRAFJ3S82mN4G2yDtVzYzFa38k34+4PT5HsnVjIcSef4RflqWafQ==" crossorigin="anonymous" />

    
</head>
<body>



<div style='padding: 10px; width:90%'>

<nav id="navegacion">
        <div>
        <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de usuarios</a>
        <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de productos</a>
        </div>
        <div>
            <span class="usuario-info">Usuario: <?php echo isset($user_data['email']) ? $user_data['email'] : '' ?> </span>
            
            <a class="logout-btn" href="./Vista/logout.php">Logout</a>
        </div>
</nav>
<p style="visibility: hidden; position:absolute" aria-describedby="navegacion">Menu de navegacion con enlaces a gestion de productos & usuarios</p>




<div style="padding: 10px;">
<h3>GESTION DE USUARIOS</h3>
    <table role="main">
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

                    echo"<td> 

                            <a class='button' href='./index.php?page=show-user-edit&user_id=" . $user['id'] . "'><span> Editar<i class='fas fa-plus add-icon'> ✎ </i> </span> </a>
                            <a class='buttonred' href='./index.php?page=user-delete&user_id=" . $user['id'] . "'> <span> Borrar <i class='fas fa-plus add-icon'> ⨷ </i> </span> </a>
                            <a class='buttonblue' href='./index.php?page=show-add&model_type=users'> <span> Añadir  <i class='fas fa-plus add-icon'> ✚ </i>  </span> </a>


                         </td>";

                    echo "</tr>";
                    
                }
            ?>
        </tbody>
    </table>
</div>



</div>

</body>
</html>
