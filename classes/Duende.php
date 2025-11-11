<?php
// classes/Duende.php
require_once __DIR__ . '/DB.php';

class Duende {

    public static function all(): array {
        try {
            $cn = DB::get();
            $sql = "SELECT d.id_duende, d.nombre, d.tipo, d.precio_en_oro, d.disponible,
                           r.nombre AS rareza, e.nombre AS elemento
                    FROM duendes d
                    LEFT JOIN rareza r ON r.id_rareza = d.id_rareza
                    LEFT JOIN elementos e ON e.id_elemento = d.id_elemento
                    ORDER BY d.popularidad DESC, d.id_duende DESC";
            return $cn->query($sql)->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener todos los duendes: " . $e->getMessage());
            return [];
        }
    }

    public static function allDisponibles(): array {
        try {
            $cn = DB::get();
            $sql = "SELECT d.id_duende, d.nombre, d.tipo, d.precio_en_oro, d.disponible,
                           r.nombre AS rareza, e.nombre AS elemento
                    FROM duendes d
                    LEFT JOIN rareza r ON r.id_rareza = d.id_rareza
                    LEFT JOIN elementos e ON e.id_elemento = d.id_elemento
                    WHERE d.disponible = 1
                    ORDER BY d.popularidad DESC";
            return $cn->query($sql)->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener duendes disponibles: " . $e->getMessage());
            return [];
        }
    }

    public static function find(int $id): ?array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT d.*, r.nombre AS rareza, e.nombre AS elemento
                                FROM duendes d
                                LEFT JOIN rareza r ON r.id_rareza = d.id_rareza
                                LEFT JOIN elementos e ON e.id_elemento = d.id_elemento
                                WHERE d.id_duende = ?");
            $st->execute([$id]);
            $row = $st->fetch();
            return $row ?: null;
        } catch (Exception $e) {
            error_log("Error al buscar duende ID $id: " . $e->getMessage());
            return null;
        }
    }

    // Métodos base listos para el ABM de admin
    public static function create(array $data): bool {
        try {
            $cn = DB::get();
            $sql = "INSERT INTO duendes
                (nombre,tipo,color_principal,altura_cm,personalidad,id_rareza,precio_en_oro,
                 efecto_magico,id_elemento,nivel_maldad,nivel_suerte,origen_mitologico,
                 id_material,disponible,fecha_creacion,popularidad,recomendado_para,
                 advertencias,imagen_url,descripcion)
                VALUES
                (:nombre,:tipo,:color_principal,:altura_cm,:personalidad,:id_rareza,:precio_en_oro,
                 :efecto_magico,:id_elemento,:nivel_maldad,:nivel_suerte,:origen_mitologico,
                 :id_material,:disponible,:fecha_creacion,:popularidad,:recomendado_para,
                 :advertencias,:imagen_url,:descripcion)";
            $st = $cn->prepare($sql);
            return $st->execute($data);
        } catch (Exception $e) {
            error_log("Error al crear duende: " . $e->getMessage());
            return false;
        }
    }

    public static function update(int $id, array $data): bool {
        try {
            $cn = DB::get();
            $data['id'] = $id;
            $sql = "UPDATE duendes SET
                nombre=:nombre,
                tipo=:tipo,
                color_principal=:color_principal,
                altura_cm=:altura_cm,
                personalidad=:personalidad,
                id_rareza=:id_rareza,
                precio_en_oro=:precio_en_oro,
                efecto_magico=:efecto_magico,
                id_elemento=:id_elemento,
                nivel_maldad=:nivel_maldad,
                nivel_suerte=:nivel_suerte,
                origen_mitologico=:origen_mitologico,
                id_material=:id_material,
                disponible=:disponible,
                fecha_creacion=:fecha_creacion,
                popularidad=:popularidad,
                recomendado_para=:recomendado_para,
                advertencias=:advertencias,
                imagen_url=:imagen_url,
                descripcion=:descripcion
                WHERE id_duende=:id";
            $st = $cn->prepare($sql);
            return $st->execute($data);
        } catch (Exception $e) {
            error_log("Error al actualizar duende ID $id: " . $e->getMessage());
            return false;
        }
    }

    public static function delete(int $id): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("DELETE FROM duendes WHERE id_duende = ?");
            return $st->execute([$id]);
        } catch (Exception $e) {
            error_log("Error al eliminar duende ID $id: " . $e->getMessage());
            return false;
        }
    }
}
