<?php
// classes/Imagen.php

class Imagen {
    public static function subir(array $archivo, string $destino, array $opciones = []): string {
        $error = $archivo['error'] ?? UPLOAD_ERR_NO_FILE;
        if ($error === UPLOAD_ERR_NO_FILE) {
            throw new RuntimeException('No se recibió archivo.');
        }
        if ($error !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Error al subir el archivo.');
        }

        $tamMax = (int)($opciones['max'] ?? 5 * 1024 * 1024);
        if (($archivo['size'] ?? 0) > $tamMax) {
            throw new RuntimeException('El archivo excede el tamaño permitido.');
        }

        $permitidas = $opciones['extensiones'] ?? ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $nombreOriginal = $archivo['name'] ?? '';
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        if ($extension === '' || !in_array($extension, $permitidas, true)) {
            throw new RuntimeException('El formato de imagen no es válido.');
        }

        $base = $opciones['nombre'] ?? pathinfo($nombreOriginal, PATHINFO_FILENAME);
        if (function_exists('iconv')) {
            $base = iconv('UTF-8', 'ASCII//TRANSLIT', $base);
        }
        $base = self::slug((string)$base);
        if ($base === '') {
            $base = 'imagen';
        }
        $nombreFinal = $base . '-' . uniqid('', true) . '.' . $extension;

        $destino = rtrim($destino, DIRECTORY_SEPARATOR);
        if (!is_dir($destino)) {
            if (!mkdir($destino, 0775, true)) {
                throw new RuntimeException('No se pudo crear la carpeta de destino.');
            }
        }

        $rutaFisica = $destino . DIRECTORY_SEPARATOR . $nombreFinal;
        if (!move_uploaded_file($archivo['tmp_name'], $rutaFisica)) {
            throw new RuntimeException('No se pudo mover el archivo subido.');
        }
        if (function_exists('chmod')) {
            @chmod($rutaFisica, 0644);
        }

        $root = realpath(dirname(__DIR__));
        $real = realpath($rutaFisica);
        if (!$root || !$real || strncasecmp($real, $root, strlen($root)) !== 0) {
            throw new RuntimeException('Ruta de archivo inválida.');
        }
        $rel = substr($real, strlen($root));
        $rel = str_replace('\\', '/', $rel);
        return ltrim($rel, '/');
    }

    public static function borrar(...$args): void {
        $rutaLocal = $args[0] ?? null;
        if (!$rutaLocal) {
            return;
        }
        $root = realpath(dirname(__DIR__));
        $local = $root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rutaLocal);
        $real = realpath($local);
        if ($real && strncasecmp($real, $root . DIRECTORY_SEPARATOR . 'uploads', strlen($root . DIRECTORY_SEPARATOR . 'uploads')) === 0 && is_file($real)) {
            @unlink($real);
        }
    }

    private static function slug(...$args): string {
        $textoLocal = strtolower(trim((string)($args[0] ?? '')));
        $textoLocal = preg_replace('/[^a-z0-9]+/i', '-', $textoLocal);
        return trim((string)$textoLocal, '-');
    }
}
