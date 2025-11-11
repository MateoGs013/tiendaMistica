<?php
// classes/Carrito.php
require_once __DIR__ . '/DB.php';

class Carrito {

    public static function getCarritoActivoId(int $idUsuario): int {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT id_carrito FROM carritos WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
            $st->execute([$idUsuario]); // @phpstan-ignore-line
            $row = $st->fetch();
            if ($row) return (int)$row['id_carrito'];

            $st = $cn->prepare("INSERT INTO carritos (id_usuario, estado, creado_en, actualizado_en)
                                VALUES (?, 'activo', NOW(), NOW())");
            $st->execute([$idUsuario]); // @phpstan-ignore-line
            return (int)$cn->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al obtener/crear carrito activo: " . $e->getMessage());
            throw $e;
        }
    }

    public static function agregar(int $idUsuario, int $idDuende, int $cantidad = 1): bool {
        try {
            $cn = DB::get();
            $idCarrito = self::getCarritoActivoId($idUsuario);

            // Verificar que el duende existe y está disponible
            $st = $cn->prepare("SELECT precio_en_oro, nombre FROM duendes WHERE id_duende = ? AND disponible = 1");
            $st->execute([$idDuende]); // @phpstan-ignore-line
            $duende = $st->fetch();
            if (!$duende) return false;
            $precio = (float)$duende['precio_en_oro'];

            // Verificar si ya existe en el carrito
            $st = $cn->prepare("SELECT cantidad FROM carrito_items WHERE id_carrito = ? AND id_duende = ?");
            $st->execute([$idCarrito, $idDuende]); // @phpstan-ignore-line
            $item = $st->fetch();

            if ($item) {
                // Actualizar cantidad
                $nueva = (int)$item['cantidad'] + $cantidad;
                $up = $cn->prepare("UPDATE carrito_items SET cantidad = ? WHERE id_carrito = ? AND id_duende = ?");
                $up->execute([$nueva, $idCarrito, $idDuende]); // @phpstan-ignore-line
            } else {
                // Insertar nuevo item
                $ins = $cn->prepare("INSERT INTO carrito_items (id_carrito, id_duende, cantidad, precio_unitario)
                                     VALUES (?, ?, ?, ?)");
                $ins->execute([$idCarrito, $idDuende, $cantidad, $precio]); // @phpstan-ignore-line
            }
            
            // Actualizar timestamp del carrito
            $cn->prepare("UPDATE carritos SET actualizado_en = NOW() WHERE id_carrito = ?")
               ->execute([$idCarrito]); // @phpstan-ignore-line
            
            return true;
        } catch (Exception $e) {
            error_log("Error al agregar al carrito: " . $e->getMessage());
            return false;
        }
    }

    public static function items(int $idUsuario): array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT id_carrito FROM carritos WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
            $st->execute([$idUsuario]); // @phpstan-ignore-line
            $cart = $st->fetch();
            if (!$cart) return [];
            $idCarrito = (int)$cart['id_carrito'];

            $sql = "SELECT ci.id_carrito_item, ci.id_duende, d.nombre, d.imagen_url, ci.cantidad, ci.precio_unitario,
                           (ci.cantidad * ci.precio_unitario) AS subtotal
                    FROM carrito_items ci
                    JOIN duendes d ON d.id_duende = ci.id_duende
                    WHERE ci.id_carrito = ?";
            $st = $cn->prepare($sql);
            $st->execute([$idCarrito]); // @phpstan-ignore-line
            return $st->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener items del carrito: " . $e->getMessage());
            return [];
        }
    }

    public static function actualizarCantidad(int $idUsuario, int $idDuende, int $cantidad): bool {
        try {
            $cn = DB::get();
            $idCarrito = self::getCarritoActivoId($idUsuario);

            if ($cantidad <= 0) {
                // Si la cantidad es 0 o negativa, eliminar el item
                return self::eliminarItem($idUsuario, $idDuende);
            }

            $st = $cn->prepare("UPDATE carrito_items SET cantidad = ? WHERE id_carrito = ? AND id_duende = ?");
            $result = $st->execute([$cantidad, $idCarrito, $idDuende]); // @phpstan-ignore-line
            
            // Actualizar timestamp
            $cn->prepare("UPDATE carritos SET actualizado_en = NOW() WHERE id_carrito = ?")
               ->execute([$idCarrito]); // @phpstan-ignore-line
            
            return $result;
        } catch (Exception $e) {
            error_log("Error al actualizar cantidad: " . $e->getMessage());
            return false;
        }
    }

    public static function eliminarItem(int $idUsuario, int $idDuende): bool {
        try {
            $cn = DB::get();
            $idCarrito = self::getCarritoActivoId($idUsuario);

            $st = $cn->prepare("DELETE FROM carrito_items WHERE id_carrito = ? AND id_duende = ?");
            $result = $st->execute([$idCarrito, $idDuende]); // @phpstan-ignore-line
            
            // Actualizar timestamp
            $cn->prepare("UPDATE carritos SET actualizado_en = NOW() WHERE id_carrito = ?")
               ->execute([$idCarrito]); // @phpstan-ignore-line
            
            return $result;
        } catch (Exception $e) {
            error_log("Error al eliminar item: " . $e->getMessage());
            return false;
        }
    }

    public static function vaciar(int $idUsuario): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT id_carrito FROM carritos WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
            $st->execute([$idUsuario]); // @phpstan-ignore-line
            $cart = $st->fetch();
            if (!$cart) return false;
            $idCarrito = (int)$cart['id_carrito'];

            $st = $cn->prepare("DELETE FROM carrito_items WHERE id_carrito = ?");
            return $st->execute([$idCarrito]); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al vaciar carrito: " . $e->getMessage());
            return false;
        }
    }

    public static function cantidadTotal(int $idUsuario): int {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT id_carrito FROM carritos WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
            $st->execute([$idUsuario]); // @phpstan-ignore-line
            $cart = $st->fetch();
            if (!$cart) return 0;

            $st = $cn->prepare("SELECT SUM(cantidad) as total FROM carrito_items WHERE id_carrito = ?");
            $st->execute([(int)$cart['id_carrito']]); // @phpstan-ignore-line
            $result = $st->fetch();
            return (int)($result['total'] ?? 0);
        } catch (Exception $e) {
            error_log("Error al obtener cantidad total del carrito: " . $e->getMessage());
            return 0;
        }
    }

    public static function calcularTotal(int $idUsuario): float {
        try {
            $items = self::items($idUsuario);
            $total = 0;
            foreach ($items as $item) {
                $total += (float)($item['subtotal'] ?? 0);
            }
            return $total;
        } catch (Exception $e) {
            error_log("Error al calcular total del carrito: " . $e->getMessage());
            return 0.0;
        }
    }
}
