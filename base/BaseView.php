<?php
/**
 * BaseView is an abstract class containing methods and properties common
 * to all view in the DenDad application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage base
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\base;

abstract class BaseView {
    /**
     * Array containing all data variables used in the view and templates called
     * by the view.
     * @var array
     */
    protected $_data;
    
    /**
     * Array containing template block data that can be used in a master template
     * to properly layout a page.
     * @var array 
     */
    protected $_template;
    
    /**
     * Set a template variable to a specified value.
     * @param string $var Template variable name.
     * @param mixed $val Template variable value.
     */
    public function set($var, $val) {
        $this->_data[$var] = $val;
    }
    
    /**
     * Retrieve a stored template variable.
     * @param string $var Name of a template variable.
     * @return mixed Value of the template variable.
     */
    public function get($var) {
        return ($this->_data[$var]);
    }
    
    /**
     * Include a template file and return it's output as a string.
     * @param string $file FQN for file to include.
     * @return string HTML of the template file.
     * @throws \DenDad\exceptions\ViewException
     */
    protected function loadTemplate($file = '') {
        if (!is_file($file)) { return ''; }
        
        try {
            ob_start();
            include $file;
            return ob_get_clean();
        } catch (\Exception $e) {
            throw new \DenDad\exceptions\ViewException('A problem occured loading' .
                    ' template file: ' . $file . '.' . $e.getMessage, $e.getCode, $e);
        }
    }
}