<?php
/**
 * @package yii2-ztree
 */
namespace adminlte\widgets\ztree;
use Yii;
use yii\web\AssetBundle;
/**
 * Asset bundle for ZTree Widget
 *
 * @author li yuze
 */
class ZTreeAsset extends AssetBundle
{
    public $sourcePath = '@adminlte/widgets/ztree/assets';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => true,
        // 'forceCopy' => YII_DEBUG,
    ];

    public $js = [
        'js/jquery.ztree.all-3.5.min.js',      //完整包
        // 'js/jquery.ztree.all-3.5.js',
        // 'js/jquery.ztree.core-3.5.min.js',     //核心包
        // 'js/jquery.ztree.core-3.5.js',
        // 'js/jquery.ztree.excheck-3.5.min.js',  //excheck 扩展包
        // 'js/jquery.ztree.excheck-3.5.js',
        // 'js/jquery.ztree.exedit-3.5.min.js',   //exedit 扩展包
        // 'js/jquery.ztree.exedit-3.5.js',
        // 'js/jquery.ztree.exhide-3.5.min.js',   //exhide 扩展包
        // 'js/jquery.ztree.exhide-3.5.js',
        // 'js/jquery-1.4.4.min.js',
    ];

    public $css = [
        #皮肤样式
        'css/zTreeStyle/zTreeStyle.css',
        // 'css/awesomeStyle/awesome.css',
        // 'css/metroStyle/metroStyle.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

}