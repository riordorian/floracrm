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
        '/assets/admin/css/bootstrap.css?1',
        '/assets/admin/css/loader.css',
        '/assets/admin/css/animate.css',

        /*CHOSEN*/
        '/assets/admin/css/plugins/chosen/chosen.css',
        '/assets/admin/css/plugins/chosen/bootstrap-chosen.css',

        /*DATAPICKER*/
        '/assets/admin/css/plugins/datapicker/datepicker3.css',

        /*ICHEK*/
        '/assets/admin/css/plugins/iCheck/custom.css',

        '/assets/admin/font-awesome/css/font-awesome.css',
        '/assets/admin/css/style.css',
        '/assets/admin/css/custom.css',
    ];
    public $js = [
        'assets/admin/js/bootstrap.js',

        'assets/admin/js/plugins/metisMenu/jquery.metisMenu.js',

        /*CHOSEN*/
        'assets/admin/js/plugins/chosen/chosen.jquery.js',

        /*ICHECK*/
        'assets/admin/js/plugins/iCheck/icheck.min.js'
        ,
        'assets/admin/js/plugins/slimscroll/jquery.slimscroll.min.js',
//        'assets/admin/js/plugins/pace/pace.min.js',

        /*DATAPICKER*/
        'assets/admin/js/plugins/datapicker/bootstrap-datepicker.js',

        /*MASKED INPUT*/
        'assets/admin/js/plugins/jasny/jasny-bootstrap.min.js',

        'assets/admin/js/inspinia.js',
        'assets/admin/js/crm.js',
        'assets/admin/js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
