<?php

namespace yii2arfian\interfaces;

/**
 *
 * @author Arfian
 */

interface StatusActionInterface {
    /*
     * Interfaces ini digunakan untuk membuat standar action dari controller
     * Digunakan untuk action dengan operasi ke model ActiveRecord
     * Menambahkan action aktifkan dan nonaktifkan yang berguna untuk proses perubahan status model
     */
    
    /*
     * Standar action untuk nonaktifkan data
     */
    public function actionNonaktifkan($id);
    
    /*
     * Standar action untuk aktifkan data
     */
    public function actionAktifkan($id);
    
    /*
     * Standar action untuk menghapus data
     */
    public function actionHapus($id);
}
