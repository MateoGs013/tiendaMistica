<?php
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<div class="admin-hero">
    <h1 class="admin-hero__title">Panel de Administración</h1>
    <p class="admin-hero__subtitle">Controlá el inventario de duendes, gestioná pedidos y mantené la tienda mística en orden</p>
</div>

<!-- Modules Grid -->
<div class="admin-dashboard">
    <a href="<?php echo admin_url('duendes'); ?>" class="admin-module-card">
        <div class="admin-module-card__icon">⚙️</div>
        <h3 class="admin-module-card__title">Duendes</h3>
        <p class="admin-module-card__description">Creá, editá o eliminá duendes. Ajustá rarezas, elementos, precios y habilidades.</p>
    </a>

    <a href="<?php echo admin_url('blogs'); ?>" class="admin-module-card">
        <div class="admin-module-card__icon">📝</div>
        <h3 class="admin-module-card__title">Blog</h3>
        <p class="admin-module-card__description">Publicá nuevas historias y mantené iluminada a la comunidad con conocimiento arcano.</p>
    </a>

    <a href="<?php echo admin_url('pedidos'); ?>" class="admin-module-card">
        <div class="admin-module-card__icon">📦</div>
        <h3 class="admin-module-card__title">Pedidos</h3>
        <p class="admin-module-card__description">Revisá órdenes y actualizá estados para que cada duende llegue sin retrasos.</p>
    </a>

    <a href="<?php echo admin_url('contactos'); ?>" class="admin-module-card">
        <div class="admin-module-card__icon">✉️</div>
        <h3 class="admin-module-card__title">Contactos</h3>
        <p class="admin-module-card__description">Respondé mensajes y mantené la reputación mágica en alto con respuestas veloces.</p>
    </a>

    <a href="<?php echo admin_url('usuarios'); ?>" class="admin-module-card">
        <div class="admin-module-card__icon">👥</div>
        <h3 class="admin-module-card__title">Usuarios</h3>
        <p class="admin-module-card__description">Gestioná roles y mantené actualizado el registro de guardianes de la tienda.</p>
    </a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
