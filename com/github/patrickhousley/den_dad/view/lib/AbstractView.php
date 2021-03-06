<?php
/**
 * AbstractView contains functions that all views use to implement the template
 * engine.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage view
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\view;

use \com\github\patrickhousley\den_dad\interfaces as AppInterfaces;
use \InvalidArgumentException;
use \Exception;

abstract class AbstractView implements AppInterfaces\Viewable {
    /**
     * Array containing all data variables used in the view and templates called
     * by the view.
     * @var array
     */
    protected $data;
    
    /**
     * Array containing template block data that can be used in a master template
     * to properly layout a page.
     * @var array 
     */
    protected $template;
    
    /**
     * Set a template variable to a specified value.
     * @param string $var Template variable name.
     * @param mixed $val Template variable value.
     */
    public function set($var, $val) {
        $this->data[$var] = $val;
    }
    
    /**
     * Retrieve a stored template variable.
     * @param string $var Name of a template variable.
     * @return mixed Value of the template variable.
     */
    public function get($var) {
        return ($this->data[$var]);
    }
    
    /**
     * Include a template file and return it's output as a string.
     * @param string $file
     * @return string
     */
    protected function loadTemplate($file = '') {
        if (!is_file($file)) { return ''; }
        
        try {
            ob_start();
            include $file;
            return ob_get_clean();
        } catch (Exception $e) {
            throw new InvalidArgumentException('An error occured while processing the requested page.', 0,
                    new Exception('Unable to load indicated template: ' . $file . '.', 0, $e));
        }
    }
}