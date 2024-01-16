<?php

session_start();
// Comprueba si una variable de sesión específica está definida
if (isset($_SESSION['userlog'])) {
    //echo "La sesión está activa.";

    $user_data = isset($_SESSION['userlog']) ? $_SESSION['userlog'] : [] ;


} else {
    //echo "La sesión no está activa.";
    header('Location: ../index.php');
}



function formaRole( int  $role){
    switch ($role) {
        case 1:
            return 'Cliente';
        case 2:
            return 'Administrador';
        default:
            break;
    }
}

?>
