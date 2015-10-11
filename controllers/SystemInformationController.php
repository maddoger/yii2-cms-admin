<?php

namespace maddoger\admin\controllers;

use maddoger\admin\components\SystemInformationProvider;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SystemInformationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['superuser', 'admin.system-information'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        /** @var $provider \maddoger\admin\components\SystemInformationProvider */
        $provider = Yii::createObject(SystemInformationProvider::className(), []);
        return $this->render('index', ['provider' => $provider]);
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionJson()
    {
        /** @var $provider \maddoger\admin\components\SystemInformationProvider */
        $provider = Yii::createObject(SystemInformationProvider::className(), []);
        Yii::$app->response->format = Response::FORMAT_JSON;

        $memoryUsage = $provider->getMemoryUsage();
        $memoryTotal = $provider->getMemoryTotal();
        $swapUsage = $provider->getSwapUsage();
        $swapTotal = $provider->getSwapTotal();
        $data = [
            'ts' => time()*1000,
            'loadPercent' => $provider->getLoadPercent(),
            'memoryUsageString' => Yii::$app->formatter->asShortSize($memoryUsage, 1),
            'memoryTotalString' => Yii::$app->formatter->asShortSize($memoryTotal, 1),
            'memoryUsage' => $memoryUsage,
            'memoryTotal' => $memoryTotal,
            'memoryPercent' => round(100*$memoryUsage/$memoryTotal),
            'swapPercent' => $swapTotal>0 ? round(100*$swapUsage/$swapTotal) : 0,
            'uptimeString' => $provider->getUptimeString(),
        ];
        return $data;
    }

    /**
     * @return string
     */
    public function actionPhpinfo()
    {
        return $this->renderPartial('phpinfo');
    }
}