<?php

namespace yii2arfian\interfaces;

/**
 *
 * @author Arfian
 */

interface Statusable {
    /*
     * Interfaces ini digunakan untuk membuat standar fungsi yang berlaku untuk model keturunan \yii\db\ActiveRecord
     * Penetapan nama dan nilai konstanta yang global dan fungsi-fungsi standar pembantu yang menggunakan konstanta status
     */
    
    const STATUS_ACTIVE = 1, STATUS_NONACTIVE = 0, STATUS_DELETED = -1;
    
    /**
     * @return \yii\db\ActiveQuery;
     */
    public static function getActiveData();
    
    /**
     * @return \yii\db\ActiveQuery;
     */
    public static function getNonactiveData();
    
    /**
     * @return \yii\db\ActiveQuery;
     */
    public static function getDeletedData();
    
    public function listStatus();
}
