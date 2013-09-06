<?php

/**
 * Error is the error controller for the DenDad application.
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
use \com\github\patrickhousley\den_dad\view\error as ErrorViews;

class Error {

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
     * <p>View is the default controller action. Being in the error controller,
     * this function will make use of the session lastExpection variable to display
     * the correct error message.</p>
     */
    protected function View() {
        $this->settings->setView(new ErrorViews\View());
        $this->settings->loadDefaultSettings();

        $error = null;
        if (isset($_SESSION['lastException']) && trim($_SESSION['lastException']) != '') {
            $error = unserialize($_SESSION['lastException']);

            $this->settings->getView()->set('errorMessage', $error->getMessage() .
                    'Please try your request again. If still unsuccessful,' .
                    ' please open a support request and provide the steps taken' .
                    ' to reach this error.');
        } else {
            $this->settings->getView()->set('errorMessage', 'No error was found. You may have navigated to this page by mistake.');
        }

        $this->settings->getView()->render(true);
    }

}
