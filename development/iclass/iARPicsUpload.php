<?php

namespace yii2arfian\iclass;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Yii;
use yii2arfian\iclass\iActiveRecord;
use yii\helpers\ArrayHelper;
use yii2arfian\mods\CdnHelper;
use kartik\helpers\Html;

/**
 * Description of ActiveRecord
 *
 * @author ARFIAN
 */
class iARPicsUpload extends iActiveRecord {

    public $saveAsTo;
    protected $tempAttribute;
    protected $imageAttribute = [
        'url_lrg_size' => [
            'pre' => 'l',
            'size' => [1000],
            'placehold' => 'https://dummyimage.com/600x400/000/fff.jpg&text=Tanpa+gambar',
        ],
        'url_med_size' => [
            'pre' => 'm',
            'size' => [500],
            'placehold' => 'https://dummyimage.com/450x300/000/fff.jpg&text=Tanpa+gambar',
        ],
        'url_sml_size' => [
            'pre' => 's',
            'size' => [250],
            'placehold' => 'https://dummyimage.com/300x200/000/fff.jpg&text=Tanpa+gambar',
        ],
        'url_icon_size' => [
            'pre' => 'i',
            'size' => [80],
            'placehold' => 'https://dummyimage.com/100x67/000/fff.jpg&text=Tanpa+gambar',
        ],
        'url' => [
            'pre' => '',
            'size' => [],
            'placehold' => 'https://dummyimage.com/525x300/000/fff.jpg&text=Tanpa+gambar',
        ],
    ];

    const MAX_PARALLEL_UPLOAD = 50;

    // lokasi bisa berubah-ubah
    private $s3SupportFile, $simpleImageLibrary;

    public function init() {
        parent::init();

        $this->s3SupportFile = __DIR__ . '/../../S3.php';
        $this->simpleImageLibrary = __DIR__ . '/../../SimpleImage.php';
    }

    public function uploadImage($path, $resize = true) {
        $this->tempAttribute = UploadedFile::getInstance($this, 'url');
        $this->saveAsTo = $path;

        if (empty($this->tempAttribute)) {
            return false;
        }

        if ($resize) {
            return $this->uploadResizedImage();
        } else {
            return $this->uploadNormalImage();
        }
    }

    // kalau imagenya berupa instance, bukan gambar dari hasil upload langsung
    public function uploadImageInstance($instance, $path, $resize = true) {
        $this->tempAttribute = $instance;
        $this->saveAsTo = $path;

        if (empty($this->tempAttribute)) {
            return false;
        }

        if ($resize) {
            return $this->uploadResizedImage();
        } else {
            return $this->uploadNormalImage();
        }
    }

    public function uploadImageS3($instance, $path, $resize = true) {
//        Yii::$classMap['common\models\S3'] = '@common/classes/S3.php';
        require_once ($this->s3SupportFile);

        $this->tempAttribute = $instance;
        $this->saveAsTo = $path;
        if (empty($this->tempAttribute)) {
            return false;
        }

        if ($resize) {
            return $this->uploadResizedImage('S3', [
                        'acl' => \S3::ACL_PUBLIC_READ
            ]);
        }
    }

    protected function resizeToWidth($size) {
        require_once ($this->simpleImageLibrary);

        $newImage = new \SimpleImage();
        $newImage->load($this->tempAttribute->tempName);
        $newImage->resizeToWidth($size);

        return $newImage;
    }

    protected function uploadResizedImage($location = null, $param = []) {
        $fileName = explode('.', $this->tempAttribute->name);

        foreach ($this->imageAttribute as $name => $attr) {
            do {
                $rand = rand(0, 999);
                $path = "$this->saveAsTo/{$rand}-{$fileName[0]}_{$attr['pre']}." . end($fileName);
                $absoPath = Yii::$app->basePath . "/web{$path}";
            } while (file_exists($absoPath));

            $absoDir = Yii::$app->basePath . "/web{$this->saveAsTo}";

            if (!file_exists($absoDir)) {
                if (!mkdir($absoDir, 0755)) {
                    throw new \yii\db\Exception('Upload direktori gagal.');
                }
            }

            $resizedImages = empty($attr['size']) ? $this->tempAttribute : $this->resizeToWidth($attr['size'][0]);
            if (!$resizedImages->saveAs($absoPath)) {
                throw new \PDOException("Gambar tidak bisa disimpan kedalam $path");
            }

            switch ($location) {
                case 'S3':
                    require_once ($this->s3SupportFile);
                    $s3Cdn = new \S3(Yii::$app->params['s3cdn']['access-key'], Yii::$app->params['s3cdn']['secret-key']);
                    if (!$s3Cdn->putObjectFile($absoPath, Yii::$app->params['s3cdn']['bucket'], ltrim($path, '/'), $param['acl'])) {
                        throw new \PDOException("Gambar tidak bisa diupload ke S3: $path");
                    }
                    break;
                case 'ftp':
                default :
                    break;
            }

            $this->{$name} = $path;
        }

        return true;
    }

    protected function uploadNormalImage() {
        /* $normalPath = "$this->saveAsTo/{$this->tempAttribute->name}";
          if (!$this->tempAttribute->saveAs(Yii::$app->basePath . "/web{$normalPath}")) {
          throw new \PDOException("Gambar tidak bisa disimpan kedalam $normalPath");
          }

          $this->url = $normalPath;
         */

        $path = "$this->saveAsTo/{$this->tempAttribute->name}";
        $absoPath = Yii::$app->basePath . "/web{$path}";
        $absoDir = Yii::$app->basePath . "/web{$this->saveAsTo}";
        if (!file_exists($absoDir)) {
            if (!mkdir($absoDir, 0755)) {
                throw new \yii\db\Exception('Upload direktori gagal.');
            }
        }

        if (!$this->tempAttribute->saveAs($absoPath)) {
            throw new \PDOException("Gambar tidak bisa disimpan kedalam $path");
        }

        $this->url = $path;

        return true;
    }

    public function viewImg($url, $options = []) {
        return Html::img(CdnHelper::getUrl($url), $options);
    }

    public static function noImagePlaceholder($options = [
        'size' => '525x300', 'textColor' => 'fff', 'bgColor' => '000', 'textContent' => 'Tanpa gambar'
    ], $htmlOptions = []) {
        return Html::img("https://dummyimage.com/{$options['size']}/{$options['bgColor']}/{$options['textColor']}.jpg&text={$options['textContent']}", $htmlOptions);
    }

//put your code here
}
