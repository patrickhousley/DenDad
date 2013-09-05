<?php
/**
 * Index file provides access to the underlying DenDad application.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @copyright (c) 2013, Patrick Housley
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('SCRIPT_START_MTIME', microtime(true));

require_once ROOT . DS . 'com' . DS . 'github' . DS . 'patrickhousley' . DS .
        'den_dad' . DS . 'lib' . DS . 'Bootstrap.php';

\com\github\patrickhousley\den_dad\lib\Bootstrap::init();