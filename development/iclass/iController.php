<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace yii2arfian\iclass;

/**
 * Description of iController
 *
 * @author ARFIAN
 */

use Yii;
use yii\web\Controller;
use yii2arfian\interfaces\StatusActionInterface;
use yii2arfian\interfaces\Statusable;

class iController extends Controller implements StatusActionInterface {
    
    private $searchModel, $model;
    
    public function actionAktifkan($id) {
        $this->findModel($id)->updateAttributes(['status' => Statusable::STATUS_ACTIVE]);
        if (Yii::$app->getRequest()->isAjax) {
            $this->partialGrid();
        }
        
        return $this->redirect(['index'] + Yii::$app->request->queryParams);
    }

    public function actionNonaktifkan($id) {
        $this->findModel($id)->updateAttributes(['status' => Statusable::STATUS_NONACTIVE]);
        if (Yii::$app->getRequest()->isAjax) {
            $this->partialGrid();
        }
        
        return $this->redirect(['index'] + Yii::$app->request->queryParams);
    }

    public function actionHapus($id) {
        $this->findModel($id)->updateAttributes(['status' => Statusable::STATUS_DELETED]);
        if (Yii::$app->getRequest()->isAjax) {
            $this->partialGrid();
        }
        
        return $this->redirect(['index'] + Yii::$app->request->queryParams);
    }
    
    private function partialGrid() {
        $search = new $this->searchModel;
        return $this->renderPartial('index', [
            'dataProvider' => $search->search(Yii::$app->request->queryParams),
            'searchModel' => $search,
        ]);
    }
    
    /**
     * Mengeset nama dari model search
     * @param string $model
     */
    public function setSearchModel($model) {
        $this->searchModel = $model;
    }
    
    /**
     * Return nama model search
     * @return string
     */
    public function getSearchModel() {
        return $this->searchModel;
    }

//put your code here
}
