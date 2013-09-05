<?php

/**
 * Bootstrap sets up autloading, loads config information and finally calls the
 * controller factory to begin processing the user's request.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\lib;

use \InvalidArgumentException;
use \Exception;

class Bootstrap {

    /**
     * Initialize the DenDad application.
     * 
     * <p>The init function will initialize the application config settings, setup
     * autoloading functionality, set debugging parameters, and finally call
     * the controller factory to create the controller needed to handle the
     * user's request.</p>
     */
    public static function init() {
        session_start();
        set_exception_handler(array(__NAMESPACE__ . '\\Bootstrap', 'globalExceptionHandler'));
        spl_autoload_register(__NAMESPACE__ . '\\Bootstrap::autoload', true);

        $GLOBALS['DENDAD_CONFIG'] = require_once ROOT . DS . 'com' . DS .
                'github' . DS . 'patrickhousley' . DS . 'den_dad' . DS . 'config'
                . DS . 'Config.php';
        $GLOBALS['DENDAD_DB_CONFIG'] = require_once ROOT . DS . 'com' . DS .
                'github' . DS . 'patrickhousley' . DS . 'den_dad' . DS . 'config'
                . DS . 'DatabaseConfig.php';

        /**
         * Setup debugging
         */
        if ($GLOBALS['DENDAD_CONFIG']['APP_DEBUGGING']) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'off');
            ini_set('log_errors', 'on');
            ini_set('error_log', ROOT . DS . 'com' . DS .
                    'github' . DS . 'patrickhousley' . DS . 'den_dad' . DS . 'logs'
                    . DS . 'DenDad_' . date('m-d-Y') . '.log');
        }

        /**
         * Instantiate the controller requested by the user.
         */
        $controller = ControllerFactory::getController();

        if (!is_null($controller)) {
            echo('<div style="position:absolute;top:-150px;left:-150px;">' .
            round(microtime(true) - SCRIPT_START_MTIME, 4) . '</div>');
        }
    }

    /**
     * Autoloader for DenDad application.
     * 
     * <p>This function is registered using the spl_autoload_register function to
     * provide class autoloading functionality in the DenDad application.</p>
     * @param string $class
     * @throws \InvalidArgumentException when the provided fully-qualified class
     * name is not valid.
     */
    public static function autoload($class) {
        if (strpos($class, 'den_dad') !== FALSE) {
            $cls = explode('\\', $class);
            $includeLocation = ROOT;
            foreach ($cls as $loc) {
                $includeLocation .= DS . $loc;
            }
            $includeLocation .= '.php';

            if (!file_exists($includeLocation)) {
                throw new InvalidArgumentException('Requested page could not be found.', 0, new Exception('Autoload failed for file: ' . $includeLocation));
            }

            require_once $includeLocation;
        }
    }

    /**
     * Catch all unhandled application exceptions.
     * 
     * <p>Catch all unhandled application exceptions and assign it to the session
     * lastException variable. Once done, redirect the user to the Error controller
     * which will handle displaying the error to the user.</p>
     * @param \Exception $exception
     */
    public static function globalExceptionHandler(Exception $exception) {
        $_SESSION['lastException'] = serialize($exception);
        error_log($exception);
        header('Location:/Error');
    }

}