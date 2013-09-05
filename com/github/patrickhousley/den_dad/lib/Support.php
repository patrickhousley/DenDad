<?php
/**
 * Support is a class holder for static support functions accessible to the DenDad
 * application.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\lib;

class Support {
    
    /**
     * Returns the class name of the passed object.
     * 
     * <p>The function explodes the string returned by get_class using the backslash
     * as the delimiter. The function then returns the last element of the explode
     * array which should be the object's class name without the namespace.</p>
     * @param object $obj
     * @return string
     */
    public static function getClassName($fqNS) {
        $arr = explode('\\', get_class($fqNS));
        return $arr[count($arr) - 1];
    }
    
    /**
     * Returns the namepsace of the passed object.
     * 
     * <p>The function explodes the string returned by get_class using the backslash
     * as the delimiter. The function then implodes all elements of the explode
     * array except the last one. This is returned as the objects namespace without
     * the object's class name.</p>
     * @param object $obj
     * @return string
     */
    public static function getNamespace($fqNS) {
        $arr = explode('\\', get_class($fqNS));
        return implode('\\', array_slice($arr, 0, count($arr) - 1));
    }
}