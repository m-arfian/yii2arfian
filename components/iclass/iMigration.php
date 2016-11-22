<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace yii2arfian\iclass;

/**
 * Description of iNotFoundHttpException
 *
 * @author ARFIAN
 */
use yii\db\Migration;

class iMigration extends Migration {

    public function createView($name, $defQuery) {
        echo "    > create view $name ...";
        $time = microtime(true);
        $this->db->createCommand("create view $name as $defQuery")->execute();
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }
    
    public function replaceView($name, $defQuery) {
        echo "    > replace view $name ...";
        $time = microtime(true);
        $this->db->createCommand("create or replace view $name as $defQuery")->execute();
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

    public function dropView($name) {
        echo "    > drop view $name ...";
        $time = microtime(true);
        $this->db->createCommand("drop view `$name`")->execute();
        echo ' done (time: ' . sprintf('%.3f', microtime(true) - $time) . "s)\n";
    }

}
