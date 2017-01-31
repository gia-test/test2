<?php


class SayHello extends Api
{
    const SHORT_COUNT = 2;
    const LONG_COUNT = 15;
    const DIFF_CHARS_COUNT = 2;
    const GOOGLE_API_KEY = '';

    public function setData($post, $file=null)
    {
        if (isset($post['name']) && $this->isValid($post['name'])) {
            $hello = 'Hello';
            if (isset($post['language'])) {
                $hello = $this->translate($hello, $post['language']);
            }
            $this->success = $this->hasError();
            $this->data = $hello . ' ' . $post['name'];
        } else {
            $this->data = $this->getErrors();
        }
    }

    protected function isValid($str)
    {
        $count = mb_strlen($str);
        $this->checkIfLong($count);
        $this->checkIfShort($count);
        $this->checkDiffChars($str);
        return $this->hasError();
    }

    private function checkIfLong($count)
    {
        if ($count > self::LONG_COUNT) {
            $this->addError('Name is too long');
        }
    }

    private function checkIfShort($count)
    {
        if ($count <= self::DIFF_CHARS_COUNT) {
            $this->addError('Name is too short');
        }
    }

    private function checkDiffChars($str)
    {
        $result = array_flip(str_split($str));
        $countDiffChar = count($result);
        if ($countDiffChar < self::DIFF_CHARS_COUNT) {
            $this->addError("Please enter valid name");
        }
    }

    private function translate($word, $lang) {
        $google_url = "https://www.googleapis.com/language/translate/v2?key=" . self::GOOGLE_API_KEY . "&q=" . $word . "&source=en&target=" . $lang;
        $handle = curl_init($google_url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);
        $responseDecoded = json_decode($response, true);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        if ($httpCode == 200) {
            $result = $responseDecoded['data']['translations'][0]['translatedText'];
        }
        else {
            $result = $word;
        }

        return $result;
    }
}