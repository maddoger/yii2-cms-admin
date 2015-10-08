<?php

namespace maddoger\admin\controllers;

use maddoger\core\components\BackendModule;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Modules configurations editor
 * @package maddoger\admin\controllers
 */
class ConfigurationController extends Controller
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
                    //For superuser
                    [
                        'allow' => true,
                        'roles' => ['superuser', 'admin.configuration'],
                    ],
                ],
            ],
        ];
    }

    private function checkAccess($roles)
    {
        $user = Yii::$app->getUser();
        if (empty($roles)) {
            return true;
        }
        foreach ($roles as $role) {
            if ($role === '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            } elseif ($user->can($role)) {
                return true;
            }
        }

        return false;
    }

    public function actionIndex()
    {
        $configuration = [];
        $sortIndex = 0;

        //Get configuration models from modules
        foreach (Yii::$app->modules as $moduleId => $module) {

            if (!($module instanceof \yii\base\Module)) {
                $module = Yii::$app->getModule($moduleId, true);
            }

            //ConfigurationBehavior
            //TODO: Do better ConfigurationBehavior test
            if ($module instanceof BackendModule &&
                $module->hasMethod('getConfigurationModel') &&
                $module->hasMethod('getConfigurationView') &&
                $module->hasMethod('getConfigurationRoles') &&
                $module->hasMethod('saveConfigurationModel')
            ) {

                $sort = $module->sortNumber ?: (++$sortIndex) * 100;

                $roles = $module->getConfigurationRoles();
                if ($roles && !$this->checkAccess($roles)) {
                    continue;
                }
                $model = $module->getConfigurationModel();
                $view = $module->getConfigurationView();

                if ($model && $view) {

                    $model->formName();

                    $configuration[$moduleId] = [
                        'sort' => $sort,
                        'module' => $module,
                        'moduleId' => $moduleId,
                        'moduleName' => $module->getName(),
                        'model' => $model,
                        'view' => $view,
                    ];
                }
            }
        }

        //Sort
        uasort($configuration, function ($a, $b) {
            $res = 0;
            if ($a['sort'] != $b['sort']) {
                $res = $a['sort'] > $b['sort'] ? 1 : -1;
            }
            return $res;
        });

        //Saving
        if (Yii::$app->request->isPost) {

            $result = true;

            foreach ($configuration as $info) {
                /** @var \yii\base\Model $model */
                $model = $info['model'];
                /** @var BackendModule $module */
                $module = $info['module'];

                if ($model->load(Yii::$app->request->post())) {
                    if ($model->validate()) {
                        if (!$module->saveConfigurationModel($model)) {
                            $attributes = $model->attributes();
                            $model->addErrors(
                                array_fill_keys(
                                    $attributes,
                                    Yii::t('maddoger/admin', 'Failed to save.')
                                )
                            );
                            $result = false;
                        }
                    } else {
                        $result = false;
                    }
                }
            }

            if ($result) {
                Yii::$app->session->setFlash('success', Yii::t('maddoger/admin', 'Settings saved successfully.'));
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', Yii::t('maddoger/admin', 'Some settings have problems.'));
            }
        }

        return $this->render('index', [
            'configuration' => $configuration,
        ]);
    }
}