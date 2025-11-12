<?php
// includes/footer.php
?>
            </div>
        </main>
        <footer class="bg-arcade-panel/90 border-t border-arcade-magenta/20">
            <div class="max-w-7xl mx-auto px-4 py-10 lg:px-8">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <p class="font-retro text-xs uppercase tracking-[0.3em] text-arcade-cyan">Insert Coin</p>
                        <p class="mt-3 font-orbitron text-lg text-white">Prepará tu próxima aventura mística.</p>
                        <p class="mt-4 text-sm text-slate-300">&copy; <?php echo date('Y'); ?> Tienda Mística de Duendes. Todos los derechos reservados.</p>
                    </div>
                    <div>
                        <p class="font-orbitron text-sm uppercase text-arcade-magenta">Mapa místico</p>
                        <ul class="mt-3 space-y-2 text-sm">
                            <?php if (!empty($seccionesMenu)): ?>
                                <?php foreach ($seccionesMenu as $seccion): ?>
                                    <?php if (!empty($seccion['vinculo']) && !empty($seccion['titulo'])): ?>
                                        <li><a class="footer-link" href="<?php echo url($seccion['vinculo']); ?>"><?php echo htmlspecialchars($seccion['titulo']); ?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div>
                        <p class="font-orbitron text-sm uppercase text-arcade-magenta">Arcade social</p>
                        <p class="mt-3 text-sm text-slate-300">Seguinos en nuestras salas retro y desbloqueá combos mágicos.</p>
                        <div class="mt-4 flex gap-3">
                            <a class="social-chip" href="#">Instagram</a>
                            <a class="social-chip" href="#">TikTok</a>
                            <a class="social-chip" href="#">Twitch</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    (function() {
        const toggle = document.getElementById('btn-mobile-menu');
        const menu = document.getElementById('mobile-menu');
        if (!toggle || !menu) {
            return;
        }
        toggle.addEventListener('click', function () {
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden');
            toggle.setAttribute('aria-expanded', String(isHidden));
        });
    }());
</script>
</body>
</html>
