<?php
/**
 * BaseModel is an abstract class containing methods and properties common
 * to all models in the DenDad application. The class also contains a few support
 * static functions.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage base
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\base;

abstract class BaseModel {
    /**
     * Holds the name of the model's primary key.
     * @access protected
     * @var string 
     */
    protected $_primaryKey;
    
    /**
     * True if the model's primary key auto-incriments.
     * @access protected
     * @var bool 
     */
    protected $_primaryKeyAI;
    
    /**
     * Array containing valid model properties.
     * @access protected
     * @var array 
     */
    protected $_columnMap;
    
    /**
     * Array to hold the original value of any properties that are changed.
     * @access protected
     * @var array 
     */
    protected $_changes;
    
    /**
     * Current static PDO connection to the database.
     * @access protected
     * @var \PDO 
     */
    protected static $_connection;

    /**
     * Search the specified table and return an array of records.
     * 
     * <p>Compiles a select statment using the paramaters, ordering, limit and
     * offset variables. Once performed, the function will instantiate a new model
     * object for each row based on the table name, set the properties for the model,
     * and return an array of models.</p>
     * @param string $table Name of table to search in.
     * @param array $parameters Parameters for WHERE clause of search.
     * @param array $ordering Ordering parameters.
     * @param int $limit Maximum number of records to return.
     * @param int $offset Offset for limit.
     * @return \DenDad\base\model
     * @throws \PDOException
     */
    public static function search($table, $parameters = array(), $ordering = array(),
            $limit = null, $offset = null) {
        $model = '\\DenDad\\models\\' . $table;
        $sql = 'SELECT * FROM ' . $table;
        $sqlWhere = '';
        $sqlWhereValues = array();
        $sqlOrder = '';
        $sqlLimit = '';
        
        if (\is_array($parameters) && \count($parameters) > 0) {
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
     * Retrieve a connection to the application database.
     * 
     * <p>Check if the static connection to the database is set. If so, return
     * it. If not, create a new connection, assign it to the static connection
     * variable and return it.</p>
     * @return \PDO
     * @throws \PDOException
     */
    protected static function connection() {
        if (!isset(self::$_connection)) {
            self::$_connection = new \PDO(\DenDad\config\DatabaseConfig::DB_DSN, 
                    \DenDad\config\DatabaseConfig::DB_USER, 
                    \DenDad\config\DatabaseConfig::DB_PASS);
            self::$_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        
        return self::$_connection;
    }
    
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
    public function __construct($id = null, $primaryKey = null, $primaryKeyAI = true, 
            $columnMap = null){
        $this->_primaryKey = $primaryKey;
        $this->_primaryKeyAI = $primaryKeyAI;
        $this->_columnMap = $columnMap;
        if (isset($id)) {
            $this->select($id);
        }
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
    
    /**
     * Formats the current model into an associative array of property names and
     * values.
     * 
     * <p>Uses the model's column map to create an associative array of property
     * names and values.</p>
     * @return array Array of property names and values.
     */
    private function getColumnMap() {
        $return = array();
        foreach($this->_columnMap as $col) {
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
        if (!\is_array($this->_columnMap) || !\in_array($var, $this->_columnMap)) {
            throw new \DenDad\exceptions\ModelException('Access attempted for' .
                    ' invalid property name: ' . $var, 
                    \DenDad\exceptions\ModelException::INVALID_PROPERTY);
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
     * @param string $var Record property name.
     * @param string $val Record property value.
     * @throws \DenDad\exceptions\ModelException
     */
    public function set($var, $val) {
        if (!\is_array($this->_columnMap) || !\in_array($var, $this->_columnMap)) {
            throw new \DenDad\exceptions\ModelException('Access attempted for' .
                    ' invalid property name: ' . $var, 
                    \DenDad\exceptions\ModelException::INVALID_PROPERTY);
        }
        
        if ($this->$var != $val) {
            if (!isset($this->_changes[$var])) {
                $this->_changes[$var] = $this->$var;
            }
            $this->$var = $val;
        }
    }
}