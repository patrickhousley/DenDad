<?php
/**
 * BaseController is an abstract class containing methods and properties common
 * to all controllers in the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage base
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\base;

abstract class BaseController {
    /**
     * References the instantiated view registered for the controller.
     * @access protected
     * @var \DenDad\interfaces\IView
     */
    protected $_view;
    
    /**
     * Array containing referance to all instantiated models for the controller.
     * @access protected
     * @var array of \DenDad\interfaces\IModel
     */
    protected $_models;
    
    /**
     * Name of the action function controller should exicute after instantiation.
     * @access protected
     * @var string
     */
    protected $_action;
    
    /**
     * Array of parameters controller may use in the course of performing a specific
     * action.
     * @access protected
     * @var array
     */
    protected $_parameters;
    
    /**
     * Shared DenDad controller constructor.
     * 
     * <p>All DenDad controllers extend the BaseController and rely upon this
     * constructor to perform instantiation operations. During instantiation, the
     * controllers action function will be called which should be defined in the
     * specific controller class.</p>
     * @param string $action Action controller should perform after instantiation.
     * @param array $params Array of parameters controller may use in the course
     * of performing a specific action.
     */
    public function __construct($action = \DenDad\config\Config::DEFAULT_ACTION, $params = array()) {
        $this->_action = $action;
        $this->_parameters = $params;
        $this->{$this->_action}();
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
    protected function defaultTemplateData() {
        if (!isset($this->_models['User'])) {
            if (isset($_SESSION['login'])) {
                $this->_models['User'] = new \DenDad\models\User($_SESSION['login']);
                $this->_models['Den'] = new \DenDad\models\Den($this->_models['User']->get('den'));
                
                $this->_view->set('userName', 
                        $this->_models['User']->get('firstName') . ' ' .
                        $this->_models['User']->get('lastName'));
                $this->_view->set('userRole', $this->_models['User']->get('role'));

                $this->_view->set('packNumber', $this->_models['Den']->get('packNumber'));
                $this->_view->set('packNumberArray',
                        \str_split(trim($this->_models['Den']->get('packNumber')))
                );
                $this->_view->set('denRank', $this->_models['Den']->get('rank'));
            } else {
                $this->_models['User'] = null;
                $this->_models['Den'] = null;

                $this->_view->set('userRole', \DenDad\config\Config::APP_ROLE_ANONYMOUS);

                $this->_view->set('denPack', null);
                $this->_view->set('denPackArray', null);
                $this->_view->set('denRank', null);
            }
        }
    }
}