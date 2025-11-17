<?php
require_login();
require_once "classes/Pedido.php";
$idUsuario = (int)($_SESSION['usuario']['id_usuario'] ?? 0);
$pedidos = $idUsuario > 0 ? Pedido::porUsuario($idUsuario) : [];
?>

<!-- Hero Section -->
<div class="cuenta-hero">
    <h1 class="cuenta-hero__title">Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?></h1>
    <p class="cuenta-hero__subtitle">Desde aquí podés revisar tu perfil y seguir tus pedidos</p>
</div>

<!-- Account Container -->
<div class="cuenta-container">
    <!-- Profile Card -->
    <div class="cuenta-profile">
        <h2 class="cuenta-profile__title">Mi Perfil</h2>
        
        <div class="cuenta-profile__info">
            <div class="cuenta-profile__item">
                <span class="cuenta-profile__label">Email</span>
                <span class="cuenta-profile__value"><?php echo htmlspecialchars($_SESSION['usuario']['email']); ?></span>
            </div>
            
            <div class="cuenta-profile__item">
                <span class="cuenta-profile__label">Rol</span>
                <span class="cuenta-profile__value"><?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?></span>
            </div>
            
            <div class="cuenta-profile__item">
                <span class="cuenta-profile__label">ID Jugador</span>
                <span class="cuenta-profile__value">#<?php echo $idUsuario; ?></span>
            </div>
        </div>
        
        <a href="index.php?sec=logout" class="btn-arc btn-arc--danger btn-arc--lg">
            <span>Cerrar Sesión</span>
        </a>
    </div>
    
    <!-- Orders Section -->
    <div class="cuenta-orders">
        <h2 class="cuenta-orders__title">Mis Pedidos</h2>
        
        <?php if (empty($pedidos)): ?>
            <div class="cuenta-orders__empty">
                <p>Aún no registramos pedidos.</p>
                <p>Volvé al <a href="index.php?sec=catalogo" class="link-primary">catálogo</a> y desbloqueá tu primer combo.</p>
            </div>
        <?php else: ?>
            <div class="cuenta-orders__list">
                <?php foreach ($pedidos as $pedido): ?>
                    <div class="cuenta-order-card">
                        <div class="cuenta-order-card__header">
                            <span class="cuenta-order-card__id">Pedido #<?php echo $pedido['id_pedido']; ?></span>
                            <span class="cuenta-order-card__badge cuenta-order-card__badge--<?php echo strtolower($pedido['estado']); ?>">
                                <?php echo htmlspecialchars($pedido['estado']); ?>
                            </span>
                        </div>
                        
                        <div class="cuenta-order-card__body">
                            <div class="cuenta-order-card__info">
                                <span class="cuenta-order-card__label">Fecha</span>
                                <span class="cuenta-order-card__value"><?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></span>
                            </div>
                            
                            <div class="cuenta-order-card__info">
                                <span class="cuenta-order-card__label">Total</span>
                                <span class="cuenta-order-card__total"><?php echo number_format($pedido['total'], 2); ?> oro</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
