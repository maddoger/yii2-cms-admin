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
         * @var \maddoger\user\common\models\User $user
         */
        $user = Yii::$app->user->getIdentity();

        if ($user && isset($user->avatar) && !empty($user->avatar)) {
            echo Html::tag(
                'div',
                Html::a(Html::img($user->avatar,
                    ['class' => 'img-circle', 'alt' => Yii::t('maddoger/admin', 'Avatar')]),
                ['/user/user/profile']),
                ['class' => 'pull-left image']
                );
        }
        ?>
        <div class="pull-left info">
            <?php
            if ($user) {
                echo Html::a(
                    Yii::t('maddoger/admin', 'Hello<br />{username}', ['username' => Html::encode($user->getName())]),
                    ['/user/user/profile']);
            }
            ?>
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