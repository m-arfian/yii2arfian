<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace yii2arfian\assets;

use yii\web\AssetBundle;

/**
 * Description of MetronicAsset
 *
 * @author Arfian
 */
class GoogleFontAsset extends AssetBundle{
    public $sourcePath = null;
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,900&amp;subset=all',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all'
    ];
}
