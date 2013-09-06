<?php
/**
 * Account is the account management controller for the DenDad application.
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
use \com\github\patrickhousley\den_dad\view\account as AccountViews;
use \com\github\patrickhousley\den_dad\model as AppModels;

class Account {
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
        if (!isset($_SESSION['login'])) {
            header('Location:/Index');
        }
        
        $this->settings->setView(new AccountViews\View());
        $this->settings->loadDefaultSettings();
        
        $this->settings->getView()->set('login', $this->_models['User']->get('firstName'));
        $this->settings->getView()->set('firstName', $this->_models['User']->get('firstName'));
        $this->settings->getView()->set('lastName', $this->_models['User']->get('lastName'));
        $this->settings->getView()->set('email', $this->_models['User']->get('email'));
        $this->settings->getView()->set('phone', $this->_models['User']->get('phone'));
        $this->settings->getView()->set('lastAccessDate', $this->_models['User']->get('lastAccessDate'));
        $this->settings->getView()->set('lastAccessIP', $this->_models['User']->get('lastAccessIP'));
        
        $this->settings->getView()->set('function', 'edit');
        
        $this->settings->getView()->render(true);
    }
    
    /**
     * Auth controller action function.
     * 
     * <p>Auth performs the authentication of the login information passed to the
     * server from the login form. If the security key passed does not match the
     * one in the current session, the username or password is blank or the
     * password does not match the password stored for the user, an auth error
     * will be set and the user will be sent back to the view function. The password
     * passed is validated by MD5 hashin the passed password and stored salt value
     * together.</p>
     */
    protected function Auth() {
        if (!isset($_POST['login']) || trim($_POST['login']) == '') {
            $_SESSION['authError'] = 'Login ID or Password Invalid';
            header('Location:/Login');
        } elseif (!isset($_SESSION['secKey']) || $_POST['secKey'] != $_SESSION['secKey']) {
            $_SESSION['authError'] = 'Authentication Security Failure';
            header('Location:/Login');
        } else {
            $this->settings->setModel('User', new AppModels\User($_POST['login']));
            $login = $this->settings->getModel('User')->get('login');

            if (isset($login) && $login != '') {
                $pass = $this->settings->getModel('User')->get('password');
                
                if (password_verify($_POST['password'], $pass)) {
                    $_SESSION['login'] = $login = $this->settings->getModel('User')->get('login');
                    header('Location:/Index');
                } else {
                    $_SESSION['authError'] = 'Login ID or Password Invalid';
                    header('Location:/Login');
                }
            } else {
                $_SESSION['authError'] = 'Login ID or Password Invalid';
                header('Location:/Login');
            }
        }
    }
}