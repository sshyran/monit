<?php

class Monit_Config {


    protected static $file = 'config.json';

    public static $json = array();


    public static function read() {
        if ( ! $content = file_get_contents( self::$file ) ) {
            die( 'No config file!' );
        }

        self::$json = json_decode( $content, true );

        if ( json_last_error() !== JSON_ERROR_NONE ) {
            die( 'JSON parse error!' );
        }
    }


    public static function data($entry) {
        if ( empty(self::$json[$entry]) ) {
            die( 'Empty JSON entry' );
        }

        return self::$json[$entry];
    }
}
