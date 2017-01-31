<?php

/**
 * Created by PhpStorm.
 * User: ustal
 * Date: 31.01.17
 * Time: 9:50
 */
class GetBase64 extends Api
{
    public function setData($post, $files=null) {
        if (is_array($files)) {
             $file = array_shift($files);
             if (file_exists($file['tmp_name'])) {
                 $data = file_get_contents($file['tmp_name']);
                 $this->data = base64_encode($data);
                 $this->success = true;
             }
        }
    }
}