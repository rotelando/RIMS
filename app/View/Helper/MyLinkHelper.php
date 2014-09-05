<?php

class MyLinkHelper extends AppHelper {

    public function getImageUrlPath($filename) {

//        return "http://papyrusapi.alexanderharing.com/files/images/" . $filename;
//        return "http://staging-api.fieldmaxpro.com/files/images/"  . $filename;
        return "http://rims.local/assets/images/" . $filename;
    }
    
    public function getLastVisitedUrl() {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->url['here'];
    }
}