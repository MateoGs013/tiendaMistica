<?php
// classes/Contacto.php
require_once __DIR__ . '/DB.php';

class Contacto {
    public static function crear(string $nombre, string $email, string $mensaje): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)");
            return $st->execute([$nombre, $email, $mensaje]); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al crear contacto: " . $e->getMessage());
            return false;
        }
    }

    public static function todos(): array {
        try {
            $cn = DB::get();
            return $cn->query("SELECT * FROM contactos ORDER BY fecha_envio DESC")->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener todos los contactos: " . $e->getMessage());
            return [];
        }
    }

    public static function find(int $id): ?array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT * FROM contactos WHERE id_contacto = ?");
            $st->execute([$id]); // @phpstan-ignore-line
            $row = $st->fetch();
            return $row ?: null;
        } catch (Exception $e) {
            error_log("Error al buscar contacto ID $id: " . $e->getMessage());
            return null;
        }
    }

    public static function delete(int $id): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("DELETE FROM contactos WHERE id_contacto = ?");
            return $st->execute([$id]); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al eliminar contacto ID $id: " . $e->getMessage());
            return false;
        }
    }
}
