<?php

/**
 * Default view for the login page of the DenDad application.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage view\login
 * @copyright (c) 2012, Patrick Housley
 */

namespace com\github\patrickhousley\den_dad\view\login;

use \com\github\patrickhousley\den_dad\view as AppViews;

class View extends AppViews\AbstractView {

    public function render($toScreen = TRUE) {
        $this->template['TrailPatches'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'TrailPatches.php');
        $this->template['LoginStatus'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'LoginStatus.php');
        $this->template['BodyColumnLeft'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'LoginForm.php');

        /**
         * Layout templates.
         */
        $this->template['MasterHeader'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'layouts' . DS . 'MasterHeader.php');
        $this->template['MasterBody'] = $this->loadTemplate(__DIR__ . DS . '..' .
                DS . 'templates' . DS . 'layouts' . DS . 'TwoColumnBody.php');
        $this->template['MasterFooter'] = $this->loadTemplate(__DIR__ . DS . '..' .
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