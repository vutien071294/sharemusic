<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
        '//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'css/iCheck/flat/blue.css',
        'css/site.css',
        'css/dashboard.css',
        // 'plugins/morris/morris.css',
        // 'plugins/morris/morris.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        '//code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
        'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.min.js',
        // 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        // 'plugins/datepicker/bootstrap-datepicker.js',
        // 'plugins/daterangepicker/daterangepicker.js',
        // 'plugins/datepicker/bootstrap-datepicker.js',
        // '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
        // 'plugins/knob/jquery.knob.js',
        // 'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        // 'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        // 'plugins/morris/morris.min.js',
        // 'plugins/morris/morris.js',
        'js/app.min.js',      
        'js/bootstrap-filestyle.min.js',
        // 'js/dashboard.js',
        'js/configValidateForm.js',
        'js/numeral.min.js',
        // 'js/svg-donut-chart-framework.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
