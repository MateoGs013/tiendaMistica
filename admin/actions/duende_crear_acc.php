<?php
// admin/actions/duende_crear_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Duende.php';
require_once __DIR__ . '/../../classes/Imagen.php';

// Verificar que el usuario sea admin
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'tipo' => trim($_POST['tipo'] ?? ''),
        'color_principal' => trim($_POST['color_principal'] ?? ''),
        'altura_cm' => (int)($_POST['altura_cm'] ?? 0),
        'personalidad' => trim($_POST['personalidad'] ?? ''),
        'id_rareza' => (int)($_POST['id_rareza'] ?? 1),
        'precio_en_oro' => (float)($_POST['precio_en_oro'] ?? 0),
        'efecto_magico' => trim($_POST['efecto_magico'] ?? ''),
        'id_elemento' => (int)($_POST['id_elemento'] ?? 1),
        'nivel_maldad' => (int)($_POST['nivel_maldad'] ?? 1),
        'nivel_suerte' => (int)($_POST['nivel_suerte'] ?? 5),
        'origen_mitologico' => trim($_POST['origen_mitologico'] ?? ''),
        'id_material' => (int)($_POST['id_material'] ?? 1),
        'disponible' => isset($_POST['disponible']) ? 1 : 0,
        'fecha_creacion' => $_POST['fecha_creacion'] ?? date('Y-m-d'),
        'popularidad' => (int)($_POST['popularidad'] ?? 50),
        'recomendado_para' => trim($_POST['recomendado_para'] ?? ''),
        'advertencias' => trim($_POST['advertencias'] ?? ''),
        'imagen_url' => trim($_POST['imagen_url'] ?? ''),
        'descripcion' => trim($_POST['descripcion'] ?? '')
    ];
    
    if (empty($data['nombre'])) {
        $_SESSION['error'] = "El nombre es obligatorio";
        $_SESSION['old_data'] = $data;
        header("Location: " . 'admin/index.php?sec=duende_crear');
        exit;
    }

    $imagenGuardada = null;
    $archivo = $_FILES['imagen'] ?? null;
    if ($archivo && ($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        try {
            $ruta = Imagen::subir($archivo, __DIR__ . '/../../uploads/duendes', ['nombre' => $data['nombre']]);
            $data['imagen_url'] = $ruta;
            $imagenGuardada = $ruta;
        } catch (RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
            $_SESSION['old_data'] = $data;
            header("Location: " . 'admin/index.php?sec=duende_crear');
            exit;
        }
    }
    
    try {
        if (Duende::create($data)) {
            $_SESSION['success'] = "Duende creado exitosamente";
            header("Location: " . 'admin/index.php?sec=duendes');
            exit;
        } else {
            if ($imagenGuardada) {
                Imagen::borrar($imagenGuardada);
            }
            $_SESSION['error'] = "Error al crear el duende";
            $_SESSION['old_data'] = $data;
            header("Location: " . 'admin/index.php?sec=duende_crear');
            exit;
        }
    } catch (Exception $e) {
        if ($imagenGuardada) {
            Imagen::borrar($imagenGuardada);
        }
        error_log("Error al crear duende: " . $e->getMessage());
        $_SESSION['error'] = "Error al crear el duende. Por favor, intenta nuevamente.";
        $_SESSION['old_data'] = $data;
        header("Location: " . 'admin/index.php?sec=duende_crear');
        exit;
    }
} else {
    header("Location: " . 'admin/index.php?sec=duende_crear');
    exit;
}
