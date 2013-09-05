<?php
/**
 * Den model for User table of database.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage model
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\model;

class Den extends \DenDad\base\BaseModel implements \DenDad\interfaces\IModel {

    protected $id;
    protected $denNumber;
    protected $packNumber;
    protected $rank;
    
    function __construct($id = null) {
        parent::__construct($id, 'id', TRUE, array(
            'id',
            'denNumber',
            'packNumber',
            'rank'
        ));
    }

    /**
     * Cleanse all properties of the current model.
     * 
     * <p>Cleanse all properties of the current model to ensure they do not contain
     * illegal data such as scripts or html.</p>
     */
    public function cleanse() {
        foreach ($this->_columnMap as $col) {
            switch ($col) {
                default:
                    $this->set($col, \DeanDad\libs\Cleanse::removeAllTags(
                            \trim($this->get($col))
                    ));
                    break;
            }
        }
    }

    /**
     * Validate the current model meets requirements for persistance.
     * 
     * <p>Validate all properties of the current model meet the requirements
     * for persistance in the database. Will return true if the model passes the
     * validation. Otherwise, an array of properties that failed validation will
     * be returned.</p>
     * @return mixed True if validation is successful, an array otherwise.
     */
    public function validate() {
        $invalid = array();
        foreach ($this->_columnMap as $col) {
            switch ($col) {
                default:
                    if (\trim($this->get($col)) == '') {
                        $invalid[] = $col;
                    }
                    break;
            }
        }
        
        return (\count($invalid) > 0) ? $invalid : true;
    }
}