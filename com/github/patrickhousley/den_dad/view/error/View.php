<?php

/**
 * Default view for the error page of the DenDad application.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage view\error
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\view\error;

use \com\github\patrickhousley\den_dad\view as AppViews;

class View extends AppViews\AbstractView {

    public function render($toScreen = TRUE) {
        $this->_template['TrailPatches'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'TrailPatches.php');
        $this->_template['LoginStatus'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'LoginStatus.php');
        $this->_template['BodyColumnLeft'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'Error.php');

        /**
         * Layout templates.
         */
        $this->_template['MasterHeader'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'layouts' . DS . 'MasterHeader.php');
        $this->_template['MasterBody'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'layouts' . DS . 'TwoColumnBody.php');
        $this->_template['MasterFooter'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'layouts' . DS . 'MasterFooter.php');

        if ($toScreen) {
            echo($this->loadTemplate(__DIR__ . DS . '..' . DS . 'templates' . DS .
                    'layouts' . DS . 'MasterLayout.php'));
        } else {
            return $this->loadTemplate(__DIR__ . DS . '..' . DS . 'templates' . DS .
                            'layouts' . DS . 'MasterLayout.php');
        }
    }

}