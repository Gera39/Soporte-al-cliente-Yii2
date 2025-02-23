<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

$this->registerCssFile('@web/css/estilos_layout.css');
$assetDir = Yii::$app->assetManager->getPublishedUrl('@app/assets');
$this->registerJsFile('@web/js/main_panel.js');
$this->registerCssFile('https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css');
$this->registerCsrfMetaTags();
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
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Sidebar -->
<?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>
<!-- /.Sidebar -->
    <section id="content">

        <!-- navbar -->
        <?= $this->render('header', ['assetDir' => $assetDir]) ?>
        <!-- /.navbar -->

        <div id="main-content">
        <?= $content?>
        </div>
    </section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
