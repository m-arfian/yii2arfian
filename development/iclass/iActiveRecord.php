<?php

namespace yii2arfian\iclass;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
use yii2arfian\interfaces\Listable;
use yii2arfian\interfaces\Statusable;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Description of ActiveRecord
 *
 * @author ARFIAN
 */
class iActiveRecord extends ActiveRecord implements Listable, Statusable {
    
    public $options;
    
    public function listStatus() {
        return [
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_NONACTIVE => 'Nonaktif',
            self::STATUS_DELETED => 'Dihapus'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery;
     */
    public static function getActiveData() {
        return self::find()->where(parent::tableName() . '.status = :status', [':status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery;
     */
    public static function getNonactiveData() {
        return self::find()->where(parent::tableName() . '.status = :status', [':status' => self::STATUS_NONACTIVE]);
    }

    /**
     * @return \yii\db\ActiveQuery;
     */
    public static function getDeletedData() {
        return self::find()->where(parent::tableName() . '.status = :status', [':status' => self::STATUS_DELETED]);
    }

    public static function listAll($text = 'name', $key = 'id', $orderBy = 'name') {
        // return self::listMaker(self::find()->orderBy('name')->all(), $text, $key);
        return ArrayHelper::map(self::find()->orderBy($orderBy)->all(), $key, $text);
    }

    public static function listAllByAttributes($condition, $text = 'name', $key = 'id', $orderBy = 'name') {
        return ArrayHelper::map(self::find()->where($condition)->orderBy($orderBy)->all(), $key, $text);
    }
    
    public static function listAllActive($text = 'name', $key = 'id', $orderBy = 'name') {
        return ArrayHelper::map(self::getActiveData()->orderBy($orderBy)->all(), $key, $text);
    }
    
    /* private static function listMaker($dataObjects, $text, $key) {
        $list = [];
        foreach ($dataObjects as $row) {
            $list[$row->{$key}] = $row->{$text};
        }
        
        return $list;
    } */
    
    public static function statusText($value) {
        switch ($value) {
            case self::STATUS_NONACTIVE:
                return '<span class="label label-danger"> </span>';
            case self::STATUS_ACTIVE:
                return '<span class="label label-success"> </span>';
            case self::STATUS_DELETED:
                return '<span class="label label-default"> </span>';
            default:
                return '';
        }
    }

//put your code here
}
