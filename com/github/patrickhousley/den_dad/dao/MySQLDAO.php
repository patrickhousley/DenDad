<?php

/**
 * MySQLDAO contains the neccessary functions to create and utilize a PDO
 * connection to a MySQL database server.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage dao
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\dao;

use \PDO;

class MySQLDAO extends lib\AbstractDAO {
    /**
     * Current static PDO connection to the database.
     * @var \PDO 
     */
    private static $connection;
    
    /**
     * Private constructor to disallow the creation of an object from the class.
     */
    private function __construct() {}
    
    public static function connect() {
        if (!isset(self::$connection)) {
            self::$connection = new PDO($GLOBALS['DENDAD_CONFIG']['DB_DSN'], 
                    $GLOBALS['DENDAD_CONFIG']['DB_USER'], 
                    $GLOBALS['DENDAD_CONFIG']['DB_PASS']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$connection;
    }
    
    /**
     * Search the specified table and return an array of records.
     * 
     * <p>Compiles a select statment using the paramaters, ordering, limit and
     * offset variables. Once performed, the function will instantiate a new model
     * object for each row based on the table name, set the properties for the model,
     * and return an array of models.</p>
     * @param string $table
     * @param array $parameters
     * @param array $ordering
     * @param int $limit
     * @param int $offset
     * @return \com\github\patrickhousley\den_dad\model\AbstractModel
     */
    public static function search($table, $parameters = array(), $ordering = array(),
            $limit = null, $offset = null) {
        $model = '\\com\\github\\patrickhousley\\den_dad\model\\' . $table;
        $sql = 'SELECT * FROM ' . $table;
        $sqlWhere = '';
        $sqlWhereValues = array();
        $sqlOrder = '';
        $sqlLimit = '';
        
        if (is_array($parameters) && count($parameters) > 0) {
            foreach($parameters as $ind => $val) {
                if ($sqlWhere == '') { 
                    $sqlWhere = ' WHERE ';
                } else {
                    $sqlWhere .= ' AND ';
                }
                
                $sqlWhere .= $ind . '=:' . $ind;
                $sqlWhereValues[':' . $ind] = $val;
            }
        }
        
        if (\is_array($ordering) && \count($ordering) > 0) {
            foreach($parameters as $ind => $val) {
                if ($val == 'ASC' || $val == 'DESC') {
                    if ($sqlOrder == '') { 
                        $sqlOrder = ' ORDER BY ';
                    } else {
                        $sqlOrder .= ', ';
                    }
                    $sqlOrder .= $ind . ' ' . $val;
                }
            }
        }
        
        if (isset($limit)) {
            $sqlLimit .= ' LIMIT ';
            if (isset($offset)) {
                $sqlLimit .= $offset . ', ';
            }
            $sqlLimit .= $limit;
        }
        
        $db_comm = self::connection()->prepare($sql . $sqlWhere . $sqlOrder . $sqlLimit);
        $db_comm->execute($sqlWhereValues);
        $return = array();
        
        while($row = $db_comm->fetch(\PDO::FETCH_ASSOC)) {
            $m = new $model();
            foreach($row as $ind => $val) {
                $m->set($ind, $val);
            }
            
            $return[] = $m;
        }
        
        return $return;
    }
    
    /**
     * Retrieve model property values from database for the given id.
     * 
     * <p>Retrieves the model's property values from the database using the passed
     * id value and the model's primary key. Throws an exception if the model's
     * primary key is not set.
     * @param string $id Record id to retrieve.
     * @throws \DenDad\exceptions\ModelException
     */
    private function select($id) {
        if (!isset($this->_primaryKey)) {
            throw new \DenDad\exceptions\ModelException('Primary key not set for' .
                    'model ' . get_class($this), 
                    \DenDad\exceptions\ModelException::MISSING_PRIMARY_KEY);
        }
        
        $table = \DenDad\libs\Support::getClassName($this);
        $db_comm = self::connection()->prepare('SELECT * FROM ' . 
                $table . ' WHERE ' . $this->_primaryKey
                . '=:' . $this->_primaryKey);
        $db_comm->execute(array(':' . $this->_primaryKey => $id));
        
        if ($row = $db_comm->fetch(\PDO::FETCH_ASSOC)) {
            foreach($row as $ind => $val) {
                $this->set($ind, $val);
            }
        } else {
            throw new \DenDad\exceptions\ModelException('Record [' . $this->_primaryKey .
                    '=' . $id . '] not found in table ' . $table,
                    \DenDad\exceptions\ModelException::MISSING_RECORD);
        }
    }
    
    /**
     * Saves the current model to the database.
     * 
     * <p>If the current model exists in the database, update the record. However,
     * if the record does not exists, insert the model into the database. If the
     * save failes, throw a ModelException exception.</p>
     * @throws \DenDad\exceptions\ModelException
     */
    public function persist() {
        $table = \DenDad\libs\Support::getClassName($this);
        if (!isset($this->_primaryKey)) {
            throw new \DenDad\exceptions\ModelException('Primary key not set for' .
                    'model ' . $table, 
                    \DenDad\exceptions\ModelException::MISSING_PRIMARY_KEY);
        }
        
        if (isset($this->{$this->_primaryKey}) && 
            $this->recordExists()) {
            $columns = $this->getColumnMap();
            
            $sql = 'UPDATE ' . $table . ' SET';
            $sqlColumns = ' ';
            $sqlValues = array();
            foreach($columns as $col => $val) {
                if ($col != $this->_primaryKey) {
                    if ($sqlColumns != ' ') {
                        $sqlColumns .= ', ';
                    }
                    $sqlColumns .= $col . '=:' . $col;
                    $sqlValues[':' . $col] = $val;
                }
            }
            \error_log(\print_r($sqlValues, true));
            $db_comm = self::connection()->prepare($sql . $sqlColumns .
                    ' WHERE ' . $this->_primaryKey . '=:' . $this->_primaryKey);
            $sqlValues[':' . $this->_primaryKey] = $columns[$this->_primaryKey];
            if (!$db_comm->execute($sqlValues)) {
                throw new \DenDad\exceptions\ModelException('Unable to persist' .
                        ' record [' . $this->_primaryKey . '=' . $id . ']' .
                        ' in table ' . $table . '.',
                    \DenDad\exceptions\ModelException::MISSING_RECORD);
            }
        } else {
            $columns = $this->getColumnMap();
            
            $sql = 'INSERT INTO ' . $table . ' (';
            $sqlColumns = '';
            $sqlValues = array();
            foreach($columns as $col => $val) {
                if ($col != $this->_primaryKey || (!$this->_primaryKeyAI && 
                        $col == $this->_primaryKey)) {
                    if ($sqlColumns == '') { 
                        $sqlColumns = ' (';
                    } else {
                        $sql .= ', ';
                        $sqlColumns .= ', ';
                    }
                    $sql .= $col;
                    $sqlColumns .= ':' . $col;
                    $sqlValues[':' . $col] = $val;
                }
            }
            
            $db_comm = self::connection()->prepare($sql . ') VALUES ' . $sqlColumns . ')');
            if (!$db_comm->execute($sqlValues)) {
                if ($this->_primaryKeyAI) {
                    throw new \DenDad\exceptions\ModelException('Unable to persist' .
                            ' record in table ' . $table . '.',
                            \DenDad\exceptions\ModelException::MISSING_RECORD);
                } else {
                    throw new \DenDad\exceptions\ModelException('Unable to persist' .
                            ' record [' . $this->_primaryKey . '=' . $id . ']' .
                            ' in table ' . $table . '.',
                        \DenDad\exceptions\ModelException::MISSING_RECORD);
                }
            }
        }
    }
    
    /**
     * Removes the current model from the database.
     * 
     * <p>Deletes the current model from the database. If the model does not exist
     * in the database or the primary key is not set for the current model.</p>
     * @throws \DenDad\exceptions\ModelException
     */
    public function destroy() {
        $table = \DenDad\libs\Support::getClassName($this);
        $record = $this->{$this->_primaryKey};
        if (!isset($this->_primaryKey)) {
            throw new \DenDad\exceptions\ModelException('Primary key not set for' .
                    'model ' . get_class($this), 
                    \DenDad\exceptions\ModelException::MISSING_PRIMARY_KEY);
        }
        if (!$this->recordExists()) {
            throw new \DenDad\exceptions\ModelException('Record ' . $record .
                    ' does not exists in table ' . $table, 
                    \DenDad\exceptions\ModelException::MISSING_PRIMARY_KEY);
        }
        
        $db_comm = self::connect()->prepare('DELETE FROM ' . $table . ' WHERE ' .
                $this->_primaryKey . '=:' . $this->_primaryKey);
        if (!$db_comm->execute(array(':' . $this->_primaryKey => $record))) {
            throw new \DenDad\exceptions\ModelException('Unable to destroy record ' .
                    $record . ' from table ' . $table, \DenDad\exceptions\ModelException::DELETE_FAILED);
        }
    }
    
    /**
     * Check if the current model exists in the database.
     * 
     * <p>Checks if the current model exists in the database. If it does, it returns
     * true. Otherwise, false is returned.</p>
     * @return boolean True if record exists.
     */
    private function recordExists() {
        $table = \DenDad\libs\Support::getClassName($this);
        $record = $this->{$this->_primaryKey};
        
        $db_comm = self::connection()->prepare('SELECT * FROM ' . 
                $table . ' WHERE ' . $this->_primaryKey
                . '=:' . $this->_primaryKey);
        $db_comm->execute(array(':' . $this->_primaryKey => $record));
        
        if ($row = $db_comm->fetch(\PDO::FETCH_ASSOC)) {
            return true;
        } else {
            return false;
        }
    }
}