<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace yii2arfian\iclass;

use yii\i18n\Formatter;
use kartik\helpers\Html;

/**
 * Description of CustomFormatter
 *
 * @author Arfian
 */
class iFormatter extends Formatter{
    
    public function asDisplayImage($value) {
        return Html::img(\Yii::$app->request->baseUrl . $value);
    }
    
    public function asEasyDate($value) {        
        if($value != null) {
            setlocale(LC_TIME, 'id-ID');
            return strftime("%d-%m-%Y", strtotime($value));
        }
        
        return null;
    }
    
    public function asEasyDateTime($value) {
        if($value != null) {
            setlocale(LC_TIME, 'id-ID');
            return strftime("%d-%m-%Y <small>%H:%M:%S</small>", strtotime($value));
        }
        
        return null;
    }
    
    public function asEasyTimestapDate($value) {        
        if($value != null) {
            return date('d-m-Y', $value);
        }
        
        return null;
    }
    
    public function asI18nNumber($value) {
        return str_replace(\Yii::$app->formatter->thousandSeparator, '', $value);
    }
    
    public function asRupiahNumber($value) {
        return '<span>Rp.</span> ' . number_format($value, 0, '', '.');
    }
    
    public function asFloatVal($value) {
        return floatval($value);
    }
    
    public function asEasyNumber($value) {
        return number_format($value, 0, '', '.');
    }
    
//    // untuk halaman detail barang
//    public function asDetailHarga($value) {  /* $value array */
//        $table = "<table class='table table-responsive table-bordered table-condensed'>";
//        foreach ($value as $name => $item) {
//            $table .= Html::tag('tr', Html::tag('th', $name).Html::tag('td', 'Rp. ' . number_format($item, 0, '', '.')));
//        }
//        
//        return $table . "</table>";
//    }
//    
//    // untuk halaman order barang
//    public function asDetailHargaKeranjang($value) {  /* $value array */
//        $table = "<table class='table table-responsive table-bordered table-condensed'>";
//        foreach ($value as $kode => $item) {
//            $harga = 'Rp. ' . number_format($item['NOMINAL'], 0, '', '.');
//            $button = Html::button('<i class="fa fa-shopping-cart"></i>', [
//                'class' => 'pull-right btn btn-success btn-xs', 'data-pjax' => 0,
//                'onclick' => "addkeranjang($kode, this)"
//            ]);
//            $table .= Html::tag('tr', Html::tag('th', $item['SATUAN']).Html::tag('td', $harga.$button));
//        }
//        
//        return $table . "</table>";
//    }
//    
//    // untuk halaman detail barang
//    public function asDetailSpesifikasi($value) {  /* $value array */
//        $table = "<table class='table table-responsive table-bordered table-condensed'>";
//        foreach ($value as $teks => $respon) {
//            $table .= Html::tag('tr', Html::tag('th', $teks));
//            $table .= Html::tag('tr', Html::tag('td', $respon));
//        }
//        
//        return $table . "</table>";
//    }
}
