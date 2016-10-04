<?php


class Monit_Notification {


    public static function send($type, $site, $msg) {
        $name = $site['name'];
        $receiver = $site['receiver'];
        $sender = Monit_Config::data('app')['sender'];

        // echo sprintf(
        //     "%s // %s%s\n\n",
        //     sprintf( 'Website is %s: %s', $type, $name ),
        //     sprintf( 'Reason: %s', $msg ),
        //     sprintf( 'From: %s', $sender )
        // );

        // return;

        mail(
            implode(', ', $receiver),
            sprintf( 'Website is %s: %s', $type, $name ),
            sprintf( '%s', $msg ),
            sprintf( 'From: %s', $sender )
        );
    }
}
