<?php

namespace yii2arfian\interfaces;

/**
 *
 * @author Arfian
 */

interface Listable {
    /*
     * Interfaces ini digunakan untuk membuat standar fungsi yang berlaku untuk model keturunan \yii\db\ActiveRecord
     * Hasil fungsi dari Listable digunakan untuk parameter dropdown atau kebutuhan foreach dari data.
     */
    
    /*
     * Standar untuk membuat list semua data
     */
    public static function listAll($text, $key);
    
    /*
     * Standar untuk membuat list data dengan kondisi
     */
    public static function listAllByAttributes($condition, $text, $key);
}
