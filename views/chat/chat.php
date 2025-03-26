<?php

use yii\helpers\Html;

$mensajes = $ticket->getMensajesTickets()->where(['id_ticket' => $ticket->id])->all();
$rol = Yii::$app->user->identity->role;
$titulo = 'Mensajes';
?>


<main id="mainChat">
    <div class="head-title">
        <div class="left mb-3">
            <h1><?= $titulo ?></h1>
        </div>
    </div>

    <div id="chat">
        <?= $this->render('conversaciones', ['tickets' => $tickets]); ?>


        <section id="conversacion" style="border:none;">
            <?php if ($ticket->estado_ticket === 'Pendiente' && Yii::$app->user->identity->role !== 'admin'): ?>
                <div class="d-flex justify-content-around m-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#myModalReporte" class="btn btn-danger " style='width:200px;'><i class='bx bx-alarm-exclamation'></i>Levantar Reporte</a>
                    <?php if ($rol === 'cliente'): ?>
                        <button onclick="mostrarAlertaTicket(<?= $ticket->id ?>)" class="btn btn-success">Cerrar Ticket</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?= $this->render('_mensajes', ['mensajes' => $mensajes , 'rol' => $rol]) ?>
            <?php if(Yii::$app->user->identity->role !== 'admin'):?>
                <?php if ($ticket->estado_ticket === 'Resuelto' || $ticket->estado_ticket === 'En proceso'): ?>
                <div class="alert alert-success h-20 text-dark text-center">Ticket Cerrado</div>
            <?php else: ?>
                <section id="botonesMensajes">
                    <input type="text" placeholder="Escribe tu mensaje aquí" id="msj" name="msj">
                    <button
                        id="enviarBtn"
                        data-id-ticket="<?= $ticket->id ?>"
                        data-id-remitente="<?= Yii::$app->user->identity->id ?>"
                        data-tipo-remitente="<?= Yii::$app->user->identity->role ?>">Enviar</button>
                </section>
            <?php endif; ?>
            <?php endif;?>
        </section>
    </div>
</main>
<?= $this->render('_modal_reporte', ['reporteForm' => $reporteForm, 'id_ticket' => $ticket->id, 'id_cliente' => $ticket->id_cliente, 'id_operador' => $ticket->id_operador]) ?>

<?php

$cm = Yii::$app->request->csrfParam;
$v =  Yii::$app->request->csrfToken;
$script = <<<JS
    function actualizarMensajes(){
        $.ajax({
            url:'index.php?r=chat/actualizar-mensajes&id=' +$ticket->id  ,
            type:'GET',
            success:function(response){
                $('#mensajes').html(response);
            },
            
        });
    }
    // setInterval(actualizarMensajes,5000);
    $('#enviarBtn').click(function(){
        let mensaje = document.getElementById('msj');
        let mensajes = document.getElementById('mensajes');
        
        let id_t = $(this).data('idTicket');
        let id_remitente = $(this).data('idRemitente');
        let tipo_remitente = $(this).data('tipoRemitente');
       
        $.ajax({
    url: 'index.php?r=chat/guardar',
    type: 'POST',
    data: {
        ticket: id_t,
        remitente: id_remitente,
        tipo_remitente: tipo_remitente,
        mensaje: mensaje.value,
        '$cm': '$v'
    },
    success: function(response) {
        if (response.success) {
            let divNuevo = document.createElement('div');
            let leido = document.createElement('p');
            leido.classList.add('text','text-danger');
            leido.innerText = 'No leido';
            divNuevo.classList.add('alert', 'alert-primary', 'chat', 'own');
            divNuevo.innerText = mensaje.value;
            document.getElementById('mensajes').appendChild(divNuevo);
            divNuevo.appendChild(leido);
            mensaje.value = '';
        } else {
            alert('Error: ' + response.message);
        }
    },
    error: function(xhr, status, error) {
        console.error('Error AJAX:', xhr.responseText);
        alert('Error en la petición: ' + xhr.responseText +error.responseText);
    }
});

    });
JS;

$this->registerJs($script);
?>