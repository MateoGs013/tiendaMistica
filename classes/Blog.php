<?php
// classes/Blog.php
require_once __DIR__ . '/DB.php';

class Blog {
    public static function latest(): array {
        try {
            $cn = DB::get();
            return $cn->query("SELECT id_blog, titulo, slug, descripcion_corta, fecha_publicacion, categoria, imagen_portada, autor
                               FROM blogs ORDER BY fecha_publicacion DESC")->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener últimos blogs: " . $e->getMessage());
            return [];
        }
    }

    public static function all(): array {
        try {
            $cn = DB::get();
            return $cn->query("SELECT * FROM blogs ORDER BY fecha_publicacion DESC")->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener todos los blogs: " . $e->getMessage());
            return [];
        }
    }

    public static function find(int $id): ?array {
        try {
            $cn = DB::get();
            $st = $cn->prepare("SELECT * FROM blogs WHERE id_blog = ?");
            $st->execute([$id]); // @phpstan-ignore-line
            $row = $st->fetch();
            return $row ?: null;
        } catch (Exception $e) {
            error_log("Error al buscar blog ID $id: " . $e->getMessage());
            return null;
        }
    }

    public static function create(array $data): bool {
        try {
            $cn = DB::get();
            $sql = "INSERT INTO blogs (titulo, slug, descripcion_corta, contenido, autor, fecha_publicacion, imagen_url)
                    VALUES (:titulo, :slug, :descripcion_corta, :contenido, :autor, :fecha_publicacion, :imagen_url)";
            $st = $cn->prepare($sql);
            return $st->execute($data); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al crear blog: " . $e->getMessage());
            return false;
        }
    }

    public static function update(int $id, array $data): bool {
        try {
            $cn = DB::get();
            $data['id'] = $id; // @phpstan-ignore-line
            $sql = "UPDATE blogs SET
                    titulo = :titulo,
                    slug = :slug,
                    descripcion_corta = :descripcion_corta,
                    contenido = :contenido,
                    autor = :autor,
                    fecha_publicacion = :fecha_publicacion,
                    imagen_url = :imagen_url
                    WHERE id_blog = :id";
            $st = $cn->prepare($sql);
            return $st->execute($data); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al actualizar blog ID $id: " . $e->getMessage());
            return false;
        }
    }

    public static function delete(int $id): bool {
        try {
            $cn = DB::get();
            $st = $cn->prepare("DELETE FROM blogs WHERE id_blog = ?");
            return $st->execute([$id]); // @phpstan-ignore-line
        } catch (Exception $e) {
            error_log("Error al eliminar blog ID $id: " . $e->getMessage());
            return false;
        }
    }
}
