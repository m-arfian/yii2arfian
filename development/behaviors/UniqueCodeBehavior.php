<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace yii2arfian\behaviors;

use yii\base\InvalidConfigException;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use Yii;

/**
 * Description of UniqueCode
 *
 * @author ARFIAN
 */
class UniqueCodeBehavior extends AttributeBehavior {
    /* Attribut kolom tempat kode disimpan */

    public $uniqueAttribute;

    /* Event trigger */
    public $trigger = BaseActiveRecord::EVENT_BEFORE_INSERT;

    /* Prefix kode ditambahkan di depan kode */
    public $prefix = '';
    
    /* Prefix yang berasal dari data related dengan owner */
    public $rel_prefix = null;

    /* Suffix kode ditambahkan di belakang kode */
    public $suffix = '';
    
    /* Suffix yang berasal dari data related dengan owner */
    public $rel_suffix = null;

    /* Panjang karakter kode (tidak termasuk prefix dan suffix). MAX 32 */
    public $length;

    /* callable
     * belum digarap programnya
     */
    public $expression;
    
    /* Pemisah kode dengan affix */
    public $imploder = '';

    public $specialChar = false;

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [$this->trigger => $this->uniqueAttribute];
        }

        if (!empty($this->paramAttributes) && $this->paramOrder === null) {
            throw new InvalidConfigException('$paramOrder wajib diisi jika $paramAttributes diisi');
        }

        if ($this->length === null) {
            throw new InvalidConfigException('$length wajib diisi');
        }
    }

    protected function getValue($event) {
        /* @var $owner BaseActiveRecord */
        $this->relatedAffix();

        if (empty($this->owner->{$this->uniqueAttribute})) {
            $code = $this->setUnique();
        } else {
            $code = $this->owner->{$this->uniqueAttribute};
        }
        
        return $code;
    }
    
    private function relatedAffix() {
        if (!empty($this->rel_prefix)) {
            foreach ($this->rel_prefix as $rel) {
                $this->prefix .= ($this->owner->{$rel} . $this->imploder);
            }
        }
        
        if (!empty($this->rel_suffix)) {
            foreach ($this->rel_suffix as $rel) {
                $this->suffix .= ($this->imploder . $this->owner->{$rel});
            }
        }
    }

    private function setUnique() {
        // $randomString = $this->expression == null ? strtoupper(Yii::$app->security->generateRandomString()) : eval("{$this->expression};");
        $generated = strtoupper(Yii::$app->security->generateRandomString());
        if (!$this->specialChar) {
            $generated = preg_replace('/[^a-zA-Z0-9]/s', '', $generated);
        }

        $randomString = substr($generated, 0, $this->length);

//        throw new InvalidConfigException($randomString);
        return $this->prefix . $randomString . $this->suffix;
    }

}
