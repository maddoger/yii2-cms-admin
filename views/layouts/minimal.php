<?php

/**
 * @var $this yii\web\View
 * @var string $content
 */

use maddoger\admin\widgets\Alerts;

if (!isset($this->params['bodyClass'])) {
    $this->params['bodyClass'] = '';
}
$this->params['bodyClass'] .= ' minimal-box-page';

?>
<?php $this->beginContent('@maddoger/admin/views/layouts/base.php'); ?>
    <div class="minimal-box">
        <div class="minimal-box-logo">
            <?= Yii::$app->name ?>
        </div>
        <div class="minimal-box-body">
            <?php echo Alerts::widget() ?>
            <?php echo \yii\widgets\Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]); ?>
            <?= $content; ?>
        </div>
    </div>
<?php $this->endContent(); ?>