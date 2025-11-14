<?php
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
$oldEmail = $_SESSION['old_email'] ?? '';

unset($_SESSION['error'], $_SESSION['success'], $_SESSION['old_email']);
?>
<section class="panel-glass overflow-hidden">
    <div class="px-6 py-8 lg:px-10 text-center">
        <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Portal de ingreso</p>
        <h1 class="mt-3 font-orbitron text-3xl text-white">Accedé a tu consola mística</h1>
        <p class="mt-2 text-sm text-slate-300">Conectate para sincronizar tus duendes, revisar pedidos y continuar tus combos retro.</p>
    </div>
</section>

<?php if ($success): ?>
    <div class="mt-6 rounded-lg border border-arcade-emerald/50 bg-arcade-emerald/15 p-4 text-sm text-arcade-emerald shadow-neon">
        ✓ <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mt-6 rounded-lg border border-arcade-rose/50 bg-arcade-rose/15 p-4 text-sm text-arcade-rose shadow-neon">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="post" action="/tienda_mistica/actions/login_acc.php" class="mt-8 space-y-5 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon max-w-lg mx-auto">
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Email
        <input type="email" name="email" required value="<?php echo htmlspecialchars($oldEmail); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
    </label>
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Contraseña
        <input type="password" name="password" required class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
    </label>
    <button type="submit" class="button-arcade w-full px-6 py-3 text-xs">Ingresar</button>
    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">¿No tenés cuenta? <a href="<?php echo url('registro'); ?>" class="text-arcade-cyan hover:text-arcade-gold">Registrate aquí</a></p>
</form>
