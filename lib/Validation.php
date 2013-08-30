<?php
/**
 * Validation is a support class that holds static functions used to validate data.
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\lib;

class Validation {

    /**
     * Validates the passed string is an email address.
     * @param string $val String to validate.
     * @return bool True or false depending on validity.
     */
    public static function validateEmailAddress($val) {
        return (preg_match('/^[a-zA-Z0-9\._%\+-]+@[a-zA-Z0-9\._%\+-]+\.[a-zA-Z]{2,4}$/',
                $subject));
    }
    
    /**
     * Validates the passed string is a time zone.
     * @param string $val String to validate.
     * @return bool True or false depending on validity.
     */
    public static function validateTimeZone($val) {
        try {
            $tz = new DateTimeZone($val);
            return (true);
        } catch (Exception $e) {
            return (false);
        }
    }
}
