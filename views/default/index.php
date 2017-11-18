<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $generators \yii\gii\Generator[] */
/* @var $content string */

$myzero1Tools = Yii::$app->controller->module->myzero1Tools;
$this->title = 'Welcome to myzero1';
?>
<div class="default-index">
    <div class="page-header">
        <h1>Welcome to myzero1 <small>This are some useful tools for yii2.</small></h1>
    </div>

    <p class="lead">To use the following tools:</p>

    <div class="row">
        <?php foreach ($myzero1Tools as $id => $tool): ?>
        <div class="generator col-lg-4">
            <h3><?= Html::encode($tool['name']) ?></h3>
            <p><?= $tool['description'] ?></p>
            <p><?= Html::a('To use &raquo;', [$tool['url']], ['class' => 'btn btn-default']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <p><a class="btn btn-success" href="https://github.com/myzero1/yii2-gii">Get More Tools</a></p>

</div>
