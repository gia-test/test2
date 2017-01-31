<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

function __autoload($classname) {
    $filename = "./api/". ucfirst($classname) .".php";
    if (file_exists($filename)) {
        require_once $filename;
    }
    else {
        throw new Exception('File not found');
    }
}

$urlArr = explode('/', $_SERVER['REQUEST_URI']);
if ($urlArr[1] == 'api' && isset($urlArr[2]) && $urlArr != 'Api') {
    $apiName = ucfirst($urlArr[2]);

    /** @var Api $apiClass */
    $apiClass = new $apiName();
    $apiClass->setData($_POST, $_FILES);
    $result = $apiClass->getData();

    echo json_encode($result);
}


// curl -F filename=test.txt -F file=@/home/user/test.txt http://127.0.0.1/api/getBase64