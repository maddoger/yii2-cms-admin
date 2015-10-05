<?php
use maddoger\admin\assets\AdminAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAsset::register($this);

$bodyClass = isset($this->params['bodyClass']) ? $this->params['bodyClass'] : '';
$this->title = (empty($this->title) ? '' : $this->title.' :: ').Yii::$app->name;

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="<?= $bodyClass ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title, false) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= $bodyClass ?>">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();