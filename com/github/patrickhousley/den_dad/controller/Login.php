<?php

/**
 * Login is the login controller for the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage controller
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\controller;

use \com\github\patrickhousley\den_dad\lib\ControllerSettings;
use \com\github\patrickhousley\den_dad\view\login as LoginViews;

class Login {

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
     * <p>View is the default controller action. Being in the login controller,
     * this function will display the login page. If the user is already logged
     * in, the user will be directed to the index page.</p>
     */
    protected function View() {
        if (isset($_SESSION['login'])) {
            header('Location:/Index');
        }

        $this->settings->setView(new LoginViews\View());
        $this->settings->loadDefaultSettings();

        $secKey = md5(rand() . microtime() . $_SERVER['REMOTE_ADDR']);
        $this->settings->getView()->set('secKey', $secKey);
        $_SESSION['secKey'] = $secKey;

        if (isset($_SESSION['authError']) && trim($_SESSION['authError']) != '') {
            $this->settings->getView()->set('authError', trim($_SESSION['authError']));
            $_SESSION['authError'] = '';
        } else {
            $this->settings->getView()->set('authError', '');
        }

        $this->settings->getView()->render(true);
    }

}
