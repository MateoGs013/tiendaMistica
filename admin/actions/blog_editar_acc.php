<?php
// admin/actions/blog_editar_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Blog.php';

// Verificar que el usuario sea admin
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        $_SESSION['error'] = "ID de blog inválido";
        header("Location: " . 'admin/index.php?sec=blogs');
        exit;
    }
    
    $data = [
        'titulo' => trim($_POST['titulo'] ?? ''),
        'slug' => trim($_POST['slug'] ?? ''),
        'descripcion_corta' => trim($_POST['descripcion_corta'] ?? ''),
        'contenido' => trim($_POST['contenido'] ?? ''),
        'autor' => trim($_POST['autor'] ?? ''),
        'fecha_publicacion' => $_POST['fecha_publicacion'] ?? date('Y-m-d'),
        'imagen_url' => trim($_POST['imagen_url'] ?? '')
    ];
    
    if (empty($data['titulo'])) {
        $_SESSION['error'] = "El título es obligatorio";
        header("Location: " . 'admin/index.php?sec=blog_editar&id=' . $id);
        exit;
    }
    
    if (empty($data['slug'])) {
        $_SESSION['error'] = "El slug es obligatorio";
        header("Location: " . 'admin/index.php?sec=blog_editar&id=' . $id);
        exit;
    }
    
    try {
        if (Blog::update($id, $data)) {
            $_SESSION['success'] = "Blog actualizado exitosamente";
            header("Location: " . 'admin/index.php?sec=blogs');
            exit;
        } else {
            $_SESSION['error'] = "Error al actualizar el blog";
            header("Location: " . 'admin/index.php?sec=blog_editar&id=' . $id);
            exit;
        }
    } catch (Exception $e) {
        error_log("Error al actualizar blog: " . $e->getMessage());
        $_SESSION['error'] = "Error al actualizar el blog. Por favor, intenta nuevamente.";
        header("Location: " . 'admin/index.php?sec=blog_editar&id=' . $id);
        exit;
    }
} else {
    header("Location: " . 'admin/index.php?sec=blogs');
    exit;
}
