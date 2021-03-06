<?php
/**
 * Interface for View classes.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage interfaces
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\interfaces;

interface Viewable {
    
    /**
     * Renders the output of the view's registered template.
     * 
     * @param bool $toScreen Indicates if any output should be rendered to the screen
     * or returned as a variable.
     * @return string Will return output as string if $toScreen is FALSE.
     */
    public function render($toScreen = TRUE);
}
