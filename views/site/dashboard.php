<?php

/* @var $this yii\web\View */
/** @var $menu array */
/** @var $messages \maddoger\core\models\Log[] */

use maddoger\admin\Module;
use maddoger\admin\widgets\Menu;
use yii\helpers\Html;

$this->title = Yii::t('maddoger/admin', 'Dashboard');

?>
<div class="dashboard">
    <?= Menu::widget([
        'items' => $menu,
        'activateParents' => true,
        'labelTemplate' => '<a href="#">{icon}{label}</a>',
        'submenuTemplate' => "\n<ul class=\"menu\">\n{items}\n</ul>\n",
        'submenuItemClass' => 'treeview',
        'options' => [
            'class' => 'dashboard-menu',
        ],
    ]);
    ?>

    <?php if ($messages !== false) { ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-warning"></i>&nbsp;<?= Yii::t('maddoger/admin',
                        'Log') ?>
                    <small><?= Html::a(Yii::t('maddoger/admin', 'more info'), ['log/index']) ?></small>
                </h3>
            </div>
            <!-- /.panel-header -->
            <div class="panel-body">
                <?php
                if ($messages) {
                    foreach ($messages as $message) {
                        $options = [
                            'class' => 'callout'
                        ];
                        $level = $message->getLevelName();
                        if ($level) {
                            if ($level == 'error') {
                                $level = 'danger';
                            }
                            Html::addCssClass($options, 'callout-' . $level);
                        }
                        echo Html::tag('div',
                                Html::tag('span', $message->getTitle()).'<br/>'.
                                Html::tag('span', Yii::$app->formatter->asDatetime($message->log_time),
                                ['class' => 'small']).
                                Html::a(Yii::t('maddoger/admin', 'more info'), ['log/view', 'id' => $message->id], ['class' => 'pull-right']),
                            $options
                        );
                    }
                } else {
                    echo '<p class="text-muted">' . Yii::t('maddoger/admin', 'No messages found.') . '</p>';
                }
                ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    <?php } ?>
</div>