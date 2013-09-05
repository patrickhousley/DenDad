<?php

/**
 * ControllerSettings stores and makes available a controllers view, models, and
 * parameters.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\lib;

use \com\github\patrickhousley\den_dad\interfaces as AppInterfaces;
use \com\github\patrickhousley\den_dad\model as AppModels;

class ControllerSettings {
    /**
     * References the instantiated view registered for the controller.
     * @var com\github\patrickhousley\den_dad\interfaces\Viewable
     */
    private $view;
    
    /**
     * Array containing referance to all instantiated models for the controller.
     * @var array of com\github\patrickhousley\den_dad\interfaces\Modelable
     */
    private $models;
    
    /**
     * Array of parameters controller may use in the course of performing a specific
     * action.
     * @var array
     */
    private $parameters;
    
    /**
     * String containing the name of the action function that should be called
     * within the controller.
     * @var string
     */
    private $action;
    
    /**
     * Retrieve the current view.
     * @return com\github\patrickhousley\den_dad\interfaces\Viewable
     */
    public function getView() {
        return $this->view;
    }
    
    /**
     * Set the current view.
     * @param \com\github\patrickhousley\den_dad\interfaces\Viewable $view
     */
    public function setView(AppInterfaces\Viewable $view) {
        $this->view = $view;
    }
    
    /**
     * Retrieve a currently stored model. Null is returned if the model could
     * not be located.
     * @param string $modelName
     * @return com\github\patrickhousley\den_dad\interfaces\Modelable | null
     */
    public function getModel($modelName) {
        if (array_key_exists($modelName, $this->models)) {
            return $this->models[$modelName];
        }
        
        return null;
    }
    
    /**
     * Add a model to the current controller settings.
     * @param string $modelName
     * @param \com\github\patrickhousley\den_dad\interfaces\Modelable $model
     */
    public function setModel($modelName, AppInterfaces\Modelable $model) {
        $this->models[$modelName] = $model;
    }
    
    /**
     * Retrieve all currently stored parameters.
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }
    
    /**
     * Add a parameter to the controller setting.
     * @param string $paramValue
     */
    public function addParameter($paramValue) {
        $this->parameters[] = $paramValue;
    }
    
    /**
     * Retrieve the action the controller should invoke.
     * @return string
     */
    public function getAction() {
        return $this->action;
    }
    
    /**
     * Set the action the controller should invoke.
     * @param string $action
     */
    public function setAction($action) {
        $this->action = $action;
    }
    
    /**
     * Load the default models and view data for the application templates.
     * 
     * <p>This function will load the models and set the variables neccesssary
     * to properly display a page using the applications template files. These
     * template files contain dynamic content reliant upon various models. This
     * function assumes the controller is using these templates and has already
     * instantiated it's view class.</p>
     */
    public function loadDefaultSettings() {
        if (!isset($this->models['User'])) {
            if (isset($_SESSION['login'])) {
                $this->models['User'] = new AppModels\User($_SESSION['login']);
                $this->models['Den'] = new AppModels\Den($this->models['User']->get('den'));
                
                $this->view->set('userName', 
                        $this->models['User']->get('firstName') . ' ' .
                        $this->models['User']->get('lastName'));
                $this->view->set('userRole', $this->models['User']->get('role'));

                $this->view->set('packNumber', $this->models['Den']->get('packNumber'));
                $this->view->set('packNumberArray',
                        str_split(trim($this->models['Den']->get('packNumber')))
                );
                $this->view->set('denRank', $this->models['Den']->get('rank'));
            } else {
                $this->models['User'] = null;
                $this->models['Den'] = null;

                $this->view->set('userRole', $GLOBALS['DENDAD_CONFIG']['APP_ROLE_ANONYMOUS']);

                $this->view->set('denPack', null);
                $this->view->set('denPackArray', null);
                $this->view->set('denRank', null);
            }
        }
    }
}