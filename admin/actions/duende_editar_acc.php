<?php
// admin/actions/duende_editar_acc.php
session_start();
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../includes/url.php';
require_once __DIR__ . '/../../classes/Duende.php';
require_once __DIR__ . '/../../classes/Imagen.php';

// Verificar que el usuario sea admin
require_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        $_SESSION['error'] = "ID de duende inválido";
        header("Location: " . 'admin/index.php?sec=duendes');
        exit;
    }
    
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
        header("Location: " . 'admin/index.php?sec=duende_editar&id=' . $id);
        exit;
    }
    
    $imagenActual = trim($_POST['imagen_actual'] ?? '');
    $archivo = $_FILES['imagen'] ?? null;
    $imagenesPendientes = [];
    $nuevaImagenLocal = null;
    $esActualLocal = $imagenActual !== '' && !preg_match('/^https?:\/\//i', $imagenActual);
    $actualNormalizado = $esActualLocal ? ltrim($imagenActual, '/') : $imagenActual;

    if ($archivo && ($archivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        try {
            $nuevaRuta = Imagen::subir($archivo, __DIR__ . '/../../uploads/duendes', ['nombre' => $data['nombre'] ?: 'duende']);
            $data['imagen_url'] = $nuevaRuta;
            $nuevaImagenLocal = $nuevaRuta;
            if ($esActualLocal) {
                $imagenesPendientes[] = $imagenActual;
            }
        } catch (RuntimeException $e) {
            $_SESSION['error'] = $e->getMessage();
            header("Location: " . 'admin/index.php?sec=duende_editar&id=' . $id);
            exit;
        }
    } else {
        $nuevaEntrada = $data['imagen_url'];
        if ($nuevaEntrada === '') {
            if ($imagenActual) {
                $data['imagen_url'] = $imagenActual;
            }
        } else {
            $nuevaEsLocal = !preg_match('/^https?:\/\//i', $nuevaEntrada);
            if ($nuevaEsLocal) {
                $nuevaNormalizada = ltrim($nuevaEntrada, '/');
                $data['imagen_url'] = $nuevaNormalizada;
                if ($esActualLocal) {
                    if ($nuevaNormalizada === $actualNormalizado) {
                        $data['imagen_url'] = $imagenActual;
                    } else {
                        $imagenesPendientes[] = $imagenActual;
                    }
                }
            } else {
                if ($esActualLocal) {
                    $imagenesPendientes[] = $imagenActual;
                }
                $data['imagen_url'] = $nuevaEntrada;
            }
        }
    }

    try {
        if (Duende::update($id, $data)) {
            foreach ($imagenesPendientes as $ruta) {
                Imagen::borrar($ruta);
            }
            $_SESSION['success'] = "Duende actualizado exitosamente";
            header("Location: " . 'admin/index.php?sec=duendes');
            exit;
        } else {
            if ($nuevaImagenLocal) {
                Imagen::borrar($nuevaImagenLocal);
            }
            $_SESSION['error'] = "Error al actualizar el duende";
            header("Location: " . 'admin/index.php?sec=duende_editar&id=' . $id);
            exit;
        }
    } catch (Exception $e) {
        if ($nuevaImagenLocal) {
            Imagen::borrar($nuevaImagenLocal);
        }
        error_log("Error al actualizar duende: " . $e->getMessage());
        $_SESSION['error'] = "Error al actualizar el duende. Por favor, intenta nuevamente.";
        header("Location: " . 'admin/index.php?sec=duende_editar&id=' . $id);
        exit;
    }
} else {
    header("Location: " . 'admin/index.php?sec=duendes');
    exit;
}
