<?php
/**
 * Interface for Model classes.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage interfaces
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\interfaces;

interface Modelable {
    
    /**
     * Cleanse all properties of the current model.
     * 
     * <p>Cleanse all properties of the current model to ensure they do not contain
     * illegal data such as scripts or html.</p>
     */
    public function cleanse();
    
    /**
     * Validate the current model meets requirements for persistance.
     * 
     * <p>Validate all properties of the current model meet the requirements
     * for persistance in the database. Will return true if the model passes the
     * validation. Otherwise, an array of properties that failed validation will
     * be returned.</p>
     * @return mixed True if validation is successful, an array otherwise.
     */
    public function validate();
}
