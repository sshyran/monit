<?php


class Monit_Curl {


    public static function query() {
        // Get sites from config
        $sites = Monit_Config::data('sites');

        $mh = curl_multi_init();

        foreach ( $sites as $site ) {
            if ( ! $site['active'] ) {
                continue;
            }

            $url = (string)$site['url'];
            $timeout = (int)$site['timeout'];
            $md5 = md5($url);

            $ch[$md5] = curl_init( $url );

            curl_setopt( $ch[$md5], CURLOPT_USERAGENT, 'Mozilla/2.02Gold (Win95; I)');
            curl_setopt( $ch[$md5], CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch[$md5], CURLOPT_SSL_VERIFYPEER, 1 );
            curl_setopt( $ch[$md5], CURLOPT_FOLLOWLOCATION, 1 );

            curl_setopt( $ch[$md5], CURLOPT_CONNECTTIMEOUT, $timeout );

            curl_multi_add_handle($mh, $ch[$md5]);
        }

        do {
            $status = curl_multi_exec($mh, $active);
        } while ( $status === CURLM_CALL_MULTI_PERFORM || $active );

        foreach ( $sites as $site ) {
            if ( ! $site['active'] ) {
                continue;
            }

            $url = (string)$site['url'];
            $md5 = md5($url);

            Monit_Response::$items[$md5] = array(
                'error' => self::_handle_errors($ch[$md5]),
                'content' => null
            );

            if ( ! Monit_Response::$items[$md5]['error'] ) {
                Monit_Response::$items[$md5]['content'] = curl_multi_getcontent($ch[$md5]);
            }

            curl_multi_remove_handle($mh, $ch[$md5]);
        }

        curl_multi_close($mh);
    }


    protected static function _handle_errors($handle) {
        if ( $error = curl_error($handle) ) {
            return $error;
        }

        $info = curl_getinfo($handle);

        if ( $info['http_code'] !== 200 ) {
            return sprintf( 'Status code %d received', $info['http_code'] );
        }
        if ( $info['ssl_verify_result'] !== 0 ) {
            return sprintf( 'SSL verify code %d received', $info['ssl_verify_result'] );
        }
        if ( $info['redirect_count'] !== 0 ) {
            return sprintf( 'Redirect count is %d', $info['redirect_count'] );
        }

        return false;
    }
}
