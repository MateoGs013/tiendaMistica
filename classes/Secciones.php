<?php
// classes/Secciones.php
require_once __DIR__ . '/DB.php';

class Secciones {

    // Secciones válidas para el front
    public static function secciones_validas(): array {
        try {
            $cn = DB::get();
            $rs = $cn->query("SELECT vinculo FROM secciones");
            return array_column($rs->fetchAll(), 'vinculo');
        } catch (Exception $e) {
            error_log("Error al obtener secciones válidas: " . $e->getMessage());
            return ['inicio', 'catalogo', 'blog', 'contacto', 'carrito'];
        }
    }

    // Secciones que aparecen en el menú
    public static function secciones_menu(): array {
        try {
            $cn = DB::get();
            $rs = $cn->query("SELECT vinculo, titulo FROM secciones WHERE menu = 1 ORDER BY id_seccion");
            return $rs->fetchAll();
        } catch (Exception $e) {
            error_log("Error al obtener secciones del menú: " . $e->getMessage());
            return [
                ['vinculo' => 'inicio', 'titulo' => 'Inicio'],
                ['vinculo' => 'catalogo', 'titulo' => 'Catálogo'],
                ['vinculo' => 'blog', 'titulo' => 'Blog'],
                ['vinculo' => 'contacto', 'titulo' => 'Contacto']
            ];
        }
    }
}
