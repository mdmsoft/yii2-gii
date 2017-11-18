<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace myzero1\gii;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

/**
 * This is the main module class for the Gii module.
 *
 * To use Gii, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     'bootstrap' => ['gii'],
 *     'modules' => [
 *         'gii' => ['class' => 'yii\gii\Module'],
 *     ],
 * ]
 * ~~~
 *
 * Because Gii generates new code files on the server, you should only use it on your own
 * development machine. To prevent other people from using this module, by default, Gii
 * can only be accessed by localhost. You may configure its [[allowedIPs]] property if
 * you want to make it accessible on other machines.
 *
 * With the above configuration, you will be able to access GiiModule in your browser using
 * the URL `http://localhost/path/to/index.php?r=gii`
 *
 * If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
 * you can then access Gii via URL: `http://localhost/path/to/index.php/gii`
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'yii\gii\controllers';
    /**
     * @var array the list of IPs that are allowed to access this module.
     * Each array element represents a single IP filter which can be either an IP address
     * or an address with wildcard (e.g. 192.168.0.*) to represent a network segment.
     * The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed
     * by localhost.
     */
    public $allowedIPs = ['127.0.0.1', '::1'];
    /**
     * @var array|Generator[] a list of generator configurations or instances. The array keys
     * are the generator IDs (e.g. "crud"), and the array elements are the corresponding generator
     * configurations or the instances.
     *
     * After the module is initialized, this property will become an array of generator instances
     * which are created based on the configurations previously taken by this property.
     *
     * Newly assigned generators will be merged with the [[coreGenerators()|core ones]], and the former
     * takes precedence in case when they have the same generator ID.
     */
    public $generators = [];
    /**
     * @var integer the permission to be set for newly generated code files.
     * This value will be used by PHP chmod function.
     * Defaults to 0666, meaning the file is read-writable by all users.
     */
    public $newFileMode = 0666;
    /**
     * @var integer the permission to be set for newly generated directories.
     * This value will be used by PHP chmod function.
     * Defaults to 0777, meaning the directory can be read, written and executed by all users.
     */
    public $newDirMode = 0777;
    /**
     * @var integer the permission to be set for newly generated directories.
     * This value will be used by PHP chmod function.
     * Defaults to 0777, meaning the directory can be read, written and executed by all users.
     */
    public $myzero1Tools = [
        'myzero1_theming' => [
            'name' => 'Myzero1 theming Generator',
            'description' => 'This is a description.',
            'url' => '/myzero1/gii/default/view?id=myzero1_theming',
        ],
        'myzero1_upload' => [
            'name' => 'Myzero1 upload Widget',
            'description' => 'This is a description.',
            'url' => '/myzero1/gii/default/view?id=myzero1_upload',
        ],
        'myzero1_captcha' => [
            'name' => 'Myzero1 captcha Widget',
            'description' => 'This is a description.',
            'url' => '/myzero1/gii/default/view?id=myzero1_captcha',
        ],
    ];


    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => 'myzero1' . $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'myzero1' . $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'myzero1' . $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
            ], false);

        } elseif ($app instanceof \yii\console\Application) {
            $app->controllerMap[$this->id] = [
                'class' => 'yii\gii\console\GenerateController',
                'generators' => array_merge($this->coreGenerators(), $this->generators),
                'module' => $this,
            ];
        }

    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->addDefaultGii($this);

        $this->addExample($this);
    }


    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app instanceof \yii\web\Application && !$this->checkAccess()) {
            throw new ForbiddenHttpException('You are not allowed to access this page.');
        }

        $this->resetGlobalSettings();

        return true;
    }

    /**
     * Resets potentially incompatible global settings done in app config.
     */
    protected function resetGlobalSettings()
    {
        if (Yii::$app instanceof \yii\web\Application) {
            Yii::$app->assetManager->bundles = [];
        }
    }

    /**
     * @return boolean whether the module can be accessed by the current user
     */
    protected function checkAccess()
    {
        $ip = Yii::$app->getRequest()->getUserIP();
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
                return true;
            }
        }
        Yii::warning('Access to Gii is denied due to IP address restriction. The requested IP is ' . $ip, __METHOD__);

        return false;
    }

    protected function addDefaultGii($app)
    {
        $generators = [
            'myzero1_home' => [
                'class' => \myzero1\gii\generators\myzero1\Generator::class,
            ],
            'myzero1_theming' => [
                'class' => \myzero1\gii\generators\theming\Generator::class,
            ],
            'myzero1_upload' => [
                'class' => \myzero1\gii\generators\upload\Generator::class,
            ],

            'myzero1_captcha' => [
                'class' => \myzero1\gii\generators\captcha\Generator::class,
            ],
            // 'myzero1_mvc' => [
            //     'class' => \myzero1\gii\generators\mvc\Generator::class,
            // ],
            'crud' => [
                'class' => \yii\gii\generators\crud\Generator::class,
                'templates' => [
                    'adminlte' => '@myzero1/gii/generators/theming/default/adminlte/_gii_templates/crud',
                ],
                'template' => 'adminlte',
                'messageCategory' => 'backend'
            ],
        ];

        $this->generators = array_merge($generators, $this->generators);

        $app->setModules(
            [
                'gii' => [
                    'class' => '\yii\gii\Module',
                    'allowedIPs' => $this->allowedIPs,
                    'generators' => $this->generators,
                ]
            ]
        );
    }


    /**
     * @return string the controller namespace of the module.
     */
    protected function addExample($app)
    {
        $app->setModules(
            [
                'myzero1_upload' => [
                    'class' => 'myzero1\yii2upload\Tools',
                    'upload' => [
                        'basePath' => '@webroot/myzero1_upload',
                        'baseUrl' => '@web/myzero1_upload',
                    ],
                ],
            ]
        );
    }

}
