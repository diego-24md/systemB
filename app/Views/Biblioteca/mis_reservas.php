<?= $this->extend('Biblioteca/layout') ?>

<?= $this->section('titulo') ?>Mis Reservas<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="notif-page">
    <p class="notif-page-title">
        <i class="fas fa-clipboard-list"></i> Mis reservas
    </p>

    <?php if (empty($reservas)): ?>
        <div class="notif-vacio">
            <i class="fa-regular fa-clipboard"></i>
            <p>Aún no tienes reservas.</p>
        </div>
    <?php else: ?>
        <div class="notif-list">
            <?php foreach ($reservas as $r): ?>
                <?php
                $estado = $r['estado'];
                $iconos = [
                    'pendiente' => ['icon' => 'fa-clock',       'clase' => 'pendiente'],
                    'activo'    => ['icon' => 'fa-check',       'clase' => 'aceptado'],
                    'devuelto'  => ['icon' => 'fa-rotate-left', 'clase' => 'devuelto'],
                    'rechazado' => ['icon' => 'fa-xmark',       'clase' => 'rechazado'],
                ];
                $info = $iconos[$estado] ?? ['icon' => 'fa-circle', 'clase' => 'pendiente'];
                ?>
                <div class="notif-card <?= $info['clase'] ?>">
                    <div class="notif-icon <?= $info['clase'] ?>">
                        <i class="fas <?= $info['icon'] ?>"></i>
                    </div>
                    <div class="notif-body">
                        <p class="notif-mensaje"><?= esc($r['titulo']) ?></p>
                        <p class="notif-fecha">
                            <i class="fas fa-calendar"></i>
                            Reservado el <?= date('d/m/Y', strtotime($r['entrega'])) ?>
                            <?php if ($r['devolucion']): ?>
                                &nbsp;·&nbsp;
                                <i class="fas fa-rotate-left"></i>
                                Devuelto el <?= date('d/m/Y', strtotime($r['devolucion'])) ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    <span class="reserva-estado <?= $info['clase'] ?>">
                        <?= ucfirst($estado) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>