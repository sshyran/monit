<?php
/**
 * Monit
 *
 * @author Sergej Müller
 */


/**
 * Main class
 */

class Monit {


    public function __construct() {
        $time_start = microtime(true);

        Monit_Config::read();

        Monit_Curl::query();

        Monit_Response::analyze();

        die(
            sprintf(
                'Total execution time: %s seconds',
                round(microtime(true) - $time_start, 2)
            )
        );
    }
}


spl_autoload_register(
    function($class) {
        $available = array(
            'Monit_Config'       => 'config',
            'Monit_Cache'        => 'cache',
            'Monit_Curl'         => 'curl',
            'Monit_Response'     => 'response',
            'Monit_Notification' => 'notification'
        );

        if ( isset($available[$class]) ) {
            require_once(
                sprintf(
                    'inc/%s.class.php',
                    $available[$class]
                )
            );
        }
    }
);


new Monit();
