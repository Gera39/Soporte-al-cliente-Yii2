<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\widgets\Pjax;
use yii\bootstrap5\NavBar;

$this->registerCssFile('@web/css/estilos_layout.css');
// $assetDir = Yii::$app->assetManager->getPublishedUrl('@app/assets');
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- Sidebar -->
<?= $this->render('codetrail/sidebar') ?>
<!-- /.Sidebar -->
    <section id="content">

        <!-- navbar -->
        <?= $this->render('codetrail/header') ?>
        <!-- /.navbar -->
        <div id="main-content">
        
        <?= $content?>
        
        </div>
    </section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
