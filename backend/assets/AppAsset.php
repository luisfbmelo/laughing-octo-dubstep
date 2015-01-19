<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//normalize-css.googlecode.com/svn/trunk/normalize.css',
        'css/site.css',
        'css/main.css',
        'css/jquery-ui.css',
        'css/colpick.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'
    ];
    public $js = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js',
        'js/script.js',
        '//code.jquery.com/ui/1.11.2/jquery-ui.js',
        'js/jquery.ui.autocomplete.html.js',
        'js/colpick.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );

    //STOP BOOTSTRAP FROM LOADING
    /*public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        Yii::$app->assetManager->bundles['yii\bootstrap\BootstrapAsset'] = [
            'css' => []
        ];
    }*/
}
