<?php
/**
 * Genera URLs con parámetros GET estándar para el panel de administración
 */
function admin_url($seccion, $params = []) {
    $base = '/tienda_mistica/admin/';
    
    // Usar index.php con parámetros GET
    $url = $base . 'index.php?sec=' . $seccion;
    
    // Agregar parámetros adicionales si existen
    if (!empty($params)) {
        $url .= '&' . http_build_query($params);
    }
    
    return $url;
}
