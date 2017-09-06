<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StaticFormatter
 *
 * @author ARFIAN
 */

namespace yii2arfian\mods;

use yii\helpers\Url;
use yii2arfian\iclass\iFormatter;

class StaticFormatter {
    
    public static function asRupiahNumber($value) {
        $format = new iFormatter;
        return $format->asRupiahNumber($value);
    }
    
    public static function asEasyNumber($value) {
        $format = new iFormatter;
        return $format->asEasyNumber($value);
    }
    
    public static function asEasyDate($value) {        
        $format = new iFormatter;
        return $format->asEasyDate($value);
    }
    
}
