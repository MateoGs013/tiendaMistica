<?php
require_once __DIR__ . '/includes/header.php';
?>

<div class="space-y-10">
	<section class="panel-glass relative overflow-hidden rounded-3xl border border-arcade-cyan/35 p-8 shadow-neon">
		<div class="absolute -top-10 -right-10 h-48 w-48 rounded-full bg-arcade-magenta/25 blur-3xl"></div>
		<div class="absolute -bottom-12 -left-12 h-52 w-52 rounded-full bg-arcade-cyan/20 blur-3xl"></div>
		<div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
			<div class="max-w-3xl space-y-4">
				<p class="font-retro text-[0.65rem] uppercase tracking-[0.4em] text-arcade-gold">Sistema Arcade</p>
				<h1 class="text-3xl font-semibold text-white md:text-4xl">Panel de administración</h1>
				<p class="text-slate-300">Controlá el inventario de duendes, ajustá sus habilidades mágicas, curá la biblioteca de blogs y respondé a las señales de clientes directamente desde esta consola bestial.</p>
			</div>
			<div class="panel-glass w-full max-w-sm rounded-2xl border border-arcade-magenta/40 p-6 text-center shadow-neon">
				<p class="font-orbitron text-xs uppercase tracking-[0.35em] text-arcade-magenta">Modo operativo</p>
				<p class="mt-4 text-2xl font-semibold text-white">Todo listo</p>
				<p class="mt-2 text-sm text-slate-300">Levanta cada switch y mantené la energía arcana fluída.</p>
				<a href="/tienda_mistica/" class="button-arcade mt-6 w-full justify-center">Volver a la tienda</a>
			</div>
		</div>
	</section>

	<section class="space-y-4">
		<h2 class="font-orbitron text-sm uppercase tracking-[0.3em] text-arcade-magenta">Módulos del sistema</h2>
		<div class="grid-auto-fit">
			<a href="<?php echo admin_url('duendes'); ?>" class="neon-card relative overflow-hidden rounded-2xl border border-arcade-cyan/35 p-6 shadow-neon transition-transform hover:-translate-y-1">
				<div class="absolute right-4 top-4 text-arcade-cyan">⚙️</div>
				<p class="font-orbitron text-sm uppercase tracking-[0.25em] text-arcade-magenta">Duendes</p>
				<h3 class="mt-2 text-xl font-semibold text-white">Hojas de personaje</h3>
				<p class="mt-3 text-sm text-slate-300">Creá, editá o retirate duendes. Ajustá rarezas, elementos, precios y habilidades para tenerlos listos para la vitrina.</p>
			</a>

			<a href="<?php echo admin_url('blogs'); ?>" class="neon-card relative overflow-hidden rounded-2xl border border-arcade-cyan/35 p-6 shadow-neon transition-transform hover:-translate-y-1">
				<div class="absolute right-4 top-4 text-arcade-magenta">📝</div>
				<p class="font-orbitron text-sm uppercase tracking-[0.25em] text-arcade-magenta">Blog</p>
				<h3 class="mt-2 text-xl font-semibold text-white">Crónicas místicas</h3>
				<p class="mt-3 text-sm text-slate-300">Publicá nuevas historias, actualizá notas y mantené iluminada a la comunidad con conocimiento arcano.</p>
			</a>

			<a href="<?php echo admin_url('pedidos'); ?>" class="neon-card relative overflow-hidden rounded-2xl border border-arcade-cyan/35 p-6 shadow-neon transition-transform hover:-translate-y-1">
				<div class="absolute right-4 top-4 text-arcade-gold">📦</div>
				<p class="font-orbitron text-sm uppercase tracking-[0.25em] text-arcade-magenta">Pedidos</p>
				<h3 class="mt-2 text-xl font-semibold text-white">Logística dimensional</h3>
				<p class="mt-3 text-sm text-slate-300">Revisá órdenes, actualizá estados y asegurate de que cada duende llegue a su nuevo portal sin retrasos.</p>
			</a>

			<a href="<?php echo admin_url('contactos'); ?>" class="neon-card relative overflow-hidden rounded-2xl border border-arcade-cyan/35 p-6 shadow-neon transition-transform hover:-translate-y-1">
				<div class="absolute right-4 top-4 text-arcade-violet">✉️</div>
				<p class="font-orbitron text-sm uppercase tracking-[0.25em] text-arcade-magenta">Contactos</p>
				<h3 class="mt-2 text-xl font-semibold text-white">Señales entrantes</h3>
				<p class="mt-3 text-sm text-slate-300">Respondé mensajes, organizá consultas y mantené la reputación mágica en alto con respuestas veloces.</p>
			</a>

			<a href="<?php echo admin_url('usuarios'); ?>" class="neon-card relative overflow-hidden rounded-2xl border border-arcade-cyan/35 p-6 shadow-neon transition-transform hover:-translate-y-1">
				<div class="absolute right-4 top-4 text-arcade-magenta">👥</div>
				<p class="font-orbitron text-sm uppercase tracking-[0.25em] text-arcade-magenta">Usuarios</p>
				<h3 class="mt-2 text-xl font-semibold text-white">Tripulación</h3>
				<p class="mt-3 text-sm text-slate-300">Gestioná roles de la nave y mantené actualizado el registro de guardianes que operan la tienda mística.</p>
			</a>
		</div>
	</section>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
