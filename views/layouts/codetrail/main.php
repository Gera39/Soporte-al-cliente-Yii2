<?php

use app\models\User;

if(Yii::$app->user->isGuest){
    Yii::$app->session->setFlash('error', 'Debes de iniciar sesion, regresa al login');
    Yii::$app->response->redirect(['panel/notfound'])->send();
    Yii::$app->end();
}

if (User::getEstadoUsuario()) {
    Yii::$app->session->setFlash('error', 'Estas bloqueado por el administrador');
    Yii::$app->response->redirect(['panel/notfound'])->send();
    Yii::$app->end();
}


/** @var yii\web\View $this */
/** @var string $content */
$theme = Yii::$app->request->cookies->getValue('theme', 'light');

$this->registerCssFile('@web/css/estilos_layout.css');
$assetDir = Yii::$app->assetManager->getPublishedUrl('@app/assets');
$this->registerJsFile('@web/js/main_panel.js');

$this->registerCssFile('https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css');
$this->registerCsrfMetaTags();
$this->registerCssFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);

$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
// $this->title = 'Login';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <meta name="csrf-param" content="<?= Yii::$app->request->csrfParam ?>">
    <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">

    <?php $this->head() ?>
</head>

<body class="<?= $theme === 'dark' ? 'dark' : '' ?>">
    <?php $this->beginBody() ?>
    <!-- Sidebar -->
    <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>
    <!-- /.Sidebar -->
    <section id="content">

        <!-- navbar -->
        <?= $this->render('header', ['assetDir' => $assetDir]) ?>
        <!-- /.navbar -->
        <div id="main-content">
            <?= $content ?>
        </div>
    </section>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>