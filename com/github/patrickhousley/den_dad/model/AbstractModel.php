<?php

/**
 * AbstractModel implements common model functions that all models can use to
 * facilitate persistance.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage model
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\model;

use \com\github\patrickhousley\den_dad\interfaces as AppInterfaces;
use \InvalidArgumentException;
use \Exception;

abstract class AbstractModel implements AppInterfaces\Modelable {

    /**
     * Holds the name of the model's primary key.
     * @var string 
     */
    protected $primaryKey;

    /**
     * True if the model's primary key auto-incriments.
     * @var bool 
     */
    protected $primaryKeyAI;

    /**
     * Array containing valid model properties.
     * @var array 
     */
    protected $columnMap;

    /**
     * Array to hold the original value of any properties that are changed.
     * @var array 
     */
    protected $changes;
    
    /**
     * Data access object for the current model.
     * @var com\github\patrickhousley\den_dad\interfaces\DAO
     */
    private $dao;

    /**
     * Instantiate the model object and set the primary key, column map and load
     * the values for the given record.
     * 
     * <p>Instantiates the model and sets the primary key and column map variables.
     * If the id variable is set, the contructor will also call the model's select
     * function to load the model's properties.</p>
     * @param string $id The id of the record to load into this model object.
     * @param string $primaryKey Name of the primary key all operations should be
     * performed based on.
     * @param bool $primaryKeyAI Indicate if the primary key auto increments.
     * @param array $columnMap Array containing all valid columns names.
     */
    public function __construct($primaryKey = null, $primaryKeyAI = true, $columnMap = null) {
        $this->primaryKey = $primaryKey;
        $this->primaryKeyAI = $primaryKeyAI;
        $this->columnMap = $columnMap;
        
        $daoFQN = 'com\\github\\patrickhousley\\den_dad\\controller\\' .
                $GLOBALS['DENDAD_DB_CONFIG']['DB_DAO'];
        $this->dao = new $daoFQN();
    }

    /**
     * Formats the current model into an associative array of property names and
     * values.
     * 
     * <p>Uses the model's column map to create an associative array of property
     * names and values.</p>
     * @return array
     */
    private function getColumnMap() {
        $return = array();
        foreach ($this->columnMap as $col) {
            $return[$col] = $this->$col;
        }

        return $return;
    }

    /**
     * Retrieve model property value.
     * 
     * <p>Retrieves the value of the given model property. Throws exception
     * if the property is not found in the column map.</p>
     * @param string $var Property name to retrieve value for.
     * @return string Value of model property.
     * @throws \DenDad\exceptions\ModelException
     */
    public function get($var) {
        if (!is_array($this->columnMap) || !in_array($var, $this->columnMap)) {
            throw new InvalidArgumentException('An error occured while processing the requested page.', 0, new Excpetion('Access attempted for invalid property: ' .
                get_class($this) . '[' . $var . '].'));
        }
        return $this->$var;
    }

    /**
     * Set the property value for this model.
     * 
     * <p>Set this model's property value to the given value. If the property
     * already contains a value, copy the current value to the _changes array
     * to allow for record auditing. Throws an exception if the property is
     * not found in the column map.</p>
     * @param string $var
     * @param string $val
     */
    public function set($var, $val) {
        if (!is_array($this->columnMap) || !in_array($var, $this->columnMap)) {
            throw new InvalidArgumentException('An error occured while processing the requested page.', 0, new Excpetion('Access attempted for invalid property: ' .
                get_class($this) . '[' . $var . '].'));
        }

        if ($this->$var != $val) {
            if (!isset($this->changes[$var])) {
                $this->changes[$var] = $this->$var;
            }
            $this->$var = $val;
        }
    }

}