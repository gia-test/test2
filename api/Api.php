<?php

abstract class Api
{
    /** @var array */
    protected $data = [];

    /** @var array */
    protected $errors = [];

    /** @var bool */
    protected $success = false;

    protected function addError($error) {
        $this->errors[] = $error;
    }

    protected function getErrors() {
        return implode(', ', $this->errors);
    }

    protected function hasError():bool {
        return empty($this->errors);
    }

    public abstract function setData($post, $files = null);

    public function getData():array {
        $status = $this->success ? 'Success': 'Error';
        return [
            'status' => $status,
            'msg' => $this->data
        ];
    }
}