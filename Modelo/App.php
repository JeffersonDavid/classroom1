<?php

class App {

    private $databaseService;

    public function __construct( $databaseService ) {

        $this->databaseService = $databaseService;
    }

    public function users_all() : array {

        $sqlx = "SELECT * FROM usuarios";
        $db = $this->databaseService->connection->prepare($sqlx);
        // Ejecutar la consulta preparada
        $db->execute();
        // Obtener los resultados como un array asociativo
        $resultados = $db->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }

    public function createUser( $username , $email , $password, $role = 1 ) :int 
    {
        // Hash del password (asegúrate de usar un método seguro en un entorno de producción)
        $hashedPassword = base64_encode($password);
        // Crear una nueva instancia de PDOStatement para ejecutar la inserción
        $stmt = $this->databaseService->connection->prepare("INSERT INTO usuarios (name, email, password, role) VALUES (?, ?, ?, ?)");
        // Ejecutar la consulta preparada con los valores correspondientes
        $stmt->execute([$username, $email, $hashedPassword, $role]);
        $inserted_user = $this->databaseService->connection->lastInsertId();
        // Devolver el ID del nuevo usuario insertado
        return $inserted_user;
    }


      /**
     * @param string $email
     * @return array|bool
     */

    public function userByEmail ( string $email = '' ) : array {

        $stmt = $this->databaseService->connection->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $primerResultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($primerResultado !== false) {
            return $primerResultado;
        }

        return [];
        
    }


    public function deleteUserByID( int $id ) : void {
        $stmt = $this->databaseService->connection->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function userByID ( int $id ) : array {
        
        $stmt = $this->databaseService->connection->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $primerResultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($primerResultado !== false) {
            return $primerResultado;
        }

        throw new \RuntimeException("Usuario no encontrado con ID: $id");
        
    }

    public function productByID ( int $id ) : array {
        $stmt = $this->databaseService->connection->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $primerResultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($primerResultado !== false) {
            return $primerResultado;
        }
       
        throw new \RuntimeException("Usuario no encontrado con ID:  $id "); 
    }


    public function deleteProductByID( int $id ) : void {
        $stmt = $this->databaseService->connection->prepare("DELETE FROM productos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    


    public function getProducts() : array {

        $sqlx = "SELECT * FROM productos";
        $db = $this->databaseService->connection->prepare($sqlx);
        // Ejecutar la consulta preparada
        $db->execute();
        // Obtener los resultados como un array asociativo
        $resultados = $db->fetchAll(PDO::FETCH_ASSOC);

        return  $resultados;
    }

    public function updateProduct( array $params ){

        $id = $params['id'] ?? '';
        $nombre = $params['nombre'] ?? '';
        $precio = $params['precio'] ?? '';
        $descripcion = $params['descripcion'] ?? '';

        $sql = "UPDATE productos SET nombre = :nombre, precio = :precio, descripcion = :descripcion WHERE id = :id";
        $stmt =  $this->databaseService->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);

        // Ejecutar la consulta y verificar el éxito
        $success = $stmt->execute();

        if ($success) {
           
        } else {

            echo "Error al realizar el UPDATE.";
            die();
        }
    }



    public function updateUser( array $params ){

    
        $id = $params['user_id'] ?? '';
        $nombre = $params['name'] ?? '';
        $email = $params['email'] ?? '';
        $password = $params['password'] ?? '';
        $role = $params['role'] ?? '';

        $sql = "UPDATE usuarios SET name = :name, role = :role, email = :email, password = :password WHERE id = :id";
        $stmt = $this->databaseService->connection->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', base64_encode($password), PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);

        $success = $stmt->execute();

        if ($success) {
            $rowCount = $stmt->rowCount();
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Error al realizar el UPDATE. Detalles del error: " . $errorInfo[2];
            die('2');
        }

    }

    public function createProduct(array $params){

        
        $sql = "INSERT INTO productos (nombre, precio, descripcion) VALUES (:nombre, :precio, :descripcion)";
        $stmt =  $this->databaseService->connection->prepare($sql);
        $stmt->bindParam(':nombre', $params['nombre']);
        $stmt->bindValue(':precio', $params['precio'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $params['descripcion']);
        if ($stmt->execute()) {
          
        } else {
            echo 'Error al insertar el producto.';
            die();
        }
    }

    public function insertUserBuyTransaction( array $datos ){

        $cantidad = $datos['pr_quantity'];
        $total = $datos['pr_total'];
        $idProducto = $datos['pr_id'];
        $user_id = $datos['user_id'];

        $sql = "INSERT INTO historial_compras (usuario_id, producto_id, cantidad, precio_total, fecha_compra) VALUES (:usuario_id, :producto_id, :cantidad, :precio_total, :fecha_compra)";

        // Preparar la sentencia SQL
        $stmt = $this->databaseService->connection->prepare($sql);

        // Vincular los valores a los marcadores de posición
        $stmt->bindParam(':usuario_id', $user_id); // Asumo que $user_id es una variable definida
        $stmt->bindValue(':producto_id', $idProducto); // Cambié a bindValue para aceptar una expresión
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':precio_total', $total); 
        $stmt->bindParam(':fecha_compra', date('Y-m-d H:i:s'));

        // Ejecutar la sentencia SQL
        $stmt->execute();


    }

    public function productsByUser(int $user_id) {
        $stmt = $this->databaseService->connection->prepare("SELECT * FROM historial_compras WHERE usuario_id = :usuario_id");
        $stmt->bindParam(':usuario_id', $user_id);
        $stmt->execute();
    
        // Obtener todos los resultados en forma de arreglo asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }
    

}
 

      
    

