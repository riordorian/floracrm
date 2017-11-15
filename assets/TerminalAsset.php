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
class TerminalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/assets/admin/css/bootstrap.css?1',
        '/assets/admin/css/loader.css',

        '/assets/admin/font-awesome/css/font-awesome.css',
        '/assets/terminal/css/fullcalendar/fullcalendar.css',
        '/assets/admin/css/style.css',
        '/assets/terminal/css/style.css?',
    ];
    public $js = [
        'assets/admin/js/bootstrap.js',
        'assets/terminal/js/fullcalendar/moment.min.js',
        'assets/terminal/js/fullcalendar/fullcalendar.min.js',
        'assets/terminal/js/fullcalendar/ru.js',
        'assets/terminal/js/fullcalendar/gcal.js',
        'assets/admin/js/crm.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
