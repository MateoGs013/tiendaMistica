<?php
// classes/Pedido.php
require_once __DIR__ . '/DB.php';

class Pedido {

    public static function crearDesdeCarrito(int $idUsuario): ?int {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT id_carrito FROM carritos WHERE id_usuario = ? AND estado = 'activo' LIMIT 1");
            $st->execute([$idUsuario]);
            $cart = $st->fetch();
            if (!$cart) return null;
            $idCarrito = (int)$cart['id_carrito'];

            $st = $cn->prepare("SELECT id_duende, cantidad, precio_unitario FROM carrito_items WHERE id_carrito = ?");
            $st->execute([$idCarrito]);
            $items = $st->fetchAll();
            if (!$items) return null;

            $total = 0;
            foreach ($items as $i) {
                $total += $i['cantidad'] * $i['precio_unitario'];
            }

            try {
                $cn->beginTransaction();

                $pi = $cn->prepare("INSERT INTO pedidos (id_usuario, total, estado, fecha_pedido)
                                    VALUES (?, ?, 'pendiente', NOW())");
                $pi->execute([$idUsuario, $total]);
                $idPedido = (int)$cn->lastInsertId();

                $ins = $cn->prepare("INSERT INTO pedido_items (id_pedido, id_duende, cantidad, precio_unitario)
                                     VALUES (?, ?, ?, ?)");
                foreach ($items as $i) {
                    $ins->execute([$idPedido, $i['id_duende'], $i['cantidad'], $i['precio_unitario']]);
                }

                $cn->prepare("UPDATE carritos SET estado = 'convertido' WHERE id_carrito = ?")
                   ->execute([$idCarrito]);

                $cn->commit();
                return $idPedido;
            } catch (Throwable $e) {
                $cn->rollBack();
                error_log("Error en transacción de pedido: " . $e->getMessage());
                return null;
            }
        } catch (Exception $e) {
            error_log("Error al crear pedido desde carrito: " . $e->getMessage());
            return null;
        }
    }

    public static function todos(): array {
        try {
            $cn = DB::get();
            $sql = "SELECT p.*, u.email, u.nombre
                    FROM pedidos p
                    JOIN usuarios u ON u.id_usuario = p.id_usuario
                    ORDER BY p.fecha_pedido DESC";
            return $cn->query($sql)->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener todos los pedidos: " . $e->getMessage());
            return [];
        }
    }

    public static function find(int $id): ?array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT p.*, u.email, u.nombre
                                FROM pedidos p
                                JOIN usuarios u ON u.id_usuario = p.id_usuario
                                WHERE p.id_pedido = ?");
            $st->execute([$id]); // @phpstan-ignore-line
            $row = $st->fetch();
            return $row ?: null;
        } catch (Exception $e) {
            error_log("Error al buscar pedido ID $id: " . $e->getMessage());
            return null;
        }
    }

    public static function getItems(int $idPedido): array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT pi.*, d.nombre AS duende_nombre
                                FROM pedido_items pi
                                JOIN duendes d ON d.id_duende = pi.id_duende
                                WHERE pi.id_pedido = ?");
            $st->execute([$idPedido]); // @phpstan-ignore-line
            return $st->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener items del pedido ID $idPedido: " . $e->getMessage());
            return [];
        }
    }

    public static function updateEstado(int $id, string $estado): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("UPDATE pedidos SET estado = ? WHERE id_pedido = ?");
            return $st->execute([$estado, $id]); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al actualizar estado del pedido ID $id: " . $e->getMessage());
            return false;
        }
    }
}
