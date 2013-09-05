<?php

/**
 * ControllerFactory parses the URI requested for information pertaining to which
 * controller will be instantiated and which action of the controller will be
 * called.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\lib;

class ControllerFactory {

    /**
     * Factory function used to create controllers.
     * 
     * @return \com\github\patrickhousley\den_dad\controller Controller
     */
    public static function getController() {
        $controlerSettings = new ControllerSettings();
        
        $url = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = (isset($url[1]) && trim($url[1]) != '') ?
                ucfirst(trim($url[1])) :
                $GLOBALS['DENDAD_CONFIG']['DEFAULT_CONTROLLER'];
        $action = (isset($url[2]) && trim($url[2]) != '') ?
                ucfirst(trim($url[2])) :
                $GLOBALS['DENDAD_CONFIG']['DEFAULT_ACTION'];
        $parameters = (count($url) > 3) ? array_splice($url, 3) : array();
        $controllerFQN = 'com\\github\\patrickhousley\\den_dad\\controller\\' .
                $controllerName;
        
        
        foreach ($parameters as $parameter) {
            $controlerSettings->addParameter($parameter);
        }
        $controlerSettings->setAction($action);
        
        return new $controllerFQN($controlerSettings);
    }
}