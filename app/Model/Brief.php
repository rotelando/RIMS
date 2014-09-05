<?php

class Brief extends AppModel {

    var $name = 'Brief';
//    var $actsAs = array(
//        'UploadPack.Upload' => array(
//            'brief' => array(
//                'path' => ':webroot/upload/:model/:basename_:id.:extension'
//            )
//        )
//    );
    var $validate = array(
        'brief' => array(
            'rule' => array('attachmentPresence'),
            'message' => 'Select file to upload'
        )
    );

}
