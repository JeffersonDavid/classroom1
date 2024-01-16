<?php

class DatabaseService
{
    private $host;
    private $user;
    private $password;
    private $db;
    private $dsn;

    public $connection;

    public function __construct()
    {
        $this->host = '127.0.0.1';
        $this->user = 'root';
        $this->password = 'root';
        $this->db = 'proyecto_final';
        $this->dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";

        try {

            $this->connection = new PDO($this->dsn, $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $ex) {

            die("Error en la conexión: mensaje: " . $ex->getMessage());
        }
    }
}











