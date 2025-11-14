<section class="panel-glass scanline-overlay overflow-hidden">
    <div class="relative z-10 grid gap-10 px-6 py-12 lg:grid-cols-2 lg:px-12">
        <div class="flex flex-col justify-center space-y-6">
            <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-cyan flicker">Insert coin to begin</p>
            <h1 class="font-orbitron text-4xl text-white drop-shadow sm:text-5xl">
                Bienvenido al Salón Arcade de los Duendes Místicos
            </h1>
            <p class="text-lg text-slate-300">
                Cada duende es un power-up único. Desbloqueá fortuna, protección y combos mágicos
                en una experiencia retro 3D inspirada en los bosques encantados de Irlanda.
            </p>
            <div class="flex flex-col gap-4 sm:flex-row">
                <a href="<?php echo url('catalogo'); ?>" class="button-arcade">
                    <span>Comenzar</span>
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </a>
                <a href="<?php echo url('blog'); ?>" class="button-arcade" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-epico), 0.28), rgba(var(--rareza-rgb-raro), 0.42));">
                    <span>Crónicas del Bosque</span>
                </a>
            </div>
            <div class="grid gap-3 text-sm text-slate-300 sm:grid-cols-2">
                <div class="neon-card p-4">
                    <p class="font-orbitron text-xs uppercase tracking-[0.16em] text-arcade-magenta">Rarezas</p>
                    <p class="mt-2 text-2xl font-semibold text-arcade-gold">4 niveles</p>
                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">Desde comunes hasta legendarios</p>
                </div>
                <div class="neon-card p-4">
                    <p class="font-orbitron text-xs uppercase tracking-[0.16em] text-arcade-magenta">Elementos</p>
                    <p class="mt-2 text-2xl font-semibold text-arcade-cyan">6 poderes</p>
                    <p class="mt-1 text-xs uppercase tracking-[0.18em] text-slate-400">Tierra, agua, fuego, sombra, luz, aire</p>
                </div>
            </div>
        </div>
        <div class="relative flex items-center justify-center">
            <div class="neon-card h-full w-full max-w-md scale-105 bg-gradient-to-br from-arcade-panel/90 via-arcade-panel/65 to-arcade-base/95 p-8 text-center shadow-neon-strong">
                <div class="mx-auto flex h-32 w-32 items-center justify-center rounded-full border border-arcade-cyan/50 bg-arcade-base/90 shadow-neon">
                    <svg class="h-20 w-20 text-arcade-gold" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 3v3m6-3v3m-9 4h6l4 4v6H5v-6l4-4zm1 4v2m4-2v2" />
                    </svg>
                </div>
                <h2 class="mt-8 font-orbitron text-2xl text-white">Salón de Power-Ups</h2>
                <p class="mt-4 text-sm text-slate-300">
                    Sumergite en el bosque neon. Visualizá stats, rarezas y combos con efectos especiales en 3D.
                </p>
                <div class="glow-divider"></div>
                <ul class="space-y-3 text-left text-sm text-slate-200">
                    <li class="flex items-center gap-3">
                        <span class="stat-chip">Fortuna + Suerte</span>
                        <span class="text-xs uppercase tracking-[0.2em] text-slate-400">Poder Total 280+</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="stat-chip" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-epico), 0.92), rgba(var(--rareza-rgb-raro), 0.92));">Riesgo Controlado</span>
                        <span class="text-xs uppercase tracking-[0.2em] text-slate-400">Alertas integradas</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="stat-chip" style="background: linear-gradient(135deg, rgba(var(--rareza-rgb-poco-comun), 0.92), rgba(var(--rareza-rgb-comun), 0.92));">Combo Accesorios</span>
                        <span class="text-xs uppercase tracking-[0.2em] text-slate-400">+80 sinergias</span>
                    </li>
            <p class="font-orbitron text-sm uppercase text-arcade-magenta">Explorá el catálogo</p>
            <h3 class="mt-3 text-2xl font-semibold text-white">Más de 20 duendes en stock</h3>
            <p class="mt-3 text-sm text-slate-300">
                Filtrá por rareza, elemento, precio o nivel de suerte. Calculamos automáticamente el poder total y el índice de éxito recomendado para cada misión.
            </p>
            <a href="<?php echo url('catalogo'); ?>" class="mt-5 inline-flex text-sm uppercase tracking-[0.2em] text-arcade-cyan hover:text-arcade-gold">Ver Duendes →</a>
        </article>
        <article class="neon-card p-6">
            <p class="font-orbitron text-sm uppercase text-arcade-magenta">Aprendé rituales</p>
            <h3 class="mt-3 text-2xl font-semibold text-white">Crónicas del Bosque</h3>
            <p class="mt-3 text-sm text-slate-300">
                Descubrí cómo preparar tu espacio, activar accesorios y combinar elementos sin activar alertas de riesgo.
            </p>
            <a href="<?php echo url('blog'); ?>" class="mt-5 inline-flex text-sm uppercase tracking-[0.2em] text-arcade-cyan hover:text-arcade-gold">Ir al Blog →</a>
        </article>
        <article class="neon-card p-6">
            <p class="font-orbitron text-sm uppercase text-arcade-magenta">Nivelá tus stats</p>
            <h3 class="mt-3 text-2xl font-semibold text-white">¿Cómo elegir tu power-up?</h3>
            <ul class="mt-4 space-y-3 text-sm text-slate-300">
                <li>• Definí si buscás fortuna, protección o inspiración.</li>
                <li>• Revisá rareza, elemento y compatibilidad con accesorios.</li>
                <li>• Observá advertencias y nivel de riesgo recomendado.</li>
            </ul>
            <a href="<?php echo url('contacto'); ?>" class="mt-5 inline-flex text-sm uppercase tracking-[0.2em] text-arcade-cyan hover:text-arcade-gold">Consultanos →</a>
        </article>
    </div>
</section>

<section class="mt-14 panel-glass p-8">
    <h2 class="font-orbitron text-2xl text-white">¿Por qué adoptar un duende?</h2>
    <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div>
            <p class="text-xl font-semibold text-arcade-gold">Fortuna</p>
            <p class="mt-2 text-sm text-slate-300">Duendes del oro que atraen oportunidades, créditos y loot inesperado.</p>
        </div>
        <div>
            <p class="text-xl font-semibold text-arcade-gold">Protección</p>
            <p class="mt-2 text-sm text-slate-300">Guardianes que vigilan entradas y generan barreras luminosas.</p>
        </div>
        <div>
            <p class="text-xl font-semibold text-arcade-gold">Inspiración</p>
            <p class="mt-2 text-sm text-slate-300">Power-ups solares que potencian la creatividad y la confianza.</p>
        </div>
        <div>
            <p class="text-xl font-semibold text-arcade-gold">Equilibrio</p>
            <p class="mt-2 text-sm text-slate-300">Sanadores que estabilizan emociones y sincronizan tu energía.</p>
        </div>
    </div>
    <p class="mt-8 text-xs uppercase tracking-[0.2em] text-slate-400">Cada duende incluye guía de cuidados, advertencias específicas y garantía de satisfacción de 30 días.</p>
</section>
