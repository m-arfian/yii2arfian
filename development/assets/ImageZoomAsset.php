<?php

/**
 * Source: http://www.elevateweb.co.uk/image-zoom/
 *
 * @author Arfian
 */

namespace yii2arfian\assets;

use yii\web\AssetBundle;

class ImageZoomAsset extends AssetBundle {
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'plugins/elevatezoom/jquery.elevateZoom-3.0.8.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

}
