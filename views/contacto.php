<?php
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
$oldNombre = $_SESSION['old_nombre'] ?? '';
$oldEmail = $_SESSION['old_email'] ?? '';
$oldMensaje = $_SESSION['old_mensaje'] ?? '';

unset($_SESSION['success'], $_SESSION['error'], $_SESSION['old_nombre'], $_SESSION['old_email'], $_SESSION['old_mensaje']);
?>
<section class="panel-glass overflow-hidden">
    <div class="px-6 py-8 lg:px-10">
        <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Consola de comunicación</p>
        <h1 class="mt-3 font-orbitron text-3xl text-white">Contacto &amp; bendiciones</h1>
        <p class="mt-2 text-sm text-slate-300">Enviá tu mensaje para recibir asistencia mágica personalizada. Te respondemos con la velocidad de un rayo de neón.</p>
    </div>
</section>

<?php if ($success): ?>
    <div class="mt-6 rounded-lg border border-emerald-400/50 bg-emerald-500/15 p-4 text-sm text-emerald-200 shadow-neon">
        ✓ <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="mt-6 rounded-lg border border-rose-500/50 bg-rose-500/15 p-4 text-sm text-rose-200 shadow-neon">
        ✗ <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="post" action="/tienda_mistica/actions/contacto_acc.php" class="mt-8 space-y-5 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon">
    <div class="grid gap-4 md:grid-cols-2">
        <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
            Nombre completo*
            <input type="text" name="nombre" required value="<?php echo htmlspecialchars($oldNombre); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
        </label>
        <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
            Email de contacto*
            <input type="email" name="email" required value="<?php echo htmlspecialchars($oldEmail); ?>" class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none">
        </label>
    </div>
    <label class="text-xs uppercase tracking-[0.2em] text-slate-300">
        Mensaje*
        <textarea name="mensaje" rows="6" required class="mt-1 w-full rounded-lg border border-arcade-cyan/30 bg-arcade-base/80 px-3 py-2 text-slate-100 focus:border-arcade-magenta/60 focus:outline-none"><?php echo htmlspecialchars($oldMensaje); ?></textarea>
    </label>
    <p class="text-xs uppercase tracking-[0.18em] text-slate-400">Te responderemos en menos de 24 horas con recomendaciones personalizadas de power-ups.</p>
    <button type="submit" class="button-arcade px-6 py-3 text-xs">Enviar mensaje</button>
</form>
