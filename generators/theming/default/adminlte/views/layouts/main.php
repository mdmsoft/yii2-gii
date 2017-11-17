<?php
/**
 * This is the template for generating a asset class within a theming.
 */


$namespaceOld = $generator->ns . '\\' . $generator->getThemingName($generator->themingID);
$namespace = $namespaceOld . '\assets';
$assetClass = $namespace . '\ThemingAsset';
$AlertWidgetClass = $namespaceOld . '\widgets\Alert';

echo "<?php\n";
?>

/**
 * Theme main layout.
 *
 * @var \yii\web\View $this View
 * @var string $content Content
 */

use <?= $assetClass ?>;
use <?= $AlertWidgetClass ?>;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

ThemingAsset::register($this);

$profile = [
    'avatarUrl' => '',
    'username' => Yii::$app->user->identity->username,
    'trueName' => "",
    'lastTime' => 0,
    'lastIp' => "",
    'profileUrl' => '#',
];

$profile = [
    'avatarUrl' => '',
    'username' => Yii::$app->user->identity->username,
    'trueName' => "",
    'lastTime' => 0,
    'lastIp' => "",
    'profileUrl' => '#',
];

$skin = \Yii::$app->assetManager->bundles['<?= $assetClass?>']->skin;

?>

<?= "<?= " ?> $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= "<?= " ?> Yii::$app->language ?>">
    <head>
        <?= "<?= " ?> $this->render('//layouts/head') ?>
    </head>
    <body class="<?= "<?= " ?>$skin?>">

    <?= "<?php " ?> $this->beginBody(); ?>

        <div class="wrapper">

          <header class="main-header">
            <!-- Logo -->
            <a href="<?= "<?= " ?> Yii::$app->homeUrl ?>" class="logo">
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><?= "<?= " ?> Yii::$app->name ?></span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><?= "<?= " ?> Yii::$app->name ?></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
              </a>

              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="glyphicon glyphicon-user"></i>
                      <span class="hidden-xs"><?= "<?= " ?> $profile['username'] ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <?= "<?php " ?> if ($profile['avatarUrl']) : ?>
                                <?= "<?= " ?> Html::img($profile['avatarUrl'], ['class' => 'img-circle', 'alt' => $profile['username']]) ?>
                            <?= "<?php " ?> endif; ?>
                            <p>
                                <?= "<?php " ?> echo $profile['username'] ?>
                                <small><?= "<?= " ?> Yii::t('app', '登录IP：') ?> <?= "<?= " ?> $profile['lastIp'] ?></small>
                                <small><?= "<?= " ?> Yii::t('app', '登录时间：') ?> <?= "<?= " ?> date('Y-m-d H:i:s', $profile['lastTime']) ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= "<?= " ?> Html::a(
                                    Yii::t('app', '个人资料'),
                                    [$profile['profileUrl']],
                                    ['class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                            <div class="pull-right">
                                <?= "<?php " ?>
                                    echo Html::beginForm(['/site/logout'], 'post')
                                    . Html::submitButton(
                                        Yii::t('app', '安全退出'),
                                        ['class' => 'btn btn-default btn-flat logout']
                                    )
                                    . Html::endForm()
                                ?>

                            </div>
                        </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
               <!-- Sidebar user panel -->
              <div class="user-panel">
                <div class="pull-left image">
                  <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                </div>
                <div class="pull-left info">
   <!--                <p>Alexander Pierce</p>
                  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                </div>
            </div>
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <?= "<?= " ?> $this->render('//layouts/sidebar-menu') ?>
            </section>
            <!-- /.sidebar -->
          </aside>

          <!-- Content Wrapper. Contains page content -->
          <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?= "<?= " ?> $this->title ?>
                    <?= "<?php " ?> if (isset($this->params['subtitle'])) : ?>
                        <small><?= "<?= " ?> $this->params['subtitle'] ?></small>
                    <?= "<?php " ?> endif; ?>
                </h1>
                <?= "<?= " ?> Breadcrumbs::widget(
                    [
                        'homeLink' => [
                            'label' => '<i class="fa fa-dashboard"></i> ' . Yii::t('app', '首页'),
                            'url' => '/'
                        ],
                        'encodeLabels' => false,
                        'tag' => 'ol',
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
                    ]
                ) ?>
            </section>

            <!-- Main content -->
            <section class="content">
                <?= "<?= " ?> Alert::widget(); ?>
                    <?= "<?= " ?> $content ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

    <?= "<?php " ?> $this->endBody(); ?>
    </body>
</html>
<?= "<?php " ?> $this->endPage(); ?>