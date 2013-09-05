<?php
/**
 * Logout is the logout controller for the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage controllers
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\controllers;

class Logout extends \DenDad\base\BaseController implements \DenDad\interfaces\IController {
    
    /**
     * View controller action function.
     * 
     * <p>View is the default controller action. Being in the logout controller,
     * this function will destroy the current session and return the user to
     * the Index controller.</p>
     */
    protected function View() {
        \session_destroy();
        \header('Location:/Index');
    }
}
