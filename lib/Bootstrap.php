<?php
/**
 * Bootstrap sets up autloading, loads config information and finally instantiates
 * the appropriate controller based on the URL.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\lib;

class Bootstrap {
    /**
     * Initialize the DenDad application.
     * 
     * <p>The init function will initialize the application config settings, setup
     * autoloading functionality, set debugging parameters and finaly instantiate
     * the router class to route the users request.</p>
     */
    public static function init() {
        session_start();
        \set_exception_handler(array(__NAMESPACE__ . '\\Bootstrap', 'globalExceptionHandler'));
        \spl_autoload_register(__NAMESPACE__ . '\\Bootstrap::autoload', true);
        
        /**
         * Setup debugging
         */
        if (\DenDad\config\Config::APP_DEBUGGING) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'off');
            ini_set('log_errors', 'on');
            ini_set('error_log', ROOT . DS .'application' . DS . 'logs' . DS .
                    'errors.log');
        }

        /**
         * Instantiate the controller requested by the user.
         */
        $url = \explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = (isset($url[1]) && trim($url[1]) != '') ? 
                \ucfirst(\trim($url[1])) : \DenDad\config\Config::DEFAULT_CONTROLLER;
        $action = (isset($url[2]) && \trim($url[2]) != '') ? 
                \ucfirst(\trim($url[2])) : \DenDad\config\Config::DEFAULT_ACTION;
        $parameters = (count($url) > 3) ? \array_splice($url, 3) : array();
        $c = '\\DenDad\\controllers\\' . $controllerName;
        $controller = null;
        
        /**
         * Check if the requested page exists. If it does not, throw a new controller
         * exception.
         */
        if (!\file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . 
                $controllerName . '.php')) {
            throw new \DenDad\exceptions\ControllerException('Requested page ' .
                    $controllerName . ' does not exist.');
        }
        $controller = new $c($action, $parameters);
        
        if (!is_null($controller)) {
            echo('<div style="position:absolute;top:-150px;left:-150px;">' .
                    \round(\microtime(true) - SCRIPT_START_MTIME, 4) . '</div>');
        }
    }

    /**
     * Autoloader for DenDad application.
     * 
     * <p>This function is registered using the spl_autoload_register function to
     * provide class autoloading functionality in the DenDad application.</p>
     * @param string $class Name of the class, including namespace, to be loaded.
     * @throws \DenDad\exceptions\AutoloadException
     */
    public static function autoload($class) {
        $cls = explode('\\', $class);
        switch ($cls[0]) {
            case 'DenDad' :
                if ($cls[1] == 'views') {
                    if (!file_exists(ROOT . DS . 'application' . DS . $cls[1] .
                            DS . $cls[2] . DS . $cls[3] . '.php')) {
                        throw new \DenDad\exceptions\AutoloadException('Unable' .
                                ' to locate the the requested class file: ' . $class);
                    }
                    require_once ROOT . DS . 'application' . DS . $cls[1] .
                            DS . $cls[2] . DS . $cls[3] . '.php';
                } else if (count($cls) == 3) {
                    if (!file_exists(ROOT . DS . 'application' . DS . $cls[1] .
                            DS . $cls[2] . '.php')) {
                        throw new \DenDad\exceptions\AutoloadException('Unable' .
                                ' to locate the the requested class file: ' . $class);
                    }
                    require_once ROOT . DS . 'application' . DS . $cls[1] .
                            DS . $cls[2] . '.php';
                } else {
                    throw new \DenDad\exceptions\AutoloadException('Invalid' .
                            ' number of arguments supplied for class autload. ' .
                            'Please check the namespace\classname: ' . $class);
                }
        }
    }
    
    /**
     * Catch all unhandled application exceptions.
     * 
     * <p>Catch all unhandled application exceptions and assign it to the session
     * lastException variable. Once done, redirect the user to the Error controller
     * which will handle displaying the error to the user.</p>
     * @param \Exception $exception Unhandled exception.`
     */
    public static function globalExceptionHandler($exception) {
        $_SESSION['lastException'] = \serialize($exception);
        \header('Location:/Error');
    }
}