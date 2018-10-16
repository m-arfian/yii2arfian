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
    
    public static function getUrl($path, $isAbsolute = false) {
        $param = \Yii::$app->params['s3cdn'];
        
        $cdnHosted = $param['enabled'];
        $cdnPath = self::base() . Url::to($path);
            
        if ($cdnHosted && file_exists($cdnPath)) {
            return $cdnPath;
        } else {
            return Url::to(Url::base() . $path, $isAbsolute);
        }
    }
    
    private static function base() {
        $param = \Yii::$app->params['s3cdn'];
        return "http://{$param['bucket']}{$param['host']}";
    }
    
}
