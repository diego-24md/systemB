<?= $this->extend('Biblioteca/layout') ?>

<?= $this->section('titulo') ?>Notificaciones<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    .notif-page {
        max-width: 700px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .notif-page-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--ink);
    }

    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notif-card {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: #fff;
        border: 0.5px solid var(--border);
        border-radius: 12px;
        padding: 14px 16px;
    }

    .notif-card.aceptado {
        border-left: 3px solid #1D9E75;
    }

    .notif-card.rechazado {
        border-left: 3px solid #E24B4A;
    }

    .notif-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .notif-icon.aceptado {
        background: #E1F5EE;
        color: #0F6E56;
    }

    .notif-icon.rechazado {
        background: #FCEBEB;
        color: #A32D2D;
    }

    .notif-body {
        flex: 1;
    }

    .notif-mensaje {
        font-size: 14px;
        color: var(--ink);
        line-height: 1.5;
        margin-bottom: 4px;
    }

    .notif-fecha {
        font-size: 12px;
        color: var(--ink-light);
    }

    .notif-vacio {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--ink-light);
    }

    .notif-vacio i {
        font-size: 40px;
        margin-bottom: 12px;
        display: block;
    }

    .notif-vacio p {
        font-size: 14px;
    }

    @media (max-width: 767px) {
        .notif-page {
            margin: 1rem auto;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('contenido') ?>

<div class="notif-page">
    <p class="notif-page-title">
        <i class="fas fa-bell"></i> Notificaciones
    </p>

    <?php if (empty($notificaciones)): ?>
        <div class="notif-vacio">
            <i class="fa-regular fa-bell"></i>
            <p>No tienes notificaciones aún.</p>
        </div>
    <?php else: ?>
        <div class="notif-list">
            <?php foreach ($notificaciones as $n): ?>
                <div class="notif-card <?= esc($n['tipo']) ?>">
                    <div class="notif-icon <?= esc($n['tipo']) ?>">
                        <?php if ($n['tipo'] === 'aceptado'): ?>
                            <i class="fas fa-check"></i>
                        <?php else: ?>
                            <i class="fas fa-xmark"></i>
                        <?php endif; ?>
                    </div>
                    <div class="notif-body">
                        <p class="notif-mensaje"><?= esc($n['mensaje']) ?></p>
                        <p class="notif-fecha">
                            <i class="fas fa-clock"></i>
                            <?= date('d/m/Y H:i', strtotime($n['created_at'])) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>