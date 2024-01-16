<?php

require '../Utils/validator.php';

class NavBarComponent
{
    private $mensaje;

    public $user_id ;

    public function __construct($mensaje)
    {
        $this->mensaje = $user_data['id'] ;

    }


    public function render()
    {
        ob_start(); // Iniciar el almacenamiento en búfer de salida

        // Aquí comienza el contenido del componente
        ?>
        
        <nav>
                <div>
                <a href="./../index.php?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>">Gestión de Usuarios</a>
                <a href="./../index.php?page=admin&user_id=<?= $user_data['id'] ?>&password=<?= $user_data['password'] ?>&adminPage=products">Gestión de Posts</a>
                </div>
                <div>
                    <span class="usuario-info">Usuario: <?php echo isset($user_data['email']) ? $user_data['email'] : '' ?> </span>
                    
                    <a class="logout-btn" href="./../index.php"> Logout </a>
                </div>
        </nav>
        <?php
        // Aquí termina el contenido del componente

        $contenido = ob_get_clean(); // Obtener y limpiar el contenido del búfer de salida
        return $contenido;
    }
}

$user_data['id'] ;
?>
