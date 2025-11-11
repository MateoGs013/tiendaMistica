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

    public static function all(): array {
        try {
            $cn = DB::get();
            $sql = "SELECT id_usuario, nombre, apellido, email, rol, fecha_alta, activo FROM usuarios ORDER BY fecha_alta DESC";
            return $cn->query($sql)->fetchAll();
        } catch (PDOException $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return [];
        }
    }

    public static function find(int $id): ?array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT * FROM usuarios WHERE id_usuario = ? LIMIT 1");
            $st->execute([$id]);
            $row = $st->fetch();
            return $row ?: null;
        } catch (PDOException $e) {
            error_log("Error al buscar usuario ID $id: " . $e->getMessage());
            return null;
        }
    }

    public static function emailExists(string $email, ?int $exceptId = null): bool {
        try {
            $cn = DB::get();
            if ($exceptId) {
                $st = $cn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ? AND id_usuario <> ?");
                $st->execute([$email, $exceptId]);
            } else {
                $st = $cn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
                $st->execute([$email]);
            }
            return (int)$st->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error al verificar email de usuario: " . $e->getMessage());
            return true;
        }
    }

    public static function create(): bool {
        $argsCount = func_num_args();
        $nombre = $argsCount > 0 ? (string)func_get_arg(0) : '';
        $email = $argsCount > 1 ? (string)func_get_arg(1) : '';
        $password = $argsCount > 2 ? (string)func_get_arg(2) : '';
        $rol = $argsCount > 3 ? (string)func_get_arg(3) : 'usuario';

        $payload = [
            'nombre' => $nombre,
            'apellido' => null,
            'email' => $email,
            'password' => $password,
            'rol' => $rol,
            'activo' => 1,
        ];
        return self::createAdmin($payload);
    }

    public static function createAdmin(array $data): bool {
        try {
            $nombre = trim($data['nombre'] ?? '');
            $apellido = trim($data['apellido'] ?? '');
            $email = trim($data['email'] ?? '');
            $password = $data['password'] ?? '';
            $rol = $data['rol'] ?? 'usuario';
            $activo = isset($data['activo']) ? (int)(bool)$data['activo'] : 1;

            if ($nombre === '' || $email === '' || $password === '') {
                return false;
            }

            if (self::emailExists($email)) {
                return false;
            }

            $cn = DB::get();
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $st = $cn->prepare("INSERT INTO usuarios (nombre, apellido, email, password_hash, rol, activo) VALUES (?, ?, ?, ?, ?, ?)");
            return $st->execute([$nombre, $apellido !== '' ? $apellido : null, $email, $hash, $rol, $activo]);
        } catch (PDOException $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    public static function updateAdmin(): bool {
        try {
            $argsCount = func_num_args();
            $userIdLocal = (int)($argsCount > 0 ? func_get_arg(0) : 0);
            $data = $argsCount > 1 && is_array(func_get_arg(1)) ? func_get_arg(1) : [];
            $nombre = trim($data['nombre'] ?? '');
            $apellido = trim($data['apellido'] ?? '');
            $email = trim($data['email'] ?? '');
            $rol = $data['rol'] ?? 'usuario';
            $activo = isset($data['activo']) ? (int)(bool)$data['activo'] : 0;
            $password = $data['password'] ?? '';

            if ($userIdLocal <= 0 || $nombre === '' || $email === '') {
                return false;
            }

            if (self::emailExists($email, $userIdLocal)) {
                return false;
            }

            $cn = DB::get();
            $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, email = :email, rol = :rol, activo = :activo";
            $params = [
                ':nombre' => $nombre,
                ':apellido' => $apellido !== '' ? $apellido : null,
                ':email' => $email,
                ':rol' => $rol,
                ':activo' => $activo,
                ':id' => $userIdLocal,
            ];

            if ($password !== '') {
                $sql .= ", password_hash = :password";
                $params[':password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            $sql .= " WHERE id_usuario = :id";

            $st = $cn->prepare($sql);
            return $st->execute($params);
        } catch (PDOException $e) {
            error_log("Error al actualizar usuario ID $userIdLocal: " . $e->getMessage());
            return false;
        }
    }

    public static function setActivo(): bool {
        try {
            $argsCount = func_num_args();
            $userIdLocal = (int)($argsCount > 0 ? func_get_arg(0) : 0);
            $activo = $argsCount > 1 ? (bool)func_get_arg(1) : false;
            $cn = DB::get();
            $st = $cn->prepare("UPDATE usuarios SET activo = ? WHERE id_usuario = ?");
            return $st->execute([(int)$activo, $userIdLocal]);
        } catch (PDOException $e) {
            error_log("Error al cambiar estado del usuario ID $userIdLocal: " . $e->getMessage());
            return false;
        }
    }
}
// phpcs:enable
