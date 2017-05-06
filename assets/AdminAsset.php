<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/assets/admin/css/bootstrap.css',
        '/assets/admin/css/animate.css',
        '/assets/admin/css/datepicker3.css',
        '/assets/admin/font-awesome/css/font-awesome.css',
        '/assets/admin/css/style.css',
    ];
    public $js = [
        'assets/admin/js/bootstrap.js',
        'assets/admin/js/plugins/iCheck/icheck.min.js',
        'assets/admin/js/plugins/metisMenu/jquery.metisMenu.js',
        'assets/admin/js/plugins/slimscroll/jquery.slimscroll.min.js',
        'assets/admin/js/plugins/pace/pace.min.js',
        'assets/admin/js/inspinia.js',
        'assets/admin/js/plugins/datapicker/bootstrap-datepicker.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
