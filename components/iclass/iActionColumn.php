<?php

namespace yii2arfian\iclass;

use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn;

/**
 * Description of CustomActionColumn
 *
 * @author Arfian
 */
class iActionColumn extends ActionColumn {

    public $template = '{detail} {edit} {aktifkan} {nonaktifkan} {hapus}';

    protected function initDefaultButtons() {
        parent::initDefaultButtons();

        if (!isset($this->buttons['detail'])) {
            $this->buttons['detail'] = function ($url, $model, $key) {
                return self::buttonDetail($url);
            };
        }
        if (!isset($this->buttons['edit'])) {
            $this->buttons['edit'] = function ($url, $model, $key) {
                return self::buttonPerbarui($url);
            };
        }
        if (!isset($this->buttons['hapus'])) {
            $this->buttons['hapus'] = function ($url, $model, $key) {
                return self::buttonHapus($url);
            };
        }
        if (!isset($this->buttons['nonaktifkan'])) {
            $this->buttons['nonaktifkan'] = function ($url, $model, $key) {
                return self::buttonNonaktifkan($url);
            };
        }
        if (!isset($this->buttons['aktifkan'])) {
            $this->buttons['aktifkan'] = function ($url, $model, $key) {
                return self::buttonAktifkan($url);
            };
        }
    }

    protected function renderDataCellContent($model, $key, $index) {
        $base = preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);

                return '<li>' . call_user_func($this->buttons[$name], $url, $model, $key) . '</li>';
            } else {
                return '';
            }
        }, $this->template);

        return
        '<div class="btn-group">
            <button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cogs"></i>
            </button>
            <ul class="dropdown-menu" role="menu">' . $base . '</ul>
        </div>';
    }

    public static function buttonHapus($url, $pjaxId = 0) {
        $options = ['title' => Yii::t('yii', 'Hapus'), 'data-pjax' => $pjaxId];
        
        if (empty($pjaxId)) {
            $options += [
                'data-confirm' => Yii::t('yii', 'Anda yakin ingin menghapus data ini?'),
                'data-method' => 'post'
            ];
        }
        
        return Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', $url, $options);
    }

    public static function buttonNonaktifkan($url, $pjaxId = 0) {
        $options = ['title' => Yii::t('yii', 'Nonaktifkan'), 'data-pjax' => $pjaxId];
        
        if (empty($pjaxId)) {
            $options += [
                'data-confirm' => Yii::t('yii', 'Anda yakin ingin menonaktifkan data ini?'),
                'data-method' => 'post'
            ];
        }
        
        return Html::a('<span class="glyphicon glyphicon-ban-circle"></span> Nonaktifkan', $url, $options);
    }

    public static function buttonAktifkan($url, $pjaxId = 0) {
        $options = ['title' => Yii::t('yii', 'Aktifkan'), 'data-pjax' => $pjaxId];
        
        if (empty($pjaxId)) {
            $options += [
                'data-confirm' => Yii::t('yii', 'Anda yakin ingin mengaktifkan data ini?'),
                'data-method' => 'post'
            ];
        }
        
        return Html::a('<span class="glyphicon glyphicon-check"></span> Aktifkan', $url, $options);
    }

    public static function buttonPerbarui($url) {
        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Edit', $url, [
            'title' => Yii::t('yii', 'Edit'),
            'data-pjax' => 0
        ]);
    }

    public static function buttonDetail($url) {
        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Detail', $url, [
            'title' => Yii::t('yii', 'Detail'),
            'data-pjax' => 0
        ]);
    }
    
    public static function buttonCustom($url, $label, $pjaxId = 0) {
        return Html::a($label, $url, [
            'title' => Yii::t('yii', strip_tags($label)),
            'data-pjax' => $pjaxId
        ]);
    }

}
