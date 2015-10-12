<?php
/**
 * @copyright Copyright (c) 2014 Vitaliy Syrchikov
 * @link http://syrchikov.name
 */

namespace maddoger\admin\controllers;

use maddoger\admin\Module;
use maddoger\core\components\BackendModule;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * SiteController for authorisation
 *
 * @author Vitaliy Syrchikov <maddoger@gmail.com>
 * @link http://syrchikov.name
 * @package
 */
class SiteController extends Controller
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
                        'actions' => [
                            'error',
                            'captcha'
                        ],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'search'],
                        'roles' => ['admin.dashboard'],
                        'allow' => true,
                    ],
                    //For superuser
                    [
                        'allow' => true,
                        'roles' => ['superuser'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'error') {
            if (!Yii::$app->user->isGuest) {
                $this->layout = 'main';
            } else {
                $this->layout = 'minimal';
            }
        }
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'width' => 240,
                'height' => 100,
                'padding' => 1,
                'foreColor' => 0x3d9970,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $view = Module::getInstance()->dashboardView ?: 'dashboard';
        return $this->render($view);
    }

    /**
     * @param string $q
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSearch($q = '')
    {
        $q = trim(strip_tags($q));

        /**
         * @var \maddoger\admin\Module $module
         */
        $module = $this->module;

        $sources = $module->searchSources ?: [];
        if ($module->searchUseModulesSources) {
//Get navigation from modules
            foreach (Yii::$app->modules as $moduleId => $module) {

                if (!($module instanceof \yii\base\Module)) {
                    $module = Yii::$app->getModule($moduleId, true);
                }

                if ($module instanceof BackendModule) {
                    $moduleSources = $module->getSearchSources();
                    if ($moduleSources) {
                        $sources = array_merge($sources, $moduleSources);
                    }
                }
            }
        }

        $content = [];

        //Data to models
        foreach ($sources as $source) {
            if (is_array($source)) {
                $roles = ArrayHelper::remove($source, 'roles');
                if ($roles) {
                    $can = false;
                    foreach ($roles as $role) {
                        if (Yii::$app->user->can($role)) {
                            $can = true;
                            break;
                        }
                    }
                    if (!$can) {
                        continue;
                    }
                }
                $source = Yii::createObject($source);
            }
            /**
             * @var \maddoger\core\search\BaseSearchSource $source
             */
            $result = $source->getResult($q);
            if ($result) {
                $content = array_merge($content, $result);
            }
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $content;
        }


        return $this->render('search', [
            'query' => $q,
            'result' => $content,
        ]);
    }

    /**
     * @return string
     */
    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = Yii::t('maddoger/admin', 'Error');
        }
        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = Yii::t('maddoger/admin', 'An internal server error occurred.');
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('error', [
                'name' => $name,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}