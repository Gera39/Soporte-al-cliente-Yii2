<?php

if (Yii::$app->session->hasFlash('error')) {
    $mensaje = Yii::$app->session->getFlash('error');
} else {
    $mensaje = 'Errocito';
}

Yii::$app->session->removeFlash('error');

?>


<main>
    <div class="notfound">
        <div class="notfound-404">
            <h1>404</h1>
        </div>
        <h2>Oops! <?= $mensaje?></h2>
        <?php if($mensaje == 'Pagina no encontrada'):?>
        <p>Lo sentimos, pero la página que buscas no existe, se ha eliminado, se ha cambiado de nombre o no está disponible temporalmente.</p>
        <?php else:?>
        <p>Lo sentimos, necesitas hablar con el administrador.</p>
            <?php endif;?>
        <img src="<?= Yii::getAlias('@web')?>/images/warning.svg" style="width:300px;" alt="imagen_warning">
        <a href="<?= Yii::$app->homeUrl ?>" class="btn btn-success m-5">Volver al login</a>
    </div>
</main>