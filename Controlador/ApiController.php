<?php

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

    public function __construct(Logger $logger) {
        $this->logger = $logger;
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
                $respuesta = [
                    'success' => false,
                    'mensaje' => 'Falta el parámetro obligatorio: ' . $parametro,
                    'data' => $datos
                ];

                $this->responderJson($respuesta);
                return;
            }
        }

        // Obtener los valores de los parámetros
        $cantidad = $datos['pr_quantity'];
        $precio = $datos['pr_price'];
        $total = $datos['pr_total'];
        $idProducto = $datos['pr_id'];

        // Puedes realizar acciones adicionales con los parámetros, si es necesario
        // ...

        // Construir el array con la respuesta
        $respuesta = [
            'success' => true,
            'mensaje' => 'Parámetros recibidos correctamente',
            'datos' => [
                'pr_quantity' => $cantidad,
                'pr_price' => $precio,
                'pr_total' => $total,
                'pr_id' => $idProducto
            ]
        ];

        $this->responderJson($respuesta);
    }

    private function responderJson($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        $this->logger->logInfo('Respuesta enviada: ' . json_encode($data));
    }
}

// Uso del logger
$logger = new Logger('log.txt');
// Crear una instancia del controlador con el logger
$apiController = new ApiController($logger);
// Llamar al método para procesar el carrito
$apiController->procesarCarrito();
?>
