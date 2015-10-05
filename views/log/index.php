<?php

/* @var yii\web\View $this */
/* @var maddoger\admin\models\search\LogSearch $model */
/* @var yii\data\ActiveDataProvider $dataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\log\Logger;

$this->title = Yii::t('maddoger/admin', 'Log');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-system-messages">
    <div class="panel panel-info">
        <div class="panel-body">
            <div class="table-responsive">

                <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $model,
                'rowOptions' => function ($model, $key, $index, $grid) {
                    switch ($model['level']) {
                        case Logger::LEVEL_ERROR : return ['class' => 'danger'];
                        case Logger::LEVEL_WARNING : return ['class' => 'warning'];
                        case Logger::LEVEL_INFO : return ['class' => 'success'];
                        default: return [];
                    }
                },
                'columns' => [
                    //'id',
                    [
                        'attribute' => 'log_time',
                        'value' => function ($data) {
                            $timeInSeconds = $data['log_time'];
                            $millisecondsDiff = (int) (($timeInSeconds - (int) $timeInSeconds) * 1000);
                            return date('Y-m-d - H:i:s.', $timeInSeconds) . sprintf('%03d', $millisecondsDiff);
                        },
                        'headerOptions' => [
                            'class' => 'sort-numerical'
                        ],
                        'filter' => [
                            '-1 minute' => Yii::t('maddoger/admin', 'Last minute'),
                            '-1 hour' => Yii::t('maddoger/admin', 'Last hour'),
                            '-1 day' => Yii::t('maddoger/admin', 'Last day'),
                            '-1 week' => Yii::t('maddoger/admin', 'Last week'),
                            '-1 month' => Yii::t('maddoger/admin', 'Last month'),
                        ],
                    ],
                    [
                        'attribute' => 'level',
                        'value' => function ($data) {
                            return Logger::getLevelName($data['level']);
                        },
                        'filter' => [
                            Logger::LEVEL_TRACE => ' Trace ',
                            Logger::LEVEL_INFO => ' Info ',
                            Logger::LEVEL_WARNING => ' Warning ',
                            Logger::LEVEL_ERROR => ' Error ',
                        ],
                    ],
                    [
                        'attribute' => 'prefix',
                        'value' => function ($model, $key, $index, $column) {
                            return Html::a(Html::encode($model->prefix), ['view', 'id' => $model->id], ['title' => Yii::t('maddoger/admin', 'More info')]);
                        },
                        'format' => 'html',
                    ],
                    'category',
                    [
                        'attribute' => 'message',
                        'value' => function ($data) {
                            return Html::encode(
                                stristr($data['message'], 'Stack trace', true) ?:
                                    substr($data['message'], 0, 200)
                            );
                        },
                        'format' => 'html',
                        'options' => [
                            'width' => '50%',
                        ],
                    ],
                ],
            ]) ?>
            </div>

            <p class="text-right">
                <?= Html::a(Yii::t('maddoger/admin', 'Delete all'), ['delete-all'], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('maddoger/admin', 'Are you sure you want to delete all items?'),
                        'method' => 'post',
                    ]
                ]) ?>
            </p>
        </div>
    </div>
</div>