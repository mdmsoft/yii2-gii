<?php
/**
 * This is the template for generating a asset class within a theming.
 */

/* @var $this yii\web\AssetBundle */
/* @var $generator myzero1\gii\generators\theming\Generator */

$namespaceOld = $generator->ns . '\\' . $generator->getThemingName($generator->themingID);
$AlertMenuClass = $namespaceOld . '\widgets\Menu';

echo "<?php\n";
?>

/**
 * Sidebar menu layout.
 *
 * @var \yii\web\View $this View
 */

use <?= $AlertMenuClass ?>;

    $items = [
        [
            'label' => Yii::t('app', '产品管理后台首页'),
            'url' => Yii::$app->homeUrl,
            'icon' => 'fa-dashboard',
            'active' => Yii::$app->request->url === Yii::$app->homeUrl
        ],
        [
            'label' => Yii::t('app', '产品管理'),
            'url' => '#',
            'icon' => ' fa-cubes',
            'visible' => true,
            'items' => [
                [
                    'label' => Yii::t('app', '产品列表'),
                    'url' => ['/product/index'],
                    'visible' => true
                ],
                [
                    'label' => Yii::t('app', '升级列表'),
                    'url' => ['/upgrade/index'],
                    'visible' => true
                ],
                [
                    'label' => Yii::t('app', '公告列表'),
                    'url' => ['/affiche/index'],
                    'visible' => true
                ],
            ]
        ],
    ];

    $sMenuItems = Yii::$app->session->get('aMenuItems');
    if (1||is_null($sMenuItems)) {
        if (isset(Yii::$app->modules['app'])) {
            $itemsNew = \rbacp\components\Rbacp::getMenuItems(Yii::$app->user->id, $items);
        } else {
            $itemsNew = $items;
        }
        Yii::$app->session->set('aMenuItems', json_encode($itemsNew));
    } else {
        $itemsNew = json_decode($sMenuItems, TRUE);
    }

    echo Menu::widget(
        [
            'options' => [
                'class' => 'sidebar-menu'
            ],
            // 'items' => Yii::$app->params['menu'],
            'items' => $itemsNew
        ]
    );

?>