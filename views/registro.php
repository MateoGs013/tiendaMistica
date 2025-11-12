<?php
$error = $_SESSION['error'] ?? null;
$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_email']);
?>
<section class="panel-glass overflow-hidden">
    <div class="px-6 py-8 lg:px-10 text-center">
        <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Crear player</p>
        <h1 class="mt-3 font-orbitron text-3xl text-white">Registrá tu consola</h1>
        <p class="mt-2 text-sm text-slate-300">Sumate para guardar favoritos, adoptar duendes y seguir misiones retro desde cualquier arcade.</p>
    </div>
</section>

<?php if ($error): ?>
    <div class="mt-6 rounded-lg border border-rose-500/50 bg-rose-500/15 p-4 text-sm text-rose-200 shadow-neon">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="post" action="/tienda_mistica/actions/registro_acc.php" class="mt-8 space-y-5 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon max-w-lg mx-auto">
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Nombre
        <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldNombre); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
    </label>
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Email
        <input type="email" name="email" required value="<?php echo htmlspecialchars($oldEmail); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
    </label>
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Contraseña (mínimo 6 caracteres)
        <input type="password" name="password" required minlength="6" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
    </label>
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Repetir contraseña
        <input type="password" name="password2" required minlength="6" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
    </label>
    <button type="submit" class="button-arcade w-full px-6 py-3 text-xs">Registrarme</button>
    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">¿Ya tenés cuenta? <a href="<?php echo url('login'); ?>" class="text-arcade-cyan hover:text-arcade-gold">Ingresá aquí</a></p>
</form>
