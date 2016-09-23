<?php

/**
 * 打包
 *
 * User: even
 * Date: 2016/8/25
 * Time: 18:05
 */
class MzMessage {
    public function pack(&$message) {
        foreach ($message as $key => &$value) {
            if (is_array($value)) {
                $this->pack($value);
            } else {
                if (is_null($value)) {
                    unset($message[$key]);
                }
                
            }
        }
        unset($value);
        return $message;
    }

    public function toJson(&$message) {
        if (version_compare(PHP_VERSION, '5.4.0', '<')) {
            throw new MzException(" php version at least 5.4.0");
        }

        return json_encode($this->pack($message), JSON_UNESCAPED_UNICODE);
    }

}