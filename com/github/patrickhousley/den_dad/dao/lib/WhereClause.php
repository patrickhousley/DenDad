<?php

/**
 * WhereClause provides OOP methods of creating a complex SQL Where clause.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage dao\lib
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\dao\lib;

class WhereClause {
    const OPERATION_OR = 'OR';
    const OPERATION_AND = 'AND';
    
    private $operation;
    private $fields;
    
    public function __construct($operation = self::OPERATION_AND) {
        $this->setOperation($operation);
    }
    
    /**
     * Retrieve the where clause operation.
     */
    public function getOperation() {
        return $this->operation;
    }
    
    /**
     * Set the current where clause operation using the constants of this class.
     * @param string $operation
     */
    public function setOperation($operation = self::OPERATION_AND) {
        if ($operation != self::OPERATION_AND &&
                $operation != self::OPERATION_OR) {
            $this->operation = self::OPERATION_AND;
        } else {
            $this->operation = $operation;
        }
    }
    
    public function __toString() {
        
    }
}