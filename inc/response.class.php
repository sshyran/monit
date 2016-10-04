<?php


class Monit_Response {


    public static $items = array();


    public static function analyze() {
        // Get sites from config
        $sites = Monit_Config::data('sites');

        if ( empty(self::$items) ) {
            return;
        }

        foreach ( $sites as $site ) {
            $url = (string)$site['url'];
            $md5 = md5($url);
            $identifier = (string)$site['identifier'];

            if ( empty(self::$items[$md5]) ) {
                continue;
            }

            $error = self::$items[$md5]['error'];
            $content = self::$items[$md5]['content'];

            if ( $error ) {
                self::_down($md5, $site, $error);
            } else if ( strpos($content, $identifier) === false ) {
                self::_down($md5, $site, 'Missing content string');
            } else {
                self::_up( $md5, $site );
            }
        }
    }


    protected static function _down($md5, $site, $error) {
        if ( ! Monit_Cache::exists($md5) ) {
            Monit_Notification::send( 'DOWN', $site, $error );

            Monit_Cache::create($md5);
        }
    }


    protected static function _up($md5, $site) {
        if ( Monit_Cache::exists($md5) ) {
            Monit_Notification::send(
                'UP',
                $site,
                sprintf(
                    'It was down for %s',
                    self::_human_time( time() - Monit_Cache::read($md5) )
                )
            );

            Monit_Cache::remove($md5);
        }
    }


    /**
    * Determines the difference between two timestamps in a human readable format.
    *
    * @param integer $time Unix timestamp from which the difference begins
    *
    * @return string Human readable time difference
    */

    protected static function _human_time($time) {
        $time = ( $time < 1 ) ? 1 : $time;

        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);

            return sprintf(
                '%d %s%s',
                $numberOfUnits,
                $text,
                ( $numberOfUnits > 1 ? 's' : '' )
            );
        }

    }
}