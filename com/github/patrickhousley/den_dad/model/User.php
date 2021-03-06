<?php
/**
 * User model for User table of database.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage model
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\model;

use \com\github\patrickhousley\den_dad\lib as AppLibs;

class User extends AbstractModel {

    protected $login;
    protected $password;
    protected $salt;
    protected $den;
    protected $lastName;
    protected $firstName;
    protected $email;
    protected $phone;
    protected $role;
    protected $lastAccessDate;
    protected $lastAccessIP;
    
    function __construct($id = null) {
        parent::__construct('login', FALSE, array(
            'login',
            'password',
            'salt',
            'den',
            'lastName',
            'firstName',
            'email',
            'phone',
            'role',
            'lastAccessDate',
            'lastAccessIP'
        ));
        
        if (isset($id)) {
            
        }
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
                case ('password'):
                    $this->set($col, trim($this->get($col)));
                    break;
                default:
                    $this->set($col, AppLibs\Cleanse::removeAllTags(
                            trim($this->get($col))
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
     * @return boolean|array
     */
    public function validate() {
        $invalid = array();
        foreach ($this->_columnMap as $col) {
            switch ($col) {
                case ('email'):
                    if (!AppLibs\Validation::validateEmailAddress(
                            $this->get($col)
                    ) || trim($this->get($col)) == '') {
                        $invalid[] = $col;
                    }
                    break;
                case ('lastAccessDate'):
                    break;
                case ('lastAccessIP'):
                    break;
                case ('phone'):
                    break;
                default:
                    if (trim($this->get($col)) == '') {
                        $invalid[] = $col;
                    }
                    break;
            }
        }
        
        return (count($invalid) > 0) ? $invalid : true;
    }
}