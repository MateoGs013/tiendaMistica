<?php
// includes/footer.php
?>
            </div>
        </main>
    </div>

    <!-- Minimalist Arcade Footer -->
    <footer class="arcade-footer">
            <div class="arcade-footer__content">
                <div class="arcade-footer__grid">
                    <div class="arcade-footer__section">
                        <div class="arcade-footer__brand">
                            <i class="fas fa-hat-wizard"></i>
                            <span>TIENDA MÍSTICA</span>
                        </div>
                        <p class="arcade-footer__text">Tu arcade shop de duendes y poder mágico.</p>
                        <p class="arcade-footer__copyright">© <?php echo date('Y'); ?> Tienda Mística. All rights reserved.</p>
                    </div>

                    <div class="arcade-footer__section">
                        <h3 class="arcade-footer__title">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>NAVEGACIÓN</span>
                        </h3>
                        <ul class="arcade-footer__links">
                            <?php if (!empty($seccionesMenu)): ?>
                                <?php foreach ($seccionesMenu as $seccion): ?>
                                    <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                                        <li>
                                            <a href="index.php?sec=<?php echo $seccion['vinculo']; ?>">
                                                <i class="fas fa-chevron-right"></i>
                                                <span><?php echo htmlspecialchars($seccion['titulo']); ?></span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <div class="arcade-footer__section">
                        <h3 class="arcade-footer__title">
                            <i class="fas fa-share-alt"></i>
                            <span>SOCIAL</span>
                        </h3>
                        <div class="arcade-footer__social">
                            <a href="#" class="arcade-social-btn" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="arcade-social-btn" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="arcade-social-btn" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="arcade-social-btn" title="Discord">
                                <i class="fab fa-discord"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="arcade-footer__bottom">
                    <div class="arcade-footer__status">
                        <i class="fas fa-circle"></i>
                        <span>SYSTEM ONLINE</span>
                    </div>
                    <div class="arcade-footer__credits">
                        <i class="fas fa-code"></i>
                        <span>BUILT WITH MAGIC</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
(function() {
    'use strict';

    // ========================================
    // Gateway Loading Animation
    // ========================================
    const gateway = document.getElementById('game-gateway');
    if (gateway) {
        const skipButton = gateway.querySelector('[data-gateway-skip]');
        const progressFill = gateway.querySelector('.game-gateway__progress-fill');
        const percentText = document.getElementById('loading-percent');
        const statusText = document.getElementById('loading-status');
        const systemStatus = document.getElementById('system-status');

        const loadingMessages = [
            'Inicializando portal místico...',
            'Sincronizando energías arcanas...',
            'Cargando catálogo de duendes...',
            'Preparando sistemas de pago...',
            'Activando protecciones mágicas...',
            'Calibrando displays arcade...',
            'Conectando con dimensión mística...',
            'Finalizando preparativos...'
        ];

        let currentPercent = 0;
        let messageIndex = 0;
        const targetPercent = 100;
        const duration = 3000; // 3 seconds
        const interval = 30; // Update every 30ms
        const increment = (targetPercent / duration) * interval;

        // GSAP animation for loading screen elements
        if (typeof gsap !== 'undefined') {
            gsap.from('.game-gateway__spinner', {
                scale: 0,
                rotation: -180,
                opacity: 0,
                duration: 0.8,
                ease: 'back.out(1.7)'
            });

            gsap.from('.game-gateway__title-main', {
                opacity: 0,
                y: -30,
                duration: 0.6,
                delay: 0.3,
                ease: 'power2.out'
            });

            gsap.from('.game-gateway__title-sub', {
                opacity: 0,
                duration: 0.5,
                delay: 0.5
            });

            gsap.from('.game-gateway__progress', {
                opacity: 0,
                scale: 0.9,
                duration: 0.5,
                delay: 0.6
            });
        }

        const updateProgress = () => {
            currentPercent += increment;
            
            if (currentPercent >= targetPercent) {
                currentPercent = targetPercent;
                if (progressFill) progressFill.style.width = '100%';
                if (percentText) percentText.textContent = '100';
                if (statusText) statusText.textContent = '¡Portal activado!';
                if (systemStatus) systemStatus.textContent = 'READY';
                
                // Show skip button after loading
                if (skipButton) {
                    skipButton.style.opacity = '1';
                    skipButton.style.pointerEvents = 'auto';
                }
                
                // Auto-hide after completion
                setTimeout(hideGateway, 800);
            } else {
                const roundedPercent = Math.floor(currentPercent);
                if (progressFill) progressFill.style.width = roundedPercent + '%';
                if (percentText) percentText.textContent = roundedPercent;
                
                // Update message every ~12.5%
                const newMessageIndex = Math.floor((currentPercent / 100) * loadingMessages.length);
                if (newMessageIndex !== messageIndex && newMessageIndex < loadingMessages.length) {
                    messageIndex = newMessageIndex;
                    if (statusText) statusText.textContent = loadingMessages[messageIndex];
                }
                
                requestAnimationFrame(updateProgress);
            }
        };

        const hideGateway = () => {
            if (!gateway.classList.contains('game-gateway--closing')) {
                gateway.classList.add('game-gateway--closing');
                document.body.classList.remove('has-gateway');
                gateway.setAttribute('aria-hidden', 'true');
                
                setTimeout(() => {
                    gateway.classList.add('game-gateway--hidden');
                }, 600);
            }
            
            document.removeEventListener('keydown', handleKeydown);
        };

        gateway.setAttribute('aria-hidden', 'false');

        function handleKeydown(event) {
            if (gateway.classList.contains('game-gateway--closing')) return;
            if (event.key === 'Enter' || event.key === ' ' || event.key === 'Spacebar') {
                event.preventDefault();
                hideGateway();
            }
        }

        if (skipButton) {
            skipButton.addEventListener('click', hideGateway);
        }

        document.addEventListener('keydown', handleKeydown);

        // Start loading animation
        requestAnimationFrame(updateProgress);
    }

    // ========================================
    // Mobile Menu Toggle
    // ========================================
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            const isHidden = mobileMenu.hasAttribute('hidden');
            
            if (isHidden) {
                mobileMenu.removeAttribute('hidden');
                mobileToggle.setAttribute('aria-expanded', 'true');
            } else {
                mobileMenu.setAttribute('hidden', '');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !mobileMenu.hasAttribute('hidden')) {
                mobileMenu.setAttribute('hidden', '');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (event) => {
            if (!mobileMenu.hasAttribute('hidden') && 
                !mobileMenu.contains(event.target) && 
                !mobileToggle.contains(event.target)) {
                mobileMenu.setAttribute('hidden', '');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ========================================
    // User Menu Dropdown
    // ========================================
    const userMenuBtn = document.getElementById('user-menu-btn');
    const userMenu = document.getElementById('user-menu');
    
    if (userMenuBtn && userMenu) {
        userMenuBtn.addEventListener('click', () => {
            const isHidden = userMenu.hasAttribute('hidden');
            
            if (isHidden) {
                userMenu.removeAttribute('hidden');
                userMenuBtn.setAttribute('aria-expanded', 'true');
            } else {
                userMenu.setAttribute('hidden', '');
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Close on escape key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !userMenu.hasAttribute('hidden')) {
                userMenu.setAttribute('hidden', '');
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });

        // Close when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenu.hasAttribute('hidden') && 
                !userMenu.contains(event.target) && 
                !userMenuBtn.contains(event.target)) {
                userMenu.setAttribute('hidden', '');
                userMenuBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // ========================================
    // Smooth Scroll for Anchor Links
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;
            
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // Active Navigation Link
    // ========================================
    const currentPath = window.location.pathname;
    document.querySelectorAll('.arcade-nav__link, .arcade-mobile-nav__link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // ========================================
    // GSAP Animations
    // ========================================
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        // === CARDS (NOT IN GRIDS) ===
        gsap.utils.toArray('.nosotros-feature-card, .admin-module-card').forEach(element => {
            gsap.from(element, {
                scrollTrigger: {
                    trigger: element,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                opacity: 0,
                y: 30,
                duration: 0.6,
                ease: 'power2.out'
            });
        });

        // === HERO SECTIONS ===
        gsap.utils.toArray('.inicio-hero, .nosotros-hero, .blog-hero').forEach(hero => {
            // Parallax background
            gsap.to(hero, {
                scrollTrigger: {
                    trigger: hero,
                    start: 'top top',
                    end: 'bottom top',
                    scrub: 1
                },
                y: 100,
                ease: 'none'
            });

            // Hero content fade in
            const heroTitle = hero.querySelector('.inicio-hero__title, .nosotros-hero__title, .blog-hero__title');
            const heroSubtitle = hero.querySelector('.inicio-hero__subtitle, .nosotros-hero__subtitle, .blog-hero__subtitle');
            const heroActions = hero.querySelector('.inicio-hero__actions, .nosotros-hero__actions, .blog-hero__actions');

            if (heroTitle) {
                gsap.from(heroTitle, {
                    opacity: 0,
                    y: 50,
                    duration: 0.8,
                    ease: 'power3.out',
                    delay: 0.2
                });
            }
            if (heroSubtitle) {
                gsap.from(heroSubtitle, {
                    opacity: 0,
                    y: 30,
                    duration: 0.7,
                    ease: 'power2.out',
                    delay: 0.4
                });
            }
            if (heroActions) {
                gsap.from(heroActions, {
                    opacity: 0,
                    y: 20,
                    duration: 0.6,
                    ease: 'power2.out',
                    delay: 0.6
                });
            }
        });

        // === GRID STAGGER ANIMATIONS ===
        gsap.utils.toArray('.duendes-grid, .blog-grid').forEach(grid => {
            const items = grid.querySelectorAll('.duende-card, .blog-card');
            gsap.fromTo(items, 
                {
                    opacity: 0,
                    y: 40
                },
                {
                    scrollTrigger: {
                        trigger: grid,
                        start: 'top 80%',
                        toggleActions: 'play none none none'
                    },
                    opacity: 1,
                    y: 0,
                    stagger: 0.1,
                    duration: 0.7,
                    ease: 'power3.out'
                }
            );
        });

        // === BADGES & CHIPS ===
        gsap.utils.toArray('.rareza-badge, .admin-badge, .stat-chip').forEach(badge => {
            gsap.from(badge, {
                scrollTrigger: {
                    trigger: badge,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                },
                scale: 0.8,
                opacity: 0,
                duration: 0.4,
                ease: 'back.out(1.7)'
            });
        });

        // === FORM SECTIONS ===
        gsap.utils.toArray('.admin-form-section, .form-section, .login-card, .registro-card').forEach(section => {
            gsap.from(section, {
                scrollTrigger: {
                    trigger: section,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                opacity: 0,
                x: -20,
                duration: 0.6,
                ease: 'power2.out'
            });
        });

        // === PRICES & STATS ===
        gsap.utils.toArray('.precio-valor, .admin-table__price, .duende-precio').forEach(price => {
            gsap.from(price, {
                scrollTrigger: {
                    trigger: price,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                },
                scale: 0.9,
                opacity: 0,
                duration: 0.5,
                ease: 'elastic.out(1, 0.5)'
            });
        });

        // === TABLES ===
        gsap.utils.toArray('.admin-table tbody tr, .arcade-table tbody tr').forEach((row, index) => {
            gsap.from(row, {
                scrollTrigger: {
                    trigger: row,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                },
                opacity: 0,
                x: -20,
                duration: 0.4,
                delay: index * 0.05,
                ease: 'power2.out'
            });
        });

        // === SECTION HEADERS ===
        gsap.utils.toArray('.admin-section-header, .section-header').forEach(header => {
            const title = header.querySelector('.admin-section-title, .section-title');
            const subtitle = header.querySelector('.admin-section-subtitle, .section-subtitle');
            const button = header.querySelector('.btn-arc');

            if (title) {
                gsap.from(title, {
                    opacity: 0,
                    y: -20,
                    duration: 0.6,
                    ease: 'power2.out'
                });
            }
            if (subtitle) {
                gsap.from(subtitle, {
                    opacity: 0,
                    duration: 0.5,
                    delay: 0.2
                });
            }
            if (button) {
                gsap.from(button, {
                    opacity: 0,
                    scale: 0.9,
                    duration: 0.4,
                    delay: 0.3,
                    ease: 'back.out(1.7)'
                });
            }
        });

        // === IMAGES ===
        gsap.utils.toArray('.duende-card__image img, .blog-card__image img, .detalle-imagen img').forEach(img => {
            gsap.from(img, {
                scrollTrigger: {
                    trigger: img,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                scale: 1.1,
                opacity: 0,
                duration: 0.8,
                ease: 'power2.out'
            });
        });

        // === NOSOTROS PAGE SPECIFIC ===
        gsap.utils.toArray('.nosotros-story, .nosotros-manifesto').forEach(element => {
            gsap.from(element, {
                scrollTrigger: {
                    trigger: element,
                    start: 'top 80%',
                    toggleActions: 'play none none none'
                },
                opacity: 0,
                y: 40,
                duration: 0.7,
                ease: 'power2.out'
            });
        });

        gsap.utils.toArray('.nosotros-timeline__item').forEach((item, index) => {
            gsap.from(item, {
                scrollTrigger: {
                    trigger: item,
                    start: 'top 85%',
                    toggleActions: 'play none none none'
                },
                opacity: 0,
                x: index % 2 === 0 ? -30 : 30,
                duration: 0.6,
                ease: 'power2.out'
            });
        });

        // === DETALLE DUENDE PAGE ===
        const detalleInfo = document.querySelector('.detalle-info');
        if (detalleInfo) {
            gsap.from('.detalle-nombre', {
                opacity: 0,
                y: -30,
                duration: 0.7,
                ease: 'power2.out',
                delay: 0.2
            });

            gsap.from('.detalle-rareza', {
                opacity: 0,
                scale: 0.8,
                duration: 0.5,
                ease: 'back.out(1.7)',
                delay: 0.4
            });

            gsap.from('.detalle-descripcion', {
                opacity: 0,
                y: 20,
                duration: 0.6,
                ease: 'power2.out',
                delay: 0.5
            });

            gsap.from('.detalle-precio', {
                opacity: 0,
                scale: 0.9,
                duration: 0.6,
                ease: 'elastic.out(1, 0.5)',
                delay: 0.7
            });

            gsap.from('.cantidad-selector', {
                opacity: 0,
                y: 20,
                duration: 0.5,
                ease: 'power2.out',
                delay: 0.8
            });
        }

        // === CARRITO PAGE ===
        gsap.utils.toArray('.carrito-item').forEach((item, index) => {
            gsap.from(item, {
                opacity: 0,
                x: -30,
                duration: 0.5,
                delay: index * 0.1,
                ease: 'power2.out'
            });
        });

        const carritoResumen = document.querySelector('.carrito-resumen');
        if (carritoResumen) {
            gsap.from(carritoResumen, {
                opacity: 0,
                x: 30,
                duration: 0.6,
                ease: 'power2.out',
                delay: 0.3
            });
        }

        // === CUENTA PAGE ===
        gsap.utils.toArray('.cuenta-stat').forEach((stat, index) => {
            gsap.from(stat, {
                opacity: 0,
                y: 20,
                duration: 0.5,
                delay: index * 0.1,
                ease: 'power2.out'
            });
        });

        // === HEADER ===
        if (!sessionStorage.getItem('headerAnimated')) {
            gsap.from('.arcade-header', {
                y: -100,
                opacity: 0,
                duration: 0.8,
                ease: 'power3.out',
                delay: 0.2
            });

            gsap.from('.arcade-nav__link', {
                opacity: 0,
                y: -20,
                stagger: 0.1,
                duration: 0.5,
                ease: 'power2.out',
                delay: 0.5
            });

            gsap.from('.arcade-cart', {
                opacity: 0,
                scale: 0.8,
                duration: 0.5,
                ease: 'back.out(1.7)',
                delay: 0.8
            });

            sessionStorage.setItem('headerAnimated', 'true');
        }

        // === FOOTER ===
        const footer = document.querySelector('.arcade-footer');
        if (footer) {
            gsap.from(footer, {
                scrollTrigger: {
                    trigger: footer,
                    start: 'top 90%',
                    toggleActions: 'play none none none'
                },
                opacity: 0,
                y: 30,
                duration: 0.6,
                ease: 'power2.out'
            });
        }

        // === BUTTON HOVER MICRO-INTERACTIONS ===
        const buttons = document.querySelectorAll('.btn-arc, .game-gateway__btn, .button-arcade');
        buttons.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                gsap.to(btn, {
                    scale: 1.05,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, {
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
        });

        // === ALERT MESSAGES ===
        gsap.utils.toArray('.alert').forEach(alert => {
            gsap.from(alert, {
                opacity: 0,
                y: -20,
                duration: 0.5,
                ease: 'power2.out'
            });
        });

        // === EMPTY STATES ===
        gsap.utils.toArray('.admin-empty-state, .carrito-vacio').forEach(empty => {
            const icon = empty.querySelector('.admin-empty-state__icon, .carrito-vacio__icon');
            const title = empty.querySelector('.admin-empty-state__title, .carrito-vacio__title');
            const text = empty.querySelector('.admin-empty-state__text, .carrito-vacio__text');

            if (icon) {
                gsap.from(icon, {
                    opacity: 0,
                    scale: 0.5,
                    rotation: -180,
                    duration: 0.6,
                    ease: 'back.out(1.7)'
                });
            }
            if (title) {
                gsap.from(title, {
                    opacity: 0,
                    y: 20,
                    duration: 0.5,
                    delay: 0.2,
                    ease: 'power2.out'
                });
            }
            if (text) {
                gsap.from(text, {
                    opacity: 0,
                    duration: 0.4,
                    delay: 0.4
                });
            }
        });

        // === CONTACTO FORM ===
        const contactoForm = document.querySelector('.contacto-form');
        if (contactoForm) {
            const formGroups = contactoForm.querySelectorAll('.form-group');
            gsap.from(formGroups, {
                opacity: 0,
                x: -20,
                stagger: 0.1,
                duration: 0.5,
                ease: 'power2.out'
            });
        }

        // === ADMIN DASHBOARD CARDS ===
        gsap.utils.toArray('.admin-dashboard .admin-module-card').forEach((card, index) => {
            gsap.from(card, {
                opacity: 0,
                y: 30,
                scale: 0.95,
                duration: 0.5,
                delay: index * 0.1,
                ease: 'back.out(1.2)'
            });
        });

        // === SCROLL PROGRESS INDICATOR (subtle) ===
        const progressBar = document.createElement('div');
        progressBar.style.cssText = 'position: fixed; top: 0; left: 0; height: 2px; background: linear-gradient(90deg, #818CF8, #EC4899, #FBB024); z-index: 10000; transform-origin: left;';
        document.body.appendChild(progressBar);

        gsap.to(progressBar, {
            scrollTrigger: {
                trigger: document.body,
                start: 'top top',
                end: 'bottom bottom',
                scrub: 0.3
            },
            width: '100%',
            ease: 'none'
        });
    }
})();
</script>
</body>
</html>
