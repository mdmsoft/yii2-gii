<?php
/**
 * This is the template for generating a asset class within a theming.
 */

/* @var $this yii\web\AssetBundle */
/* @var $generator myzero1\gii\generators\theming\Generator */

$namespace = $generator->ns . '\\' . $generator->getThemingName($generator->themingID) . '\assets\common';

$fontAwesome =  '\\' . $namespace . '\FontAwesome';
$jquerySlimScroll = '\\' . $namespace . '\JquerySlimScroll';

echo "<?php\n";
?>

namespace <?= $namespace ?>;

use yii\web\AssetBundle;

/**
 * Html5shiv asset for the `<?= $generator->getThemingName($generator->themingID) ?>` theming
 */

class AdminLte extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte/dist';
    public $js = [
        'js/app.min.js'
    ];
    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        '<?= $fontAwesome?>',
        '<?= $jquerySlimScroll?>',
    ];
}
