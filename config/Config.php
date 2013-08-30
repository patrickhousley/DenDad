<?php
/**
 * Config holds the primary config parameters of the application.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package DenDad
 * @subpackage config
 * @copyright (c) 2012, Patrick Housley
 */
namespace DenDad\config;

class Config {
    const ROOT_URL = 'http://dendad.localhost';
    const APP_DEBUGGING = false;
    const APP_VERSION = '1.0';
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_ACTION = 'View';
    const SESSION_MAX_LIFE = 10; // Must be in minutes.

    const APP_ROLE_ANONYMOUS = 0;
    const APP_ROLE_AKELA = 1;
    const APP_ROLE_ASSISTANT_LEADER = 2;
    const APP_ROLE_LEADER = 3;
    const APP_ROLE_ADMIN = 4;
    
    const DEN_TIGER = 0;
    const DEN_WOLF = 1;
    const DEN_BEAR = 2;
    const DEN_WEBELOS_FIRST = 3;
    const DEN_WEBELOS_SECOND = 4;
}