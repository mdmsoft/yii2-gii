<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace myzero1\gii\generators\myzero1;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\base\Model;
use yii\web\Controller;

/**
 * This generator will generate a controller and one or a few action view files.
 *
 * @property array $actionIDs An array of action IDs entered by the user. This property is read-only.
 * @property string $controllerClass The controller class name without the namespace part. This property is
 * read-only.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Myzero1 Home';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Go to myzero1 home,to get more usefull tools for yii2 app.';
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        return $files;
    }
}