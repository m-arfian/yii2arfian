<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace yii2arfian\mods;

use Yii;

/**
 * Description of MandrillSend
 *
 * @author ARFIAN
 */
require_once 'mandrill/Mandrill.php';

class MandrillMail {
    
    private $apikey = 'jIkVin06FAp78R_h2OGbaA';
//    private $template = '@common/mail/email-order.php';
    private $from_name = 'Diwarna.com';
    
//    public $akun, $to_email, $to_name, $kode_booking, 
//           $grup, $program, $tgl_berangkat, $kontak, 
//           $subject, $jenis, $referensi, $request_order;
    
    public $to_name, $to_email, $subject, $template, $content, $params = [];

    public function send() {
        try {
            $mandrill = new \Mandrill($this->apikey);

            // from
            $from_email = Yii::$app->params['supportEmail'];

            // Mail it
            $message = array(
                'html' => Yii::$app->controller->renderPartial($this->template, [
                    'subject' => $this->subject,
                    'params' => $this->params,
                    'content' => $this->content
                ]),
                'subject' => $this->subject,
                'from_email' => $from_email,
                'from_name' => $this->from_name,
                'to' => array(
                    array(
                        'email' => $this->to_email,
                        'name' => $this->to_name,
                        'type' => 'to'
                    ), array(
                        'email' => Yii::$app->params['adminEmail'],
                        'name' => "$this->to_name - [BCC Diwarna.com]",
                        'type' => 'bcc'
                    )
                ),
                'headers' => array('Reply-To' => $from_email),
                'preserve_recipients' => true
            );

            $result = $mandrill->messages->send($message, false, null, null);

        } catch (\Mandrill_Error $ex) {
            echo 'A mandrill error occurred: ' . get_class($ex) . ' - ' . $ex->getMessage();
        }
    }

}
