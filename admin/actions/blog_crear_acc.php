<?php
// admin/actions/blog_crear_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Blog.php';

// Verificar que el usuario sea admin
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'titulo' => trim($_POST['titulo'] ?? ''),
        'slug' => trim($_POST['slug'] ?? ''),
        'descripcion_corta' => trim($_POST['descripcion_corta'] ?? ''),
        'contenido' => trim($_POST['contenido'] ?? ''),
        'autor' => trim($_POST['autor'] ?? ''),
        'fecha_publicacion' => $_POST['fecha_publicacion'] ?? date('Y-m-d'),
        'imagen_url' => trim($_POST['imagen_url'] ?? '')
    ];
    
    // Generar slug automáticamente si está vacío
    if (empty($data['slug']) && !empty($data['titulo'])) {
        $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data['titulo']), '-'));
    }
    
    if (empty($data['titulo'])) {
        $_SESSION['error'] = "El título es obligatorio";
        $_SESSION['old_data'] = $data;
        header("Location: " . 'admin/index.php?sec=blog_crear');
        exit;
    }
    
    if (empty($data['slug'])) {
        $_SESSION['error'] = "El slug es obligatorio";
        $_SESSION['old_data'] = $data;
        header("Location: " . 'admin/index.php?sec=blog_crear');
        exit;
    }
    
    try {
        if (Blog::create($data)) {
            $_SESSION['success'] = "Blog creado exitosamente";
            header("Location: " . 'admin/index.php?sec=blogs');
            exit;
        } else {
            $_SESSION['error'] = "Error al crear el blog";
            $_SESSION['old_data'] = $data;
            header("Location: " . 'admin/index.php?sec=blog_crear');
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al crear blog: " . $e->getMessage());
        $_SESSION['error'] = "Error al crear el blog. Por favor, intenta nuevamente.";
        $_SESSION['old_data'] = $data;
        header("Location: " . 'admin/index.php?sec=blog_crear');
        exit;
    }
} else {
    header("Location: " . 'admin/index.php?sec=blog_crear');
    exit;
}
