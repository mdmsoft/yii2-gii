<?php
/**
 * This is the template for generating a asset class within a theming.
 */

/* @var $this yii\web\AssetBundle */
/* @var $generator myzero1\gii\generators\theming\Generator */

$namespaceOld = $generator->ns . '\\' . $generator->getThemingName($generator->themingID);
$namespace = $namespaceOld . '\assets';
$assetClass = $namespace . '\ThemingAsset';
$AlertWidgetClass = $namespaceOld . '\widgets\Alert';

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
    <?= "<?php " ?> $this->head() ?>
</head>
<body>
<?= "<?php " ?> $this->beginBody() ?>

<div class="wrap">
    <?= "<?php " ?>
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= "<?= " ?> Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= "<?= " ?> Alert::widget() ?>
        <?= "<?= " ?> $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= "<?= " ?> date('Y') ?></p>

        <p class="pull-right"><?= "<?= " ?> Yii::powered() ?></p>
    </div>
</footer>

<?= "<?php " ?> $this->endBody() ?>
</body>
</html>
<?= "<?php " ?> $this->endPage() ?>
