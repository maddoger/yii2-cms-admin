<?php

/* @var yii\web\View $this */
/* @var yii\data\ActiveDataProvider $dataProvider */
/* @var maddoger\core\models\Log $model */

use yii\helpers\Html;
use yii\helpers\VarDumper;

$this->title = Yii::t('maddoger/admin', 'System message #{id}', ['id' => $model->id]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('maddoger/admin', 'System messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="system-messages-view">
    <div class="panel panel-info">
        <div class="panel-body">
            <p class="pull-right">
                <?= Html::a(Yii::t('maddoger/admin', 'Back'), Yii::$app->request->referrer?:['log'], [
                    'class' => 'btn btn-info',
                ]) ?>
                &nbsp;&nbsp;
                <?= Html::a(Yii::t('maddoger/admin', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('maddoger/admin', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ]
                ]) ?>
            </p>
            <dl class="dl-horizontal">
                <dt><?= Yii::t('maddoger/admin', 'Created at') ?></dt>
                <dd><?= Yii::$app->formatter->asDatetime($model->log_time, 'long') ?></dd>
                <dt><?= Yii::t('maddoger/admin', 'Prefix') ?></dt>
                <dd><?= Yii::$app->formatter->asHtml($model->prefix) ?></dd>
                <dt><?= Yii::t('maddoger/admin', 'Level') ?></dt>
                <dd><?= Yii::$app->getLog()->getLogger()->getLevelName($model->level) ?></dd>
                <dt><?= Yii::t('maddoger/admin', 'Message') ?></dt>
                <dd><pre><?= Html::encode($model->message) ?></pre></dd>
            </dl>
        </div>
    </div>
</div>