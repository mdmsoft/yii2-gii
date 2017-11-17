<?php
/**
 * This is the template for generating a asset class within a theming.
 */

/* @var $this yii\web\AssetBundle */
/* @var $generator myzero1\gii\generators\theming\Generator */

$namespace = $generator->ns . '\\' . $generator->getThemingName($generator->themingID) . '\assets\common';

echo "<?php\n";
?>

namespace <?= $namespace ?>;

use yii\web\AssetBundle;

/**
 * FontAwesome asset for the `<?= $generator->getThemingName($generator->themingID) ?>` theming
 */

class FontAwesome extends AssetBundle
{
    public $sourcePath = '@bower/font-awesome';
    public $css = [
        'css/font-awesome.min.css'
    ];
}
