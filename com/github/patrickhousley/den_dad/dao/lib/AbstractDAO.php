<?php

/**
 * Interface for DAO classes.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage dao\lib
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\dao\lib;

abstract class AbstractDAO {
    
    /**
     * Create a connection to the database and return the connection.
     */
    abstract static function connect();
    
    /**
     * Select a single record from the database and return it in the form of
     * the tables model class.
     */
    abstract static function select();
    
    /**
     * Retrieve value map from the model and persist it in the database.
     * 
     * @param \com\github\patrickhousley\den_dad\interfaces\Modelable $model
     */
    abstract static function persist(Modelable $model);
    
    /**
     * Retrieve primary key and value of the model and remove the entry from the
     * database.
     * 
     * @param \com\github\patrickhousley\den_dad\interfaces\Modelable $model
     */
    abstract static function destroy(Modelable $model);
}
