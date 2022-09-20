<?php
  class Db {
    private static $instance = NULL;

    private function __construct() {}

    public static function connect() {
        $pdo = new PDO('mysql:host=localhost;dbname=prueba_tecnica_dev;charset=utf8', 'root', '');
        //Filtrando posibles errores de conexión.
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
  }
?>