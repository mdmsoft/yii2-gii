<?php
/**
 * This is the template for generating a asset class within a theming.
 */

/* @var $this yii\web\AssetBundle */
/* @var $generator myzero1\gii\generators\theming\Generator */

$namespaceOld = $generator->ns . '\\' . $generator->getThemingName($generator->themingID);
$namespace = $namespaceOld . '\assets';
$assetClass = $namespace . '\ThemingAsset';
$AlertWidgetClass = $namespace . '\widgets\Alert';

echo "<?php\n";
?>

/* @var $this \yii\web\View */
/* @var $content string */
use <?= $assetClass ?>;
use <?= $AlertWidgetClass ?>;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

ThemingAsset::register($this);

?>

<?= "<?php " ?> $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= "<?= " ?> Yii::$app->language ?>">
<head>
    <meta charset="<?= "<?= " ?> Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= "<?= " ?> Html::csrfMetaTags() ?>
    <title><?= "<?= " ?> Html::encode($this->title) ?></title>

    <style type="text/css">
        html,body{
            min-height: 300px !important;
        }
        body{
            overflow: hidden;
        }
    </style>

    <?= "<?php " ?> $this->head() ?>
</head>
<body>
<?= "<?php " ?> $this->beginBody() ?>

    <?= "<?= " ?> $content ?>

<?= "<?php " ?> $this->endBody() ?>
</body>
</html>
<?= "<?php " ?> $this->endPage() ?>
