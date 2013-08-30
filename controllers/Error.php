<?php
/**
 * Error is the error controller for the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage controllers
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\controllers;

class Error extends \DenDad\base\BaseController implements \DenDad\interfaces\IController {
    
    /**
     * View controller action function.
     * 
     * <p>View is the default controller action. Being in the error controller,
     * this function will make use of the session lastExpection variable to display
     * the correct error message.</p>
     */
    protected function View() {
        $this->_view = new \DenDad\views\Error\View();
        
        try {
            $this->defaultTemplateData();
        } catch (\Exception $e) {
            $this->_models['User'] = null;
            $this->_models['Den'] = null;

            $this->_view->set('userRole', \DenDad\config\Config::APP_ROLE_ANONYMOUS);

            $this->_view->set('denPack', null);
            $this->_view->set('denPackArray', null);
            $this->_view->set('denRank', null);
        }
        
        $error = null;
        if (isset($_SESSION['lastException']) && trim($_SESSION['lastException']) != '') {
            $error = unserialize($_SESSION['lastException']);
        }
        
        if ($error instanceof \Exception) {
            switch(get_class($error)) {
                case 'DenDad\\exceptions\\ControllerException':
                    $this->_view->set('errorMessage', 'We are unable to load the requested' .
                            ' page. If you believe you received this message in error' .
                            ', please open a support request and provide the steps' .
                            ' taken to reach this error.');
                    break;
                case 'DenDad\\exceptions\\ModelException':
                    $this->_view->set('errorMessage', 'An error occured while' .
                            ' attempting to access the database. Please try your' .
                            ' request again. If still unsuccessful, please open' .
                            ' a support request and provide the steps taken to' .
                            ' reach this error.');
                    break;
                case 'PDOException':
                    $this->_view->set('errorMessage', 'An error occured while' .
                            ' attempting to access the database. Please try your' .
                            ' request again. If still unsuccessful, please open' .
                            ' a support request and provide the steps taken to' .
                            ' reach this error.');
                    break;
                case 'DenDad\\exceptions\\ViewException':
                    $this->_view->set('errorMessage', 'An error occured while' .
                            ' attempting to load the visual elements of this' .
                            ' page. Please try your request again. If still' .
                            ' unsuccessful, please open a support request and' .
                            ' provide the steps taken to reach this error.');
                    break;
                case 'DenDad\\exceptions\\AutoloadException':
                    $this->_view->set('errorMessage', 'An internal application' .
                            ' error has prevented the displaying of the requested' .
                            ' page. Please try your request again. If still' .
                            ' unsuccessful, please open a support request and' .
                            ' provide the steps taken to reach this error.');
                    break;
                default:
                    $this->_view->set('errorMessage', 'An unknown error has' .
                            ' prevented the displaying of the requested' .
                            ' page. Please try your request again. If still' .
                            ' unsuccessful, please open a support request and' .
                            ' provide the steps taken to reach this error.');
                    break;
            }
            \error_log(\DenDad\libs\Support::getClassName($error) . ' Error ' . 
                    $error->getCode() . ': ' . $error->getMessage() . 
                    ' File: ' . $error->getFile() . ' Line: ' . $error->getLine());
        } else {
            $this->_view->set('errorMessage', 'No error was found. You may have' .
                    ' navigated to this page by mistake.');
        }
        
        $this->_view->render(true);
    }
}
