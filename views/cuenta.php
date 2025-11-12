<?php
require_login();
require_once "classes/Pedido.php";
$idUsuario = (int)($_SESSION['usuario']['id_usuario'] ?? 0);
$pedidos = $idUsuario > 0 ? Pedido::porUsuario($idUsuario) : [];
?>
<section class="panel-glass overflow-hidden">
    <div class="px-6 py-8 lg:px-10">
        <p class="font-retro text-xs uppercase tracking-[0.4em] text-arcade-magenta">Consola personal</p>
        <h1 class="mt-3 font-orbitron text-3xl text-white">Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']); ?>.</h1>
        <p class="mt-2 text-sm text-slate-300">Desde aquí podés revisar tus pedidos y seguir la evolución de tus power-ups.</p>
    </div>
</section>

<div class="mt-8 grid gap-6 lg:grid-cols-3">
    <div class="rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon">
        <h2 class="font-orbitron text-lg text-white">Perfil</h2>
        <p class="mt-3 text-sm text-slate-200">Email: <?php echo htmlspecialchars($_SESSION['usuario']['email']); ?></p>
        <p class="mt-1 text-sm text-slate-200">Rol: <?php echo htmlspecialchars($_SESSION['usuario']['rol']); ?></p>
        <p class="mt-1 text-sm text-slate-200">ID jugador: #<?php echo $idUsuario; ?></p>
        <a href="<?php echo url('logout'); ?>" class="mt-4 inline-flex button-arcade px-4 py-2 text-xs" style="background: linear-gradient(135deg, rgba(217,70,239,0.35), rgba(240,82,82,0.45));">Cerrar sesión</a>
    </div>
    <div class="lg:col-span-2 rounded-2xl border border-arcade-cyan/30 bg-arcade-panel/70 p-6 shadow-neon">
        <h2 class="font-orbitron text-lg text-white">Mis pedidos</h2>
        <?php if (empty($pedidos)): ?>
            <p class="mt-4 text-sm text-slate-300">Aún no registramos pedidos. Volvé al <a class="text-arcade-cyan hover:text-arcade-gold" href="<?php echo url('catalogo'); ?>">catálogo</a> y desbloqueá tu primer combo.</p>
        <?php else: ?>
            <div class="mt-4 overflow-x-auto rounded-xl border border-arcade-cyan/25">
                <table class="min-w-full text-sm text-slate-200">
                    <thead class="bg-arcade-panel/80 text-xs uppercase tracking-[0.2em] text-arcade-magenta">
                        <tr>
                            <th class="px-4 py-3 text-left">Pedido</th>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Total</th>
                            <th class="px-4 py-3 text-left">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr class="border-t border-arcade-cyan/15">
                                <td class="px-4 py-3">#<?php echo $pedido['id_pedido']; ?></td>
                                <td class="px-4 py-3"><?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></td>
                                <td class="px-4 py-3 text-arcade-gold"><?php echo number_format($pedido['total'], 2); ?> oro</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full border border-arcade-magenta/30 bg-arcade-base/70 px-3 py-1 text-xs uppercase tracking-[0.2em] text-slate-200"><?php echo htmlspecialchars($pedido['estado']); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
