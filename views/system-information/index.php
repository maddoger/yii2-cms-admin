<?php

/** @var $this \yii\web\View */
/** @var $provider probe\provider\ProviderInterface */

?>

<div class="row">
    <div class="col-md-4">
        Graph
    </div>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">
                    <i class="fa fa-hdd-o"></i>
                    <?= Yii::t('maddoger/admin', 'Processor') ?>
                </div>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('maddoger/admin', 'Processor') ?></dt>
                    <dd><?= @$provider->getCpuVendor() ?> <?= @$provider->getCpuModel() ?></dd>

                    <dt><?= Yii::t('maddoger/admin', 'Processor architecture') ?></dt>
                    <dd><?= @$provider->getArchitecture() ?></dd>

                    <dt><?= Yii::t('maddoger/admin', 'Number of cores') ?></dt>
                    <dd><?= @$provider->getCpuCores() ?> (<?= @$provider->getCpuPhysicalCores() ?>)</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header">
                <div class="box-title">
                    <i class="fa fa-hdd-o"></i>
                    <?= Yii::t('maddoger/admin', 'Memory') ?>
                </div>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt><?= Yii::t('maddoger/admin', 'Using memory') ?></dt>
                    <dd><?= @$provider->getUsedMem() ?> <span title="Swap">(<?= @$provider->getUsedSwap() ?> )</span></dd>

                    <dt><?= Yii::t('maddoger/admin', 'Total memory') ?></dt>
                    <dd><?= @$provider->getTotalMem() ?></dd>

                    <dt><?= Yii::t('maddoger/admin', 'Free memory') ?></dt>
                    <dd><?= @$provider->getFreeMem() ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
