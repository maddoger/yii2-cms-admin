<?php
/**
 * @copyright Copyright (c) 2015 Vitaliy Syrchikov
 * @link http://syrchikov.name
 */

namespace maddoger\admin;

use maddoger\core\behaviors\ConfigurationBehavior;
use maddoger\core\components\BackendModule;
use maddoger\core\models\DynamicModel;
use Yii;
use yii\rbac\Item;

/**
 * Module
 *
 * @author Vitaliy Syrchikov <maddoger@gmail.com>
 * @link http://syrchikov.name
 * @package maddoger/yii2-admin
 */
class Module extends BackendModule
{
    /**
     * @var string logo text
     */
    public $logoText;

    /**
     * @var string URL to logo for admin panel
     */
    public $logoImageUrl;

    /**
     * @var string
     */
    public $dashboardView;

    /**
     * @var array menu items for sidebar menu
     */
    public $sidebarMenu;

    /**
     * @var bool append modules navigation to sidebar menu
     */
    public $sidebarMenuUseModules = true;

    /**
     * @var int time in seconds for sidebar menu cache
     * 0 - infinity
     * false - disable caching
     * Default: 60 seconds
     */
    public $sidebarMenuCache = 60;

    /**
     * @var string view for sidebar
     */
    public $sidebarView = '@maddoger/admin/views/layouts/_sidebar.php';

    /**
     * @var string view for main menu
     */
    public $sidebarMenuView = '@maddoger/admin/views/layouts/_sidebarMenu.php';

    /**
     * @var string view for user menu in the header
     */
    public $headerUserView = '@maddoger/admin/views/layouts/_headerUser.php';

    /**
     * @var string view for notifications menu in the header
     */
    public $headerNotificationsView = '@maddoger/admin/views/layouts/_headerNotifications.php';

    /**
     * @var string
     */
    public $footerView = '@maddoger/admin/views/layouts/_footer.php';

    /**
     * @var bool
     */
    public $searchUseModulesSources = true;

    /**
     * @var array additional search sources
     */
    public $searchSources;

    /**
     * Init module
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'configurationBehavior' => [
                'class' => ConfigurationBehavior::className(),
                'attributes' => [
                    'logoText' => $this->logoText,
                    'logoImageUrl' => $this->logoImageUrl,
                    'sortNumber' => $this->sortNumber,
                ],
                'saveToOwnerProperties' => true,
                //Editing
                'view' => $this->getViewPath() . DIRECTORY_SEPARATOR . 'configuration.php',
                'roles' => ['admin.configuration'],
                'dynamicModel' => [
                    'formName' => $this->id.'Configuration',
                    'rules' => [
                        [['logoText', 'logoImageUrl'], 'string'],
                        [['logoText', 'logoImageUrl', 'sortNumber'], 'default', ['value' => null]],
                    ],
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function registerTranslations()
    {
        if (!isset(Yii::$app->i18n->translations['maddoger/admin'])) {

            Yii::$app->i18n->translations['maddoger/admin'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@maddoger/admin/messages',
                'sourceLanguage' => 'en-US',
            ];
        }
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return Yii::t('maddoger/admin', 'Admin Panel Module');
    }

    /**
     * @inheritdoc
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @inheritdoc
     */
    public function getNavigation()
    {
        return [
            [
                'label' => Yii::t('maddoger/admin', 'Admin panel'),
                'icon' => 'fa fa-gear',
                'items' => [
                    [
                        'label' => Yii::t('maddoger/admin', 'Configuration'),
                        'url' => ['/' . $this->id . '/configuration/index'],
                        'activeUrl' => '/' . $this->id . '/configuration/*',
                        'icon' => 'fa fa-gears',
                        'roles' => ['admin.configuration'],
                    ],
                    [
                        'label' => Yii::t('maddoger/admin', 'System information'),
                        'url' => ['/' . $this->id . '/system-information/index'],
                        'activeUrl' => '/' . $this->id . '/system-information/*',
                        'icon' => 'fa fa-bars',
                        'roles' => ['admin.system-information'],
                    ],
                    [
                        'label' => Yii::t('maddoger/admin', 'Log'),
                        'url' => ['/' . $this->id . '/log/index'],
                        'activeUrl' => '/' . $this->id . '/log/*',
                        'icon' => 'fa fa-warning',
                        'roles' => ['admin.log'],
                    ],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getRbacItems()
    {
        return [
            'admin.dashboard' =>
                [
                    'type' => Item::TYPE_PERMISSION,
                    'description' => Yii::t('maddoger/admin', 'Admin. Access to dashboard'),
                ],
            'admin.log' =>
                [
                    'type' => Item::TYPE_PERMISSION,
                    'description' => Yii::t('maddoger/admin', 'Admin. View log messages'),
                ],
            'admin.configuration' =>
                [
                    'type' => Item::TYPE_PERMISSION,
                    'description' => Yii::t('maddoger/admin', 'Admin. Configuring modules'),
                ],
            'admin.system-information' =>
                [
                    'type' => Item::TYPE_PERMISSION,
                    'description' => Yii::t('maddoger/admin', 'Admin. System information'),
                ],
            'admin.base' =>
                [
                    'type' => Item::TYPE_ROLE,
                    'description' => Yii::t('maddoger/admin', 'Admin. Base access to admin panel'),
                    'children' => [
                        'admin.dashboard',
                        'admin.log',
                        'admin.configuration',
                        'admin.system-information',
                    ]
                ],
        ];
    }

    /**
     * @return array
     */
    public function getSearchSources()
    {
        return [
            [
                'class' => '\maddoger\core\search\ArraySearchSource',
                'data' => [
                    [
                        'label' => Yii::t('maddoger/admin', 'Configuration'),
                        'url' => ['/' . $this->id . '/configuration/index'],
                    ],
                    [
                        'label' => Yii::t('maddoger/admin', 'System information'),
                        'url' => ['/' . $this->id . '/system-information/index'],
                    ],
                    [
                        'label' => Yii::t('maddoger/admin', 'Log'),
                        'url' => ['/' . $this->id . '/log/index'],
                    ],
                ],
                'roles' => ['admin.base'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getSidebarMenu()
    {
        $menu = null;

        $cacheKey = 'ADMIN_SIDEBAR_MENU';
        if ($this->sidebarMenuCache !== false) {
            $menu = Yii::$app->cache->get($cacheKey);
        } else {
            Yii::$app->cache->delete($cacheKey);
        }

        if (!$menu) {

            $menu = $this->sidebarMenu ?:
                [
                    [
                        'label' => Yii::t('maddoger/admin', 'Dashboard'),
                        'icon' => 'fa fa-dashboard',
                        'url' => ['/' . Module::getInstance()->id . '/site/index'],
                        'sort' => -1,
                    ],
                ];

            if ($this->sidebarMenuUseModules) {

                $sortIndex = 0;

                //Get navigation from modules
                foreach (Yii::$app->modules as $moduleId => $module) {

                    if (!($module instanceof \yii\base\Module)) {
                        $module = Yii::$app->getModule($moduleId, true);
                    }

                    if ($module instanceof BackendModule) {


                        $sort = $module->sortNumber ?: (++$sortIndex) * 100;
                        $navigation = $module->getNavigation();
                        if ($navigation) {
                            foreach ($navigation as $key => $value) {
                                if (!isset($navigation[$key]['sort'])) {
                                    $navigation[$key]['sort'] = $sort;
                                }
                            }

                            $menu = array_merge($menu, $navigation);
                        }
                    }
                }

                //Sort
                usort($menu, function ($a, $b) {
                    $res = 0;
                    if ($a['sort'] != $b['sort']) {
                        $res = $a['sort'] > $b['sort'] ? 1 : -1;
                    }
                    /*if (!$res) {
                        $res = strcmp($a['label'], $b['label']);
                    }*/
                    return $res;
                });
            }

            if ($this->sidebarMenuCache !== false) {
                Yii::$app->cache->set($cacheKey, $menu, $this->sidebarMenuCache);
            }
        }

        return $menu;
    }
}