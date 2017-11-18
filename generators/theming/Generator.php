<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace myzero1\gii\generators\theming;

use yii\gii\CodeFile;
use yii\helpers\Html;
use Yii;
use yii\helpers\StringHelper;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @property string $controllerNamespace The controller namespace of the module. This property is read-only.
 * @property boolean $modulePath The directory that contains the module class. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    const ADMINLTE = 1;

    public $ns;
    public $themingID = self::ADMINLTE;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // // $this->templates = [
        //     'AdminLte' => 'qq',
        // // ];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Myzero1 Theming Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator helps you to generate the skeleton code needed by a Yii theming.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['themingID', 'ns'], 'filter', 'filter' => 'trim'],
            [['themingID', 'ns'], 'required'],
            [['ns'], 'filter', 'filter' => function($value) { return trim($value, '\\'); }],
            [['ns'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            ['themingID', 'in', 'range' => [1]],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'themingID' => 'Theming ID',
            'ns' => 'Theming namespace',
        ];
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return [
            'themingID' => 'This refers to the ID of the theming, e.g., <code>adminlte</code>.',
            'ns' => 'This is the fully qualified namespace of the theming, e.g., <code>(eg:backend\themes)</code>.',
        ];
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $this->addRequiresToComposer();

        if (Yii::$app->hasModule($this->themingID)) {
            $link = Html::a('try it now', Yii::$app->getUrlManager()->createUrl($this->themingID), ['target' => '_blank']);

            return "The module has been generated successfully. You may $link.";
        }

        $viewPath = '@' . str_replace('\\', '/', $this->ns) . '/' . $this->getThemingName($this->themingID) . '/views';

        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;

        $code = <<<EOD
<?php
    ......
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '{$viewPath}',
                ],
            ],
        ],
    ......
EOD;

$output = $output . '<pre>' . highlight_string($code, true) . '</pre>';

$output = $output . '<p> The usefull setting. </p>';

$assetClass = $this->ns . '\\' . $this->getThemingName($this->themingID) . '\assets\ThemingAsset';

        $code2 = <<<EOD
<?php
    ......
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => true,//link to assets,no cache.used in develop.
            'bundles'=> [
                '{$assetClass}' => [
                    'skin' => 'skin-red',// skin-{blue|black|purple|green|red|yellow}[-light],example skin-blue,skin-blue-light
                ],
            ],
            'assetMap' => [
                'AdminLTE-local-font.min.css' => '.gitignore',// use google font
                // 'AdminLTE.min.css' => '.gitignore',// use local font
            ],
        ],
    ......
EOD;

$output = $output . '<pre>' . highlight_string($code2, true) . '</pre>';

$output = $output . '<p> Added the following requires to the section of require to composer.json. </p>';

$sComposerRequires = '';
foreach ($this->getComposerRequires($this->themingID)['require'] as $key => $value) {
    $sComposerRequires .= sprintf('        "%s":"%s",',$key,$value) . "\n";
}
$sComposerRequires = trim($sComposerRequires,",\n");

// $sComposerRequires = json_encode($this->getComposerRequires($this->themingID)['require'], JSON_PRETTY_PRINT);
// $sComposerRequires = trim($sComposerRequires,'{}');

        $code3 = <<<EOD
{
    ......
    "require": {
        ......
{$sComposerRequires}
        ......
    }
    ......
}
EOD;

        return $output . '<pre>' . highlight_string($code3, true) . '</pre>';
    }

    /**
     * @inheritdoc
     */
    public function noticeMessage()
    {

        $sComposerRequires = '';
        foreach ($this->getComposerRequires($this->themingID)['require'] as $key => $value) {
            $sComposerRequires .= sprintf('        "%s":"%s",',$key,$value) . "\n";
        }
        $sComposerRequires = trim($sComposerRequires,",\n");


        $code = <<<EOD
{
    ......
    "require": {
        ......
{$sComposerRequires}
        ......
    }
    ......
}
EOD;

        $code = highlight_string($code, true);

        $output = <<<EOD
<div class="panel panel-warning">
    <div class="panel-heading">
        Myzero1 Theming Generator will add the requires to composer.json
    </div>
    <div class="panel-body">
        {$code}
    </div>
</div>
EOD;

        return $output;
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return [
            // 'module.php',
            // 'controller.php',
            // 'view.php'
        ];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $themingPath = $this->getThemingPath();
        $files[] = new CodeFile(
            $themingPath . '/assets/ThemingAsset.php',
            $this->render("adminlte/assets/ThemingAsset.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/common/AdminLte.php',
            $this->render("adminlte/assets/common/AdminLte.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/common/FontAwesome.php',
            $this->render("adminlte/assets/common/FontAwesome.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/common/Html5shiv.php',
            $this->render("adminlte/assets/common/Html5shiv.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/common/JquerySlimScroll.php',
            $this->render("adminlte/assets/common/JquerySlimScroll.php")
        );

        $files[] = new CodeFile(
            $themingPath . '/assets/js/custom.js',
            $this->render("adminlte/assets/js/custom.js")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/css/custom.css',
            $this->render("adminlte/assets/css/custom.css")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/css/fonts.google.css',
            $this->render("adminlte/assets/css/fonts.google.css")
        );
        $files[] = new CodeFile(
            $themingPath . '/assets/css/AdminLTE-local-font.min.css',
            $this->render("adminlte/assets/css/AdminLTE-local-font.min.css")
        );

        $files[] = new CodeFile(
            $themingPath . '/views/layouts/blank.php',
            $this->render("adminlte/views/layouts/blank.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/views/layouts/default.php',
            $this->render("adminlte/views/layouts/default.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/views/layouts/guest.php',
            $this->render("adminlte/views/layouts/guest.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/views/layouts/head.php',
            $this->render("adminlte/views/layouts/head.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/views/layouts/main.php',
            $this->render("adminlte/views/layouts/main.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/views/layouts/sidebar-menu.php',
            $this->render("adminlte/views/layouts/sidebar-menu.php")
        );

        $files[] = new CodeFile(
            $themingPath . '/widgets/Menu.php',
            $this->render("adminlte/widgets/Menu.php")
        );
        $files[] = new CodeFile(
            $themingPath . '/widgets/Alert.php',
            $this->render("adminlte/widgets/Alert.php")
        );

        return $files;
    }

    /**
     * Validates [[ns]] to make sure it is a fully qualified class name.
     */
    public function validatens()
    {
        if (strpos($this->ns, '\\') === false || Yii::getAlias('@' . str_replace('\\', '/', $this->ns), false) === false) {
            $this->addError('ns', 'Module class must be properly namespaced.');
        }
        if (empty($this->ns) || substr_compare($this->ns, '\\', -1, 1) === 0) {
            $this->addError('ns', 'Module class name must not be empty. Please enter a fully qualified class name. e.g. "app\\modules\\admin\\Module".');
        }
    }

    /**
     * @return boolean the directory that contains the module class
     */
    public function getThemingPath()
    {
        return Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/' . $this->getThemingName($this->themingID);
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getControllerNamespace()
    {
        return substr($this->ns, 0, strrpos($this->ns, '\\')) . '\controllers';
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getThemingName($id)
    {
        $aThemingName = [
            1 => 'adminlte',
        ];

        return $aThemingName[$id];
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function addRequiresToComposer()
    {
        $path = \Yii::getAlias('@app/../composer.json');

        $composerContent = json_decode(file_get_contents($path),true);

        $aComposerRequires = $this->getComposerRequires($this->themingID);

        foreach ($aComposerRequires['require'] as $key => $value) {
            $composerContent['require'][$key] = $value;
        }

       file_put_contents($path, str_replace('\\', '', json_encode($composerContent, JSON_PRETTY_PRINT)));
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getComposerRequires($id=1)
    {
        $aComposerRequires = array();

        switch ($id) {
            case self::ADMINLTE:
                $aComposerRequires['require'] = [
                    'yiisoft/yii2-jui' => '^2.0.0',
                    'bower-asset/jquery-slimscroll' => '^1.3',
                    'bower-asset/html5shiv' => '^3.0',
                    'bower-asset/font-awesome' => '^4.0',
                    'bower-asset/admin-lte' => '^2.3.11',
                ];
                break;
        }

       return $aComposerRequires;
    }
}
