<?php

/** @var $this \yii\web\View */
use maddoger\widgets\Highcharts;
use yii\helpers\Html;

$this->title = Yii::t('maddoger/admin', 'System information');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="system-information-index">
    <div class="row">
        <div class="col-md-6">
            <?= Highcharts::widget([
                'chartVariable' => 'cpuChart',
                'options' => [
                    'style' => 'width: 100%; height: 200px;',
                ],
                'clientOptions' => [
                    'chart' => [
                        'type' => 'line',
                    ],
                    'title' => [
                        'text' => 'CPU Usage',
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        'tickPixelInterval' => 150,
                        'maxZoom' => 20 * 2000,
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'max' => 100,
                        'title' => [
                            'text' => '%',
                        ],
                    ],
                    'series' => [
                        [
                            'name'=> 'Core 1',
                            'data'=> [],
                        ],
                    ],
                ],
            ]) ?>
            <br />
            <?= Highcharts::widget([
                'chartVariable' => 'memoryChart',
                'options' => [
                    'style' => 'width: 100%; height: 200px;',
                ],
                'clientOptions' => [
                    'chart' => [
                        'type' => 'line',
                    ],
                    'title' => [
                        'text' => 'Memory Usage',
                    ],
                    'xAxis' => [
                        'type' => 'datetime',
                        'tickPixelInterval' => 150,
                        'maxZoom' => 20 * 2000,
                    ],
                    'yAxis' => [
                        'min' => 0,
                        'max' => 100,
                        'title' => [
                            'text' => '%',
                        ],
                    ],
                    'series' => [
                        [
                            'name'=> 'Core 1',
                            'data'=> [],
                        ],
                    ],
                ],
            ]) ?>
            <br />
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-sm-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>80%</h3>
                            CPU Usage
                        </div>
                        <div class="icon">
                            <i class="fa fa-server"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>4000/8000 MB</h3>
                            Memory Usage
                        </div>
                        <div class="icon">
                            <i class="fa fa-bars"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>20 GB</h3>
                            Storage Free space
                        </div>
                        <div class="icon">
                            <i class="fa fa-database"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>190:00:10</h3>
                            Uptime
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="small-box-footer">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-title">
                                <i class="fa fa-hdd-o"></i>
                                <?= Yii::t('maddoger/admin', 'Webserver') ?>
                            </div>
                        </div>
                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt><?= Yii::t('maddoger/admin', 'Software') ?></dt>
                                <dd><?= $_SERVER["SERVER_SOFTWARE"] ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'PHP') ?></dt>
                                <dd><?= Html::a(phpversion(), ['phpinfo'], ['target' => '_blank', 'title' => Yii::t('maddoger/admin', 'Show phpinfo')]) ?></a></dd>

                                <dt><?= Yii::t('maddoger/admin', 'DB') ?></dt>
                                <dd><?= Yii::$app->getDb()->getDriverName() ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'Name') ?></dt>
                                <dd><?= $_SERVER["SERVER_NAME"] ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'IP') ?></dt>
                                <dd><?= $_SERVER["SERVER_ADDR"] ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'Port') ?></dt>
                                <dd><?= $_SERVER["SERVER_PORT"] ?></dd>

                            </dl>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-title">
                                <i class="fa fa-hdd-o"></i>
                                <?= Yii::t('maddoger/admin', 'Time') ?>
                            </div>
                        </div>
                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt><?= Yii::t('maddoger/admin', 'System date') ?></dt>
                                <dd><?= Yii::$app->formatter->asDate(time(), 'long') ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'System time') ?></dt>
                                <dd><?= Yii::$app->formatter->asTime(time(), 'long') ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'Timezone') ?></dt>
                                <dd><?= date_default_timezone_get() ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header">
                            <div class="box-title">
                                <i class="fa fa-hdd-o"></i>
                                <?= Yii::t('maddoger/admin', 'System') ?>
                            </div>
                        </div>
                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt><?= Yii::t('maddoger/admin', 'Processor') ?></dt>
                                <dd>Intel Xeon E3333 x86_64</dd>

                                <dt><?= Yii::t('maddoger/admin', 'OS') ?></dt>
                                <dd><?= php_uname() ?></dd>

                                <dt><?= Yii::t('maddoger/admin', 'Webserver') ?></dt>
                                <dd><?= $_SERVER["SERVER_SOFTWARE"] ?></dd>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
