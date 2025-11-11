<?php
/**
 * Genera URLs amigables para el panel de administración
 */
function admin_url($seccion, $params = []) {
    // Base de la aplicación admin (debe coincidir con RewriteBase del .htaccess)
    $base = '/tienda_mistica/admin/';
    
    // URLs especiales con parámetros
    if ($seccion === 'duende_editar' && !empty($params['id'])) {
        return $base . 'duende/editar/' . $params['id'];
    }
    
    if ($seccion === 'duende_borrar' && !empty($params['id'])) {
        return $base . 'duende/borrar/' . $params['id'];
    }
    
    if ($seccion === 'duende_crear') {
        return $base . 'duende/crear';
    }
    
    if ($seccion === 'inicio') {
        return $base;
    }
    
    if ($seccion === 'blog_editar' && !empty($params['id'])) {
        return $base . 'blog/editar/' . $params['id'];
    }
    
    if ($seccion === 'blog_borrar' && !empty($params['id'])) {
        return $base . 'blog/borrar/' . $params['id'];
    }
    
    if ($seccion === 'blog_crear') {
        return $base . 'blog/crear';
    }
    
    if ($seccion === 'contacto_ver' && !empty($params['id'])) {
        return $base . 'contacto/ver/' . $params['id'];
    }
    
    if ($seccion === 'contacto_borrar' && !empty($params['id'])) {
        return $base . 'contacto/borrar/' . $params['id'];
    }
    
    if ($seccion === 'pedido_ver' && !empty($params['id'])) {
        return $base . 'pedido/ver/' . $params['id'];
    }
    
    // URL estándar (páginas simples como duendes, blogs, contactos, pedidos)
    $url = $base . $seccion;
    
    // Agregar parámetros adicionales si existen
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    
    return $url;
}
