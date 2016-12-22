<?php

namespace yii2arfian\mods;

use Yii;

require_once 'SendPulse/api/sendpulse.php';
//require_once 'SendPulse/api/sendpulseInterface.php';

class SendPulseSender {

    const SENDER_EMAIL = 'no-reply@diwarna.com';
    const SENDER_NAME = 'Diwarna.com';
    const API_USER_ID = '24dcb4f61b9092b73264df9f66a80a36';
    const API_SECRET = '93c7deec58b1faef1eb03d400fe320b1';
    const TOKEN_STORAGE = 'session';

    public static function TestEmail() {
        // Begin: proses pengiriman menggunakan sendpulse
        //$sPubKey = 'bb1928e9215925eec4b5adab79284f71';
        // define( 'API_USER_ID', '327053f88044a4ee3547b0ddbf5ec2dc' );
        // define( 'API_SECRET', '6ba417bf981be87f65e24067512831f9' );
        //
        // define( 'TOKEN_STORAGE', 'session' );

        $SPApiProxy = new \SendpulseApi(self::API_USER_ID, self::API_SECRET, self::TOKEN_STORAGE);

        // Send mail using SMTP
        $email = array(
            'html' => '<p>Hello!</p>',
            //'text' => 'text',
            'subject' => '[SENDPULSE][TEST]#02',
            'from' => array(
                'name' => 'No-Reply Diwarna',
                'email' => 'no-reply@diwarna.com'
            ),
            'to' => array(
                array(
                    'email' => 'muchammad.arfian@gmail.com'
                )
            )
        );
        var_dump($SPApiProxy->smtpSendMail($email));
        // End: proses pengiriman menggunakan sendpulse
    }

    private function initialize() {
        // define( 'API_USER_ID', '327053f88044a4ee3547b0ddbf5ec2dc' );
        // define( 'API_SECRET', '6ba417bf981be87f65e24067512831f9' );
        // define( 'TOKEN_STORAGE', 'session' );

        $SPApiProxy = new \SendpulseApi(self::API_USER_ID, self::API_SECRET, self::TOKEN_STORAGE);

        return $SPApiProxy;
    }

    public function sendMail($to, $from, $subject, $message) {
        $sender = $this->initialize();

        $email = array(
            'html' => $message,
            'text' => 'empty',
            'subject' => $subject,
            'from' => $from,
            'to' => $to
        );

        return $sender->smtpSendMail($email);
    }

}
