<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace myzero1\gii\generators\captcha;

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

        // other coding
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Myzero1 Captcha Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Myzero1 Captcha Module just add a widget to view to upload files.';
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $this->addRequiresToComposer();

        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;

        $code = <<<EOD
<?php
    ......
    'modules' => [
        ......
        'upload' => [
            'class' => 'myzero1\yii2upload\Tools',
            'upload' => [
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
            ],
        ],
        ......
    ],
    ......
EOD;

$output = $output . '<pre>' . highlight_string($code, true) . '</pre>';

$output = $output . '<p> Add upload widget like following: </p>';

        $code2 = <<<EOD
<?php
    ......
    echo \myzero1\yii2upload\widget\upload\Upload::widget([
        'model' => $model,
        'attribute' => 'logo',
        // 'url' => ['/tools/upload/upload'], // default ['/tools/upload/upload'],
        // 'sortable' => true,
        // 'maxFileSize' => 200  * 1024, // 200k
        // 'minFileSize' => 1 * 1024, // 1k
        // 'maxNumberOfFiles' => 1, // default 1,
        // 'acceptFileTypesNew' => [], // default ['gif','jpeg','jpg','png'],
        // 'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),// if it is null，the acceptFileTypesNew will working.
        // 'showPreviewFilename' => false,
        // 'clientOptions' => []
    ]);

    //With ActiveForm

    echo $form->field($model, 'logo')->widget(
        '\myzero1\yii2upload\widget\upload\Upload',
        [
            // 'maxFileSize' => 200  * 1024, // 200k
            // 'acceptFileTypesNew' => [], // default ['gif','jpeg','jpg','png'],
        ]
    );
    ......
EOD;

$output = $output . '<pre>' . highlight_string($code2, true) . '</pre>';

$output = $output . '<p> Added the following requires to the section of require to composer.json. </p>';

$sComposerRequires = '';
foreach ($this->getComposerRequires()['require'] as $key => $value) {
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
        Myzero1 Upload Module Generator will add the requires to composer.json
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
    public function generate()
    {
        $files = [];
        $myzero1RuntimeDir = $this->getMyzero1RuntimeDir();

        $files[] = new CodeFile(
            $myzero1RuntimeDir . '/upload_holdon.php',
            $this->render("upload_holdon.php")
        );

        return $files;
    }

    /**
     * @return boolean the directory that contains the module class
     */
    public function getMyzero1RuntimeDir()
    {
        $myzero1RuntimeDir = Yii::getAlias('@vendor/myzero1/yii2-gii/runtime');

        return $myzero1RuntimeDir;
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
            case 1:
                $aComposerRequires['require'] = [
                    'myzero1/yii2-upload' => '~1.0.2',
                ];
                break;
        }

       return $aComposerRequires;
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function showExample()
    {
        $model = new \common\models\User();
        $example = \myzero1\yii2upload\widget\upload\Upload::widget([
            'model' => $model,
            'attribute' => 'id',
            'url' => ['/myzero1/myzero1_upload/upload/upload'], // default ['/tools/upload/upload'],
            'maxFileSize' => 200  * 1024, // 200k
            'minFileSize' => 1 * 1024, // 1k
            // 'sortable' => true,
            // 'maxNumberOfFiles' => 1, // default 1,
            // 'acceptFileTypesNew' => [], // default ['gif','jpeg','jpg','png'],
            // 'acceptFileTypes' => new \yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),// if it is null，the acceptFileTypesNew will working.
            // 'showPreviewFilename' => false,
            // 'clientOptions' => []
        ]);

        return <<<EOF
<div class="panel panel-default">
    <div class="panel-heading">
        Upload example:
    </div>
    <div class="panel-body">
        {$example}
    </div>
</div>
EOF;
    }
}