<?php

/**
 * @var $this yii\web\View
 * @var string $content
 */
use maddoger\admin\Module;
use maddoger\admin\widgets\SearchForm;
use yii\helpers\Html;

/**
 * @var \maddoger\admin\Module $adminModule
 */
$adminModule = Module::getInstance();
?>
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <?php
        /**
         * @var \maddoger\admin\models\User $user
         */
        $user = Yii::$app->user->getIdentity();
        ?>
        <div class="pull-left image">
            <?= $user && isset($user->avatar) && !empty($user->avatar) ? Html::img($user->avatar,
                ['class' => 'img-circle', 'alt' => Yii::t('maddoger/admin', 'Avatar')]) : '' ?>
        </div>
        <div class="pull-left info">
            <p><?= $user ? Yii::t('maddoger/admin', 'Hello<br />{username}', ['username' => Html::encode($user->getName())]) : '' ?></p>
        </div>
    </div>

<?= SearchForm::widget([
    'options' => [
        'class' => 'sidebar-form',
    ],
    'clientOptions' => [
        'width' => 228,
    ],
]) ?>

<?= $this->render($adminModule->sidebarMenuView) ?>