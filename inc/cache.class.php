<?php



class Monit_Cache {


    public static function exists($md5) {
        return file_exists(
            self::_file($md5)
        );
    }


    public static function read($md5) {
        return file_get_contents(
            self::_file($md5)
        );
    }


    public static function create($md5) {
        file_put_contents(
            self::_file($md5),
            time()
        );
    }


    public static function remove($md5) {
        unlink(
            self::_file($md5)
        );
    }


    protected static function _file($md5) {
        return sprintf(
            '%s/../%s%s',
            pathinfo(__FILE__, PATHINFO_DIRNAME),
            Monit_Config::data('app')['cache'],
            $md5
        );
    }
}