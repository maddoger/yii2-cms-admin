<?php

namespace maddoger\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

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

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionPhpinfo()
    {
        return $this->renderPartial('phpinfo');
    }
}