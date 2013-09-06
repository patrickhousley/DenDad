<?php

/**
 * Index is the default controller for the DenDad application.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage controller
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\controller;

use \com\github\patrickhousley\den_dad\lib\ControllerSettings;
use \com\github\patrickhousley\den_dad\view\index as IndexViews;

class Index {

    /**
     * Stores all settings for the current controller.
     * @var com\github\patirickhousley\den_dad\lib\ControllerSettings 
     */
    private $settings;

    public function __construct(ControllerSettings $settings) {
        $this->settings = $settings;
        $this->{$this->settings->getAction()}();
    }

    /**
     * View controller action function.
     * 
     * <p>View is the default controller action. Being in the Index controller,
     * this will instantiate the template and template variables so when the render
     * function is called, the DenDad home page is displayed.</p>
     */
    protected function View() {
        $this->settings->setView(new IndexViews\View());
        $this->settings->loadDefaultSettings();

        $this->settings->getView()->render();
    }

}
