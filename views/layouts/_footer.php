<?php
use maddoger\admin\Module;

?>
<div class="pull-right hidden-xs">
    <?= Yii::t('maddoger/admin', 'Version') ?>: <?= Yii::$app->version ?>
</div>
<?= Yii::t('maddoger/admin', 'Copyright &copy; {years}, {company}. All rights reserved.',
    ['years' => date('Y'), 'company' => Module::getInstance()->logoText ?: Yii::$app->name]) ?>