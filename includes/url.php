<?php
if (!defined('APP_BASE_PATH')) {
    define('APP_BASE_PATH', '/tienda_mistica/');
}

/**
 * Genera URLs amigables para la aplicación
 */
function url($seccion, $params = []) {
    $base = APP_BASE_PATH;
    
    // URLs especiales con parámetros
    if ($seccion === 'detalle_duende' && !empty($params['id'])) {
        return $base . 'duende/' . $params['id'];
    }
    
    // Para cualquier sección, usar directamente el vínculo
    // Las secciones están en la BD y el .htaccess las maneja
    $url = $base . $seccion;
    
    // Agregar parámetros adicionales si existen
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    return $url;
}

/**
 * Normaliza rutas hacia assets estáticos (imágenes, uploads, etc.)
 */
function asset_url(string $path): string {
    if (preg_match('/^https?:\/\//i', $path)) {
        return $path;
    }

    return APP_BASE_PATH . ltrim($path, '/');
}
