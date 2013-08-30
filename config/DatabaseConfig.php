<?php
/**
 * DatabasConfig holds the config parameters used to make a connection to the database.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage config
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\config;

class DatabaseConfig {
    const DB_USER = 'devuser';
    const DB_PASS = 'devpass';
    const DB_HOST = 'localhost';
    const DB_NAME = 'maindev';
    const DB_DSN = 'mysql:host=localhost;dbname=maindev';
}