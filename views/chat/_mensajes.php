<section id="mensajes">
    <?php if ($rol === 'cliente'): ?>
        <div class="alert alert-success chat received">
            <p>Este mensaje se genera de manera automatica le solicitamos que espere un momento en lo que se conecta el Operador a cargo </p>
        </div>
    <?php endif; ?>

   <?php if($rol !== 'admin'):?>
    <?php foreach ($mensajes as $m):?>
        <?php if ($m->tipo_remitente == ucfirst($rol)): ?>
            <div class="alert alert-primary chat own">
                 <?= $m->mensaje ?>
                <?php
                $leido = (($m->leido === 0) ? 'No leido' : 'Visto');
                ?>
                <p class='text text-<?= (($leido === 'Visto') ? 'success' : 'danger') ?>'><?= $leido ?></p>
            </div>
        <?php elseif ($m->tipo_remitente !== $rol): ?>
            <div class="alert alert-success chat received">
                <p> <?= $m->mensaje ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php else:?>
        <?php foreach ($mensajes as $m):?>
        <?php if ($m->tipo_remitente == 'Cliente'): ?>
            <div class="alert alert-primary chat own">
                 <?= $m->mensaje ?>
                <?php
                $leido = (($m->leido === 0) ? 'No leido' : 'Visto');
                ?>
                <p class='text text-<?= (($leido === 'Visto') ? 'success' : 'danger') ?>'><?= $leido ?></p>
            </div>
        <?php elseif ($m->tipo_remitente !== 'Cliente'): ?>
            <div class="alert alert-success chat received">
                <p> <?= $m->mensaje ?></p>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php endif;?>

</section>