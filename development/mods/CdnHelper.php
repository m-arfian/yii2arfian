<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CdnHelper
 *
 * @author ARFIAN
 */

namespace yii2arfian\mods;

use yii\helpers\Url;

class CdnHelper {
    
    public static function getUrl($path, $isAbsolute = true, $cdnHosted = false) {
        $param = \Yii::$app->params['s3cdn'];
        $cdnPath = "http://{$param['bucket']}{$param['host']}" . Url::to($path);
            
        if ($cdnHosted /* && file_exists($cdnPath) */) {
            return $cdnPath;
        } else {
            return Url::to($path, $isAbsolute);
        }
    }
    
    public static function base() {
        $param = \Yii::$app->params['s3cdn'];
        return "http://{$param['bucket']}{$param['host']}";
    }
    
}
