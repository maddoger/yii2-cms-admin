<?php

/** @var $this \yii\web\View */
/** @var $provider \maddoger\admin\components\SystemInformationProvider */
use maddoger\widgets\Highcharts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = Yii::t('maddoger/admin', 'System information');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="system-information-index">
    <div class="row">
        <div class="col-sm-3">
            <?php
            $percent = $provider->getLoadPercent();
            $bgClass = 'blue';
            if ($percent > 90) {
                $bgClass = 'red';
            } elseif ($percent > 60) {
                $bgClass = 'yellow';
            } elseif ($percent > 30) {
                $bgClass = 'green';
            }
            ?>
            <div class="small-box bg-<?= $bgClass ?>" id="cpu-small-box">
                <div class="inner">
                    <h3><?= $provider->getLoadPercent() ?>%</h3>
                    <?= Yii::t('maddoger/admin', 'CPU Usage') ?>
                </div>
                <div class="icon">
                    <i class="fa fa-server"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php
            $usage = $provider->getMemoryUsage();
            $total = $provider->getMemoryTotal();
            $percent = round(100*$usage/$total);
            $bgClass = 'blue';
            if ($percent > 90) {
                $bgClass = 'red';
            } elseif ($percent > 60) {
                $bgClass = 'yellow';
            } elseif ($percent > 30) {
                $bgClass = 'green';
            }
            ?>
            <div class="small-box bg-<?= $bgClass ?>" id="memory-small-box">
                <div class="inner">
                    <h3><?= $percent?>%</h3>
                    <span class="text">
                    <?= Yii::t('maddoger/admin', 'Memory Usage. Used: {0}, total: {1}', [
                        Yii::$app->formatter->asShortSize($usage, 1),
                        Yii::$app->formatter->asShortSize($total, 1)
                    ]) ?>
                    </span>
                </div>
                <div class="icon">
                    <i class="fa fa-bars"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
        <div class="col-sm-3">
            <?php
            $usage = $provider->getStorageUsage();
            $total = $provider->getStorageTotal();
            $percent = $total != 0 ? round(100*$usage/$total) : 0;
            $bgClass = 'blue';
            if ($percent > 90) {
                $bgClass = 'red';
            } elseif ($percent > 60) {
                $bgClass = 'yellow';
            } elseif ($percent > 30) {
                $bgClass = 'green';
            }
            ?>
            <div class="small-box bg-<?= $bgClass ?>">
                <div class="inner">
                    <h3><?= $percent?>%</h3>
                    <span class="text">
                        <?= Yii::t('maddoger/admin', 'Storage Usage. Used: {0}, total: {1}', [
                        Yii::$app->formatter->asShortSize($usage, 0),
                        Yii::$app->formatter->asShortSize($total, 0)
                    ]) ?>
                    </span>
                </div>
                <div class="icon">
                    <i class="fa fa-database"></i>
                </div>
                <div class="small-box-footer">&nbsp;</div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="small-box bg-blue" id="uptime-small-box">
                <div class="inner">
                    <h3><?= $provider->getUptimeString() ?></h3>
                    <?= Yii::t('maddoger/admin', 'Uptime') ?>
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
            <?= Highcharts::widget([
                'chartVariable' => 'cpuChart',
                'options' => [
                    'style' => 'width: 100%; height: 400px;',
                ],
                'clientOptions' => [
                    'chart' => [
                        'type' => 'spline',
                    ],
                    'title' => [
                        'text' => Yii::t('maddoger/admin', 'CPU Usage'),
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
                            'name' => 'CPU',
                            'data' => [],
                        ],
                    ],
                ],
            ]) ?>
        </div><div class="col-md-6">
            <?= Highcharts::widget([
                'chartVariable' => 'memoryChart',
                'options' => [
                    'style' => 'width: 100%; height: 400px;',
                ],
                'clientOptions' => [
                    'chart' => [
                        'type' => 'spline',
                        'events' => [
                            'load' => new JsExpression('requestSystemInfo'),
                        ],
                    ],
                    'title' => [
                        'text' => Yii::t('maddoger/admin', 'Memory Usage'),
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
                            'name' => Yii::t('maddoger/admin', 'Memory'),
                            'data' => [],
                        ],
                        [
                            'name' => Yii::t('maddoger/admin', 'Swap'),
                            'data' => [],
                        ],
                    ],
                ],
            ]) ?>
            <br/>
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
                        <dd><?= Html::a(phpversion(), ['phpinfo'],
                                ['target' => '_blank', 'title' => Yii::t('maddoger/admin', 'Show phpinfo')]) ?></a></dd>

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
        </div><div class="col-md-6">
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
                        <dd><?= nl2br($provider->getCpuInfo()) ?></dd>

                        <dt><?= Yii::t('maddoger/admin', 'OS') ?></dt>
                        <dd><?= $provider->getDistribution() ?></dd>

                        <dt><?= Yii::t('maddoger/admin', 'Kernel') ?></dt>
                        <dd><?= $provider->getKernel() ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$jsonUrl = Url::to(['json']);
$memoryTextTemplate = Yii::t('maddoger/admin', 'Memory Usage. Used: {0}, total: {1}', [
    '#0',
    '#1'
]);

$this->registerJs(
<<<JS
    var cpuSmallBox = $('#cpu-small-box'),
        cpuSmallBoxPercent = cpuSmallBox.find('h3'),

        memorySmallBox = $('#memory-small-box'),
        memorySmallBoxPercent = memorySmallBox.find('h3'),
        memorySmallBoxText = memorySmallBox.find('.text'),

        uptimeSmallBox = $('#uptime-small-box'),
        uptimeSmallBoxPercent = uptimeSmallBox.find('h3');

    function shiftSeries(series, value, history)
    {
        if (!history) {
            history = 60;
        }
        series.addPoint(value, true, series.data.length>history);
    }

    function setSmallBoxClassByPercent(box, percent)
    {
        var c = 'bg-blue';
        if (percent > 90) {
            c = 'bg-red';
        } else if (percent > 60) {
            c = 'bg-yellow';
        } else if (percent > 30) {
            c= 'bg-green';
        }
        box.removeClass();
        box.addClass('small-box '+c);
    }

    function requestSystemInfo()
    {
        $.getJSON('{$jsonUrl}', function(data){

            cpuSmallBoxPercent.text(data['loadPercent']+'%');
            setSmallBoxClassByPercent(cpuSmallBox, data['loadPercent']);
            shiftSeries(cpuChart.series[0] , [data['ts'], data['loadPercent']]);

            uptimeSmallBoxPercent.text(data['uptimeString']);

            var memoryPercent = data['memoryPercent'];
            setSmallBoxClassByPercent(memorySmallBox, memoryPercent);
            memorySmallBoxPercent.text(memoryPercent+'%');
            var memoryText = '{$memoryTextTemplate}';
            memoryText = memoryText.replace('#0', data['memoryUsageString']);
            memoryText = memoryText.replace('#1', data['memoryTotalString']);
            memorySmallBoxText.text(memoryText);
            shiftSeries(memoryChart.series[0] , [data['ts'], memoryPercent]);
            shiftSeries(memoryChart.series[1] , [data['ts'], data['swapPercent']]);

            setTimeout(requestSystemInfo, 1000);
        });
    }
JS
);
