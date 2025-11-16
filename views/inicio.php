<!-- Hero Section -->
<section class="arcade-hero">
    <div class="arcade-hero__content">
        <div class="arcade-hero__text">
            <div class="arcade-hero__badge">
                <i class="fas fa-gamepad"></i>
                <span>ARCADE SHOP</span>
            </div>
            
            <h1 class="arcade-hero__title">
                <span class="arcade-hero__title-main">TIENDA MÍSTICA</span>
                <span class="arcade-hero__title-sub">Colecciona Duendes Legendarios</span>
            </h1>
            
            <p class="arcade-hero__description">
                Cada duende es un poder único. Desbloquea fortuna, protección y combos mágicos 
                en una experiencia arcade inspirada en los bosques encantados de Irlanda.
            </p>
            
            <div class="arcade-hero__actions">
                <a href="<?php echo url('catalogo'); ?>" class="arcade-hero__btn arcade-hero__btn--primary">
                    <i class="fas fa-play"></i>
                    <span>EXPLORAR CATÁLOGO</span>
                </a>
                <a href="<?php echo url('blog'); ?>" class="arcade-hero__btn arcade-hero__btn--secondary">
                    <i class="fas fa-book-open"></i>
                    <span>CRÓNICAS</span>
                </a>
            </div>
            
            <div class="arcade-hero__stats">
                <div class="arcade-stat-card">
                    <div class="arcade-stat-card__icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="arcade-stat-card__content">
                        <span class="arcade-stat-card__value">8 NIVELES</span>
                        <span class="arcade-stat-card__label">Rarezas</span>
                    </div>
                </div>
                
                <div class="arcade-stat-card">
                    <div class="arcade-stat-card__icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="arcade-stat-card__content">
                        <span class="arcade-stat-card__value">6 ELEMENTOS</span>
                        <span class="arcade-stat-card__label">Poderes</span>
                    </div>
                </div>
                
                <div class="arcade-stat-card">
                    <div class="arcade-stat-card__icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div class="arcade-stat-card__content">
                        <span class="arcade-stat-card__value">20+ STOCK</span>
                        <span class="arcade-stat-card__label">Duendes</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="arcade-hero__visual">
            <div class="arcade-screen-frame">
                <div class="arcade-screen-frame__inner">
                    <i class="fas fa-hat-wizard"></i>
                </div>
                <div class="arcade-screen-frame__glow"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="arcade-features">
    <div class="arcade-section-header">
        <span class="arcade-section-badge">
            <i class="fas fa-trophy"></i>
            <span>CARACTERÍSTICAS</span>
        </span>
        <h2 class="arcade-section-title">¿Por qué elegir un duende místico?</h2>
    </div>
    
    <div class="arcade-features-grid">
        <div class="arcade-feature-card">
            <div class="arcade-feature-card__icon">
                <i class="fas fa-coins"></i>
            </div>
            <h3 class="arcade-feature-card__title">Fortuna</h3>
            <p class="arcade-feature-card__description">
                Duendes del oro que atraen oportunidades, créditos y loot inesperado a tu vida.
            </p>
        </div>
        
        <div class="arcade-feature-card">
            <div class="arcade-feature-card__icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h3 class="arcade-feature-card__title">Protección</h3>
            <p class="arcade-feature-card__description">
                Guardianes que vigilan entradas y generan barreras luminosas de seguridad.
            </p>
        </div>
        
        <div class="arcade-feature-card">
            <div class="arcade-feature-card__icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <h3 class="arcade-feature-card__title">Inspiración</h3>
            <p class="arcade-feature-card__description">
                Power-ups solares que potencian tu creatividad y confianza personal.
            </p>
        </div>
        
        <div class="arcade-feature-card">
            <div class="arcade-feature-card__icon">
                <i class="fas fa-heart"></i>
            </div>
            <h3 class="arcade-feature-card__title">Equilibrio</h3>
            <p class="arcade-feature-card__description">
                Sanadores que estabilizan emociones y sincronizan tu energía interior.
            </p>
        </div>
    </div>
</section>

<!-- Info Cards Section -->
<section class="arcade-info-section">
    <div class="arcade-info-grid">
        <div class="arcade-info-card">
            <div class="arcade-info-card__header">
                <i class="fas fa-scroll"></i>
                <h3>CATÁLOGO COMPLETO</h3>
            </div>
            <p class="arcade-info-card__text">
                Más de 20 duendes en stock. Filtra por rareza, elemento, precio o nivel de suerte. 
                Sistema de poder total y índice de éxito incluido.
            </p>
            <a href="<?php echo url('catalogo'); ?>" class="arcade-info-card__link">
                <span>VER DUENDES</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="arcade-info-card">
            <div class="arcade-info-card__header">
                <i class="fas fa-book-dead"></i>
                <h3>CRÓNICAS DEL BOSQUE</h3>
            </div>
            <p class="arcade-info-card__text">
                Descubre cómo preparar tu espacio, activar accesorios y combinar elementos 
                sin activar alertas de riesgo.
            </p>
            <a href="<?php echo url('blog'); ?>" class="arcade-info-card__link">
                <span>IR AL BLOG</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="arcade-info-card">
            <div class="arcade-info-card__header">
                <i class="fas fa-question-circle"></i>
                <h3>GUÍA DE SELECCIÓN</h3>
            </div>
            <p class="arcade-info-card__text">
                Define si buscas fortuna, protección o inspiración. Revisa rareza, elemento 
                y compatibilidad con accesorios mágicos.
            </p>
            <a href="<?php echo url('contacto'); ?>" class="arcade-info-card__link">
                <span>CONSULTAR</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Guarantee Section -->
<section class="arcade-guarantee">
    <div class="arcade-guarantee__content">
        <div class="arcade-guarantee__icon">
            <i class="fas fa-certificate"></i>
        </div>
        <div class="arcade-guarantee__text">
            <h3 class="arcade-guarantee__title">GARANTÍA ARCADE</h3>
            <p class="arcade-guarantee__description">
                Cada duende incluye guía de cuidados, advertencias específicas y garantía de satisfacción de 30 días.
            </p>
        </div>
        <div class="arcade-guarantee__badge">
            <i class="fas fa-check-circle"></i>
            <span>CALIDAD VERIFICADA</span>
        </div>
    </div>
</section>
