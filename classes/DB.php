<?php
// classes/DB.php
class DB {
    private static ?PDO $cn = null;

    public static function get(): PDO {
        if (self::$cn === null) {
            try {
                $host = 'localhost';
                $db   = 'tienda_mistica';
                $user = 'root';
                $pass = '';
                $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";
                self::$cn = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                die("Error al conectar con la base de datos. Por favor, intente más tarde.");
            }
        }
        return self::$cn;
    }
}
