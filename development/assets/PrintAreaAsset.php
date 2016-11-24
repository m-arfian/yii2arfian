<?php

/**
 * Source: https://plugins.jquery.com/PrintArea/
 *
 * @author Arfian
 */

namespace yii2arfian\assets;

use yii\web\AssetBundle;

class PrintAreaAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'plugins/printarea/jquery.PrintArea.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

}
