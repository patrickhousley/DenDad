<?php
/**
 * Index is the default controller for the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage controllers
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\controllers;

class Index extends \DenDad\base\BaseController implements \DenDad\interfaces\IController {
    
    /**
     * View controller action function.
     * 
     * <p>View is the default controller action. Being in the Index controller,
     * this will instantiate the template and template variables so when the render
     * function is called, the DenDad home page is displayed.</p>
     */
    protected function View() {
        $this->_view = new \DenDad\views\Index\View();
        $this->defaultTemplateData();
        
        $this->_view->render(true);
    }
}
