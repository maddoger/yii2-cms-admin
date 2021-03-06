<?php

/**
 * @var $this yii\web\View
 * @var string $content
 */
use maddoger\admin\Module;
use maddoger\admin\widgets\Alerts;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->params['bodyClass'] = 'skin-blue';

/**
 * @var \maddoger\admin\Module $adminModule
 */
$adminModule = Module::getInstance();

//Logo text
$logo = $adminModule->logoText ?: Yii::$app->name;

if ($adminModule->logoImageUrl) {
    $logo = Html::img($adminModule->logoImageUrl, ['alt' => $logo, 'class' => 'img-responsive']);
}

$this->beginContent('@maddoger/admin/views/layouts/base.php');
?>
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?= Yii::$app->getHomeUrl() ?>" class="logo">
                <?= $logo ?>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"><?= Yii::t('maddoger/admin', 'Toggle navigation') ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?= $this->render($adminModule->headerNotificationsView); ?>
                        <?= $this->render($adminModule->headerUserView); ?>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <?= $this->render($adminModule->sidebarView); ?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <?php if (isset($this->blocks['header'])): ?>
                    <?= $this->blocks['header'] ?>
                <?php else: ?>
                    <h1><?= Html::encode($this->title, false) ?></h1>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]); ?>
                <?php endif; ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?php echo Alerts::widget() ?>
                <?= $content ?>
            </section>

        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <?= $this->render($adminModule->footerView); ?>
        </footer>

    </div><!-- ./wrapper -->
<?php
$this->endContent();