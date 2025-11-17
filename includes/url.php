<?php
if (!defined('APP_BASE_PATH')) {
    define('APP_BASE_PATH', '/tienda_mistica/');
}

/**
 * Genera URLs con parámetros GET estándar
 */
function url($seccion, $params = []) {
    $base = APP_BASE_PATH;
    
    // Usar index.php con parámetros GET
    $url = $base . 'index.php?sec=' . $seccion;
    
    // Agregar parámetros adicionales si existen
    if (!empty($params)) {
        $url .= '&' . http_build_query($params);
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
