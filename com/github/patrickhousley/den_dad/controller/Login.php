<?php
/**
 * Login is the login controller for the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage controllers
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\controllers;

class Login extends \DenDad\base\BaseController implements \DenDad\interfaces\IController {
    
    /**
     * View controller action function.
     * 
     * <p>View is the default controller action. Being in the login controller,
     * this function will display the login page. If the user is already logged
     * in, the user will be directed to the index page.</p>
     */
    protected function View() {
        if (isset($_SESSION['login'])) {
            \header('Location:/Index');
        }
        
        $this->_view = new \DenDad\views\Login\View();
        $this->defaultTemplateData();
        
        $secKey = \md5(\rand() . \microtime() . $_SERVER['REMOTE_ADDR']);
        $this->_view->set('secKey', $secKey);
        $_SESSION['secKey'] = $secKey;
        
        if (isset($_SESSION['authError']) && trim($_SESSION['authError']) != '') {
            $this->_view->set('authError', trim($_SESSION['authError']));
            $_SESSION['authError'] = '';
        } else {
            $this->_view->set('authError', '');
        }
        
        $this->_view->render(true);
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
            \header('Location:/Login');
        } elseif (!isset($_SESSION['secKey']) || $_POST['secKey'] != $_SESSION['secKey']) {
            $_SESSION['authError'] = 'Authentication Security Failure';
            \header('Location:/Login');
        } else {
            try {
                $this->_models['User'] = new \DenDad\models\User($_POST['login']);
                $login = $this->_models['User']->get('login');
            } catch (\DenDad\exceptions\ModelException $e) {
                
            }

            if (isset($login) && $login != '') {
                $pass = $this->_models['User']->get('password');
                $salt = $this->_models['User']->get('salt');

                if (md5($_POST['password'] . $salt) == $pass) {
                    $_SESSION['login'] = $this->_models['User']->get('login');
                    \header('Location:/Index');
                } else {
                    $_SESSION['authError'] = 'Login ID or Password Invalid';
                    \header('Location:/Login');
                }
            } else {
                $_SESSION['authError'] = 'Login ID or Password Invalid';
                \header('Location:/Login');
            }
        }
    }
}
