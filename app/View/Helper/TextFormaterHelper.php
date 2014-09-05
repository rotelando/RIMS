<?php

class TextFormaterHelper extends AppHelper {

    public function fixTextWidth($text, $width) {

        
        if (strlen($text) < $width)
            return $text;

        $newtext = '';
        $splittedText = explode(' ', $text);
        foreach ($splittedText as $word) {
            if(strlen($newtext . $word) > $width) {
                $newtext .= '...';
                break;
            }
                
            
            $newtext .= ' ' . $word;
        }
        
        return trim($newtext);
    }
    
    public function latLongFormatter($geolocation){
        $geolocation = str_replace(array('[', ']'), '', $geolocation);
        $geo_arr = split(',', $geolocation);
        $lat = floatval($geo_arr[0]);
        $lon = floatval($geo_arr[1]);
        return array($lat, $lon);
    }
}