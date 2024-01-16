<!-- add.php -->

<?php
 require_once './Vista/Components/ModelAdd.php'; 
 require_once './Utils/validator.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add</title>
    <link rel="stylesheet" href="./public/nav.css">
    <link rel="stylesheet" href="./public/forms.css">
    <link rel="stylesheet" href="./public/popup.css">
</head>
<body>


    <nav>
            <div>
            <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de usuarios</a>
            <a href="./?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de productos</a>
            </div>
            <div>
                <span class="usuario-info"> Usuario: <?php echo isset($user_data['email']) ? $user_data['email'] : '' ?> </span>
                
                <a class="logout-btn" href="./Vista/logout.php">Logout</a>
            </div>
    </nav>

    <div style="margin:6%">
        <a href="?page=admin" class="button">&larr; Volver </a>
    </div>

    <?php if (isset($message)): ?>
    <div class="popup" id="myPopup">
        <p class="alert-message"><?php echo htmlspecialchars($message); ?></p>
    </div>
    <?php endif; ?>

    <div>
        <?php   ( new ModelAdd( $type ) )->render(); ?>
    </div>

    
    <script src="./public/js/app.js"></script>
</body>
</html>
