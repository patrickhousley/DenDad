<?php

/**
 * Config holds the primary config parameters of the application.
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
    'ROOT_URL' => 'http://dendad.localhost',
    'APP_DEBUGGING' => false,
    'APP_VERSION' => '1.0',
    'DEFAULT_CONTROLLER' => 'Index',
    'DEFAULT_ACTION' => 'View',
    'SESSION_MAX_LIFE' => 10, // Must be in minutes.
    'APP_ROLE_ANONYMOUS' => 0,
    'APP_ROLE_AKELA' => 1,
    'APP_ROLE_ASSISTANT_LEADER' => 2,
    'APP_ROLE_LEADER' => 3,
    'APP_ROLE_ADMIN' => 4,
    'DEN_TIGER' => 0,
    'DEN_WOLF' => 1,
    'DEN_BEAR' => 2,
    'DEN_WEBELOS_FIRST' => 3,
    'DEN_WEBELOS_SECOND' => 4,
);