<?php
/**
 * Created by PhpStorm.
 * User: Aldyaka Mushofan
 * Date: 2/24/2016
 * Time: 9:37 AM
 */
    function sanitize($rawText){
        $sanitizedText = $rawText;
        $sanitizedText = preg_replace("/\&/","&amp;",$sanitizedText);
        $sanitizedText = preg_replace("/\</","&lt;",$sanitizedText);
        $sanitizedText = preg_replace("/\>/","&gt;",$sanitizedText);
        $sanitizedText = preg_replace("/\"/","&quot;",$sanitizedText);
        $sanitizedText = preg_replace("/\//","&#x2F;",$sanitizedText);

        return $sanitizedText;
    }

?>