<?php
/**
 * Genera URLs amigables para la aplicación
 */
function url($seccion, $params = []) {
    // Base de la aplicación (debe coincidir con RewriteBase del .htaccess)
    $base = '/tienda_mistica/';
    
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
