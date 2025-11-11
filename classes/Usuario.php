<?php
// classes/Usuario.php
require_once __DIR__ . '/DB.php';

// phpcs:disable
class Usuario {

    public static function findByEmail(string $email): ?array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT * FROM usuarios WHERE email = ? AND activo = 1 LIMIT 1");
            $st->execute([$email]); // @phpstan-ignore-line
            $row = $st->fetch();
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al buscar usuario: " . $e->getMessage());
            return null;
        }
    }

    public static function create(string $nombre, string $email, string $password, string $rol = 'usuario'): bool {
        try {
            // Verificar si el email ya existe
            if (self::findByEmail($email)) { // @phpstan-ignore-line
                return false;
            }
            
            $cn = DB::get();
            $hash = password_hash($password, PASSWORD_BCRYPT); // @phpstan-ignore-line
            $st = $cn->prepare("INSERT INTO usuarios (nombre, email, password_hash, rol, activo) VALUES (?, ?, ?, ?, 1)");
            return $st->execute([$nombre, $email, $hash, $rol]); // @phpstan-ignore-line
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }
}
// phpcs:enable
