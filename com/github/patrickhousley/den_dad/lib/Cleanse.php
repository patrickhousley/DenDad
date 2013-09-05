<?php
/**
 * Cleanse is a support class that holds static functions used to cleanse data.
 * 
 * @author Patrick Housley <patrick.f.housley@gmail.com>
 * @version 1.0
 * @since 1.0
 * @package com\github\patrickhousley\den_dad
 * @subpackage lib
 * @copyright (c) 2012, Patrick Housley
 */
namespace com\github\patrickhousley\den_dad\lib;

class Cleanse {

    /**
     * Removes all tags in the passed string.
     * 
     * @param string $val
     * @return string
     */
    public static function removeAllTags($val) {
        return (trim(strip_tags(self::decodeValues($val))));
    }
    
    /**
     * Removes all script elements from the passed string.
     * 
     * <p>Removes all script blocks from the passed string, not just the script
     * tags. Also remove all standard DOM events including their value's.</p>
     * @param string $val
     * @return string
     */
    public static function removeScript($val) {
        // Remove all script tags and the included script \\
        $val = preg_replace("/<script[\s\S]*?\/script>/", "", validation::decodeValue($val));

        // Build list of event handlers to remove \\
        $events = array(
            '/onload/i',
            '/onunload/i',
            '/onblur/i',
            '/onchange/i',
            '/onfocus/i',
            '/onreset/i',
            '/onselect/i',
            '/onsubmit/i',
            '/onabort/i',
            '/onerror/i',
            '/onload/i',
            '/onkeydown/i',
            '/onkeypress/i',
            '/onkeyup/i',
            '/onclick/i',
            '/ondblclick/i',
            '/onmousedown/i',
            '/onmousemove/i',
            '/onmouseout/i',
            '/onmouseover/i',
            '/onmouseup/i'
        );
        // Remove all event attributes \\
        $returnValue = "";
        foreach (explode("<", $val) as $tag) {
            // Clear the event attributes one tag at a time \\
            if ($tag != "") {
                $tag = "<" . preg_replace($events, "noevent", $tag);
                $returnValue .= preg_replace('/javascript:["|\']{1}[\s\S\w\d]*["|\']{1}/i', '"', $tag);
            }
        }

        return($returnValue);
    }
    
    /**
     * Decodes the passed string.
     * 
     * <p>Decodes the passed string using html_entity_decode and urldecode.</p>
     * @param string $value
     * @return string
     */
    private static function decodeValue($value='') {
        return(html_entity_decode(urldecode($value), ENT_QUOTES));
    }
}
