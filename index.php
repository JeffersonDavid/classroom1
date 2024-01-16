<?php

require_once  './Controlador/AppController.php';
require_once  './Modelo/App.php';
require_once  './Conexion.php';


$conn = new DatabaseService();
$app_model = new App( $conn );

$model = new AppController( $app_model );
$model->handleRequest();