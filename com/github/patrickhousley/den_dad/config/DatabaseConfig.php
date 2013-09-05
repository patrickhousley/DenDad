<?php

/**
 * DatabasConfig holds the config parameters used to make a connection to the
 * database.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage config
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\config;

return array(
    'DB_DAO' => 'MySQLDAO',
    'DB_USER' => 'devuser',
    'DB_PASS' => 'devpass',
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'maindev',
    'DB_DSN' => 'mysql:host=localhost;dbname=maindev'
);