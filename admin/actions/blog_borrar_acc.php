<?php
// admin/actions/blog_borrar_acc.php
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../classes/Blog.php';
require_once __DIR__ . '/../includes/url.php';
require_admin();

if (!empty($_GET['id']) && isset($_GET['confirmar'])) {
    $id = (int)$_GET['id'];
    if (Blog::delete($id)) {
        header('Location: ' . 'admin/index.php?sec=blogs&msg=eliminado');
    } else {
        header('Location: ' . 'admin/index.php?sec=blogs&error=no_eliminar');
    }
    exit;
}

header('Location: ' . 'admin/index.php?sec=blogs');
exit;
