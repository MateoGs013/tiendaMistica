<?php
// Script de prueba para verificar la conexión y los usuarios
require_once "classes/DB.php";
require_once "classes/Usuario.php";

echo "<h1>Test de Base de Datos y Login</h1>";

// 1. Probar conexión
echo "<h2>1. Conexión a base de datos:</h2>";
try {
    $cn = DB::get();
    echo "✅ Conexión exitosa<br>";
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    die();
}

// 2. Verificar usuarios en la base de datos
echo "<h2>2. Usuarios en la base de datos:</h2>";
try {
    $st = $cn->query("SELECT id_usuario, nombre, email, rol, activo FROM usuarios");
    $usuarios = $st->fetchAll();
    if (count($usuarios) > 0) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Activo</th></tr>";
        foreach ($usuarios as $u) {
            echo "<tr>";
            echo "<td>{$u['id_usuario']}</td>";
            echo "<td>{$u['nombre']}</td>";
            echo "<td>{$u['email']}</td>";
            echo "<td>{$u['rol']}</td>";
            echo "<td>{$u['activo']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "⚠️ No hay usuarios en la base de datos<br>";
    }
} catch (Exception $e) {
    echo "❌ Error al consultar usuarios: " . $e->getMessage() . "<br>";
}

// 3. Probar findByEmail
echo "<h2>3. Prueba de Usuario::findByEmail():</h2>";
$testEmail = 'admin@tienda.com';
echo "Buscando: {$testEmail}<br>";
$user = Usuario::findByEmail($testEmail);
if ($user) {
    echo "✅ Usuario encontrado:<br>";
    echo "- ID: {$user['id_usuario']}<br>";
    echo "- Nombre: {$user['nombre']}<br>";
    echo "- Email: {$user['email']}<br>";
    echo "- Rol: {$user['rol']}<br>";
    echo "- Activo: {$user['activo']}<br>";
    echo "- Hash guardado: " . substr($user['password_hash'], 0, 30) . "...<br>";
} else {
    echo "❌ Usuario NO encontrado<br>";
}

// 4. Probar verificación de contraseña
echo "<h2>4. Prueba de password_verify():</h2>";
if ($user) {
    $passwordTest = 'admin123';
    echo "Probando contraseña: '{$passwordTest}'<br>";
    
    $hashFromDB = $user['password_hash'];
    echo "Hash desde DB: " . substr($hashFromDB, 0, 60) . "...<br>";
    
    $result = password_verify($passwordTest, $hashFromDB);
    if ($result) {
        echo "✅ Contraseña CORRECTA<br>";
    } else {
        echo "❌ Contraseña INCORRECTA<br>";
        
        // Generar un nuevo hash para comparar
        echo "<br><strong>Debug:</strong><br>";
        $newHash = password_hash($passwordTest, PASSWORD_BCRYPT);
        echo "Hash nuevo generado: " . substr($newHash, 0, 60) . "...<br>";
        echo "Verificando con nuevo hash: " . (password_verify($passwordTest, $newHash) ? '✅' : '❌') . "<br>";
    }
}

// 5. Probar la función login_usuario completa
echo "<h2>5. Prueba de login_usuario():</h2>";
require_once "includes/functions.php";
$loginResult = login_usuario('admin@tienda.com', 'admin123');
if ($loginResult) {
    echo "✅ Login exitoso<br>";
    echo "Sesión iniciada para: {$_SESSION['usuario']['nombre']}<br>";
} else {
    echo "❌ Login falló<br>";
}

echo "<hr>";
echo "<p><a href='index.php?sec=login'>Ir al Login</a> | <a href='index.php'>Ir al Inicio</a></p>";
?>
