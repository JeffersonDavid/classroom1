<?php

require_once  '../Conexion.php';
require_once  '../Modelo/App.php';

class Logger {
    private $logFile;
    public function __construct($logFile) {
        $this->logFile = $logFile;
    }
    public function logInfo($message) {
        $logEntry = "[" . date('Y-m-d H:i:s') . "] [INFO] " . $message . PHP_EOL;
        $this->writeToLog($logEntry);
    }
    private function writeToLog($logEntry) {
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
}


class ApiController {

    private $logger;
    private $databaseService;

    public function __construct(Logger $logger, DatabaseService $databaseService) {
        $this->logger = $logger;
        $this->databaseService = $databaseService;
    }

    public function procesarCarrito() {
        $this->logger->logInfo('Inicia petición');

        // Obtener datos desde POST o GET según sea necesario
        $datos = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;

        $this->logger->logInfo('Datos recibidos: ' . json_encode($datos));

        // Verificar si se recibieron los parámetros esperados
        $parametrosEsperados = ['pr_quantity', 'pr_price', 'pr_total', 'pr_id'];

        foreach ($parametrosEsperados as $parametro) {
            if (!isset($datos[$parametro])) {
                // Parámetro faltante, construir la respuesta de error
                $this->responderError('Falta el parámetro obligatorio: ' . $parametro, $datos);
                return;
            }
        }

        // Obtener los valores de los parámetros
        $cantidad = $datos['pr_quantity'];
        $precio = $datos['pr_price'];
        $total = $datos['pr_total'];
        $idProducto = $datos['pr_id'];

        try {
            $conn = $conn = new DatabaseService();
            $app_model = new App($conn);
            $app_model->insertUserBuyTransaction($datos);
        } catch (\Throwable $th) {
            $this->responderError($th->getMessage(), $datos);
            return;
        }

        $this->logger->logInfo('************** insert realizado ********** ');

        // Construir el array con la respuesta
        $respuesta = [
            'success' => true,
            'mensaje' => 'Parámetros recibidos correctamente',
            'datos' => [
                'pr_quantity' => $cantidad,
                'pr_price' => $precio,
                'pr_total' => $total,
                'pr_id' => $idProducto
            ],
            'log' => $datos
        ];

        $this->responderJson($respuesta);
    }

    private function responderJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        $this->logger->logInfo('Respuesta enviada: ' . json_encode($data));
    }

    private function responderError($mensaje, $datos) {
        $respuesta = [
            'success' => false,
            'mensaje' => $mensaje,
            'data' => $datos
        ];
        $this->responderJson($respuesta);
    }
}

// Uso del logger y DatabaseService
$logger = new Logger('log.txt');
$databaseService = new DatabaseService();
// Crear una instancia del controlador con el logger y DatabaseService
$apiController = new ApiController($logger, $databaseService);
// Llamar al método para procesar el carrito
$apiController->procesarCarrito();

