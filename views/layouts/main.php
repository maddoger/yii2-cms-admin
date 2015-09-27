<?php
/**
 * @var yii\web\View $this
 * @var string $content
 */
use yii\widgets\Breadcrumbs;

$this->beginContent(__DIR__ . '/base.php');
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?= $this->title ?></h1>
    <?= Breadcrumbs::widget([
       'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
     ]); ?>
</section>

<!-- Main content -->
<section class="content">
    <?= $content ?>
</section><!-- /.content -->

<?php $this->endContent(); ?>
