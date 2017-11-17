<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace myzero1\gii\generators\crud;

use Yii;
use yii\web\Controller;
use yii\gii\CodeFile;
use yii\db\BaseActiveRecord;

/**
 * Generates CRUD
 *
 * @property string $controllerClass The controller class to be generated. This property is
 * read-only.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    public $controllerID;
    public $module;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Myzero1 CRUD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(\yii\gii\Generator::rules(), [
            [['controllerID', 'modelClass', 'searchModelClass', 'baseControllerClass'], 'filter', 'filter' => 'trim'],
            [['modelClass', 'controllerID', 'baseControllerClass', 'indexWidgetType'], 'required'],
            [['searchModelClass'], 'compare', 'compareAttribute' => 'modelClass', 'operator' => '!==', 'message' => 'Search Model Class must not be equal to Model Class.'],
            [['modelClass', 'baseControllerClass', 'searchModelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['modelClass'], 'validateClass', 'params' => ['extends' => BaseActiveRecord::className()]],
            [['baseControllerClass'], 'validateClass', 'params' => ['extends' => Controller::className()]],
            [['controllerID'], 'match', 'pattern' => '/^[a-z][a-z0-9\\-\\/]*$/', 'message' => 'Only a-z, 0-9, dashes (-) and slashes (/) are allowed.'],
            [['searchModelClass'], 'validateNewClass'],
            [['indexWidgetType'], 'in', 'range' => ['grid', 'list']],
            [['modelClass'], 'validateModelClass'],
            [['enableI18N'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'controllerID' => 'Controller ID',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'controllerID' => 'Controller ID should be in lower case and may contain module ID(s) separated by slashes. For example:
                <ul>
                    <li><code>order</code> generates <code>OrderController.php</code></li>
                    <li><code>order-item</code> generates <code>OrderItemController.php</code></li>
                    <li><code>admin/user</code> generates <code>UserController.php</code> under <code>admin</code> directory.</li>
                </ul>',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->getControllerClass(), '\\')) . '.php');

        $files = [
            new CodeFile($controllerFile, $this->render('controller.php')),
        ];

        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->searchModelClass, '\\') . '.php'));
            $files[] = new CodeFile($searchModel, $this->render('search.php'));
        }

        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';
        foreach (scandir($templatePath) as $file) {
            if (empty($this->searchModelClass) && $file === '_search.php') {
                continue;
            }
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }

        return $files;
    }

    /**
     * @return string the action view file path
     */
    public function getViewPath()
    {
        if ($this->viewPath === null) {
            $this->module = Yii::$app;
            $id = $this->controllerID;
            while (($pos = strpos($id, '/')) !== false) {
                $mId = substr($id, 0, $pos);
                if (($m = $this->module->getModule($mId)) !== null) {
                    $this->module = $m;
                    $id = substr($id, $pos + 1);
                } else {
                    break;
                }
            }
            $this->viewPath = $this->module->getViewPath() . '/' . $id;
        }
        return $this->viewPath;
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $route = '/' . $this->controllerID . '/index';
        $link = \yii\helpers\Html::a('try it now', [$route], ['target' => '_blank']);

        return "The controller has been generated successfully. You may $link.";
    }

    /**
     * @return string the controller class
     */
    public function getControllerClass()
    {
        if ($this->controllerClass === null) {
            $this->module = Yii::$app;
            $id = $this->controllerID;
            while (($pos = strpos($id, '/')) !== false) {
                $mId = substr($id, 0, $pos);
                if (($m = $this->module->getModule($mId)) !== null) {
                    $this->module = $m;
                    $id = substr($id, $pos + 1);
                } else {
                    break;
                }
            }
            $this->viewPath = $this->module->getViewPath() . '/' . $id;

            $pos = strrpos($id, '/');
            if ($pos === false) {
                $prefix = '';
                $className = $id;
            } else {
                $prefix = substr($id, 0, $pos + 1);
                $className = substr($id, $pos + 1);
            }

            $className = str_replace(' ', '', ucwords(str_replace('-', ' ', $className))) . 'Controller';
            $className = ltrim($this->module->controllerNamespace . '\\' . str_replace('/', '\\', $prefix) . $className, '\\');
            $this->controllerClass = $className;
        }
        return $this->controllerClass;
    }
}