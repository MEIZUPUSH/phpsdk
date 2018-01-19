<?php

class HttpManager
{
    public static function post($url, $params, $use_http_build_query = true)
    {
        return @self::fsockopen($url, 0, $params);
    }

    public static function fsockopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE, $encodetype  = 'URLENCODE', $allowcurl = TRUE, $position = 0, $files = array()) {
        $return = '';
        $matches = parse_url($url);
        $scheme = $matches['scheme'];
        $host = $matches['host'];
        $path = $matches['path'] ? $matches['path'].((isset($matches['query']) && $matches['query']) ? '?'.$matches['query'] : '') : '/';
        $port = !empty($matches['port']) ? $matches['port'] : ($scheme == 'http' ? '80' : '');
        $boundary = $encodetype == 'URLENCODE' ? '' : self::random(40);

        if($post) {
            if(!is_array($post)) {
                parse_str($post, $post);
            }
            self::_format_postkey($post, $postnew);
            $post = $postnew;
        }
        if(function_exists('curl_init') && function_exists('curl_exec') && $allowcurl) {
            $ch = curl_init();
            $httpheader = array();
            if($ip) {
                $httpheader[] = "Host: ".$host;
            }
            if($httpheader) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
            }
            curl_setopt($ch, CURLOPT_URL, $scheme.'://'.($ip ? $ip : $host).($port ? ':'.$port : '').$path);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            if($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                if($encodetype == 'URLENCODE') {
                    $post = http_build_query($post);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                } else {
                    foreach($post as $k => $v) {
                        if(isset($files[$k])) {
                            $post[$k] = '@'.$files[$k];
                        }
                    }
                    foreach($files as $k => $file) {
                        if(!isset($post[$k]) && file_exists($file)) {
                            $post[$k] = '@'.$file;
                        }
                    }
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                }
            }
            if($cookie) {
                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
            }
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $data = curl_exec($ch);
            $status = curl_getinfo($ch);
            $errno = curl_errno($ch);
            curl_close($ch);
            if($errno || $status['http_code'] != 200) {
                return;
            } else {
                $GLOBALS['filesockheader'] = substr($data, 0, $status['header_size']);
                $data = substr($data, $status['header_size']);
                return !$limit ? $data : substr($data, 0, $limit);
            }
        }

        if($post) {
            if($encodetype == 'URLENCODE') {
                $data = http_build_query($post);
            } else {
                $data = '';
                foreach($post as $k => $v) {
                    $data .= "--$boundary\r\n";
                    $data .= 'Content-Disposition: form-data; name="'.$k.'"'.(isset($files[$k]) ? '; filename="'.basename($files[$k]).'"; Content-Type: application/octet-stream' : '')."\r\n\r\n";
                    $data .= $v."\r\n";
                }
                foreach($files as $k => $file) {
                    if(!isset($post[$k]) && file_exists($file)) {
                        if($fp = @fopen($file, 'r')) {
                            $v = fread($fp, filesize($file));
                            fclose($fp);
                            $data .= "--$boundary\r\n";
                            $data .= 'Content-Disposition: form-data; name="'.$k.'"; filename="'.basename($file).'"; Content-Type: application/octet-stream'."\r\n\r\n";
                            $data .= $v."\r\n";
                        }
                    }
                }
                $data .= "--$boundary\r\n";
            }
            $out = "POST $path HTTP/1.0\r\n";
            $header = "Accept: */*\r\n";
            $header .= "Accept-Language: zh-cn\r\n";
            $header .= $encodetype == 'URLENCODE' ? "Content-Type: application/x-www-form-urlencoded\r\n" : "Content-Type: multipart/form-data; boundary=$boundary\r\n";
            $header .= 'Content-Length: '.strlen($data)."\r\n";
            $header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $header .= "Host: $host:$port\r\n";
            $header .= "Connection: Close\r\n";
            $header .= "Cache-Control: no-cache\r\n";
            $header .= "Cookie: $cookie\r\n\r\n";
            $out .= $header;
            $out .= $data;
        } else {
            $out = "GET $path HTTP/1.0\r\n";
            $header = "Accept: */*\r\n";
            $header .= "Accept-Language: zh-cn\r\n";
            $header .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $header .= "Host: $host:$port\r\n";
            $header .= "Connection: Close\r\n";
            $header .= "Cookie: $cookie\r\n\r\n";
            $out .= $header;
        }

        $fpflag = 0;
        if(!$fp = @self::fsocketopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout)) {
            $context = array(
                'http' => array(
                    'method' => $post ? 'POST' : 'GET',
                    'header' => $header,
                    'content' => $post,
                    'timeout' => $timeout,
                ),
            );
            $context = stream_context_create($context);
            $fp = @fopen($scheme.'://'.($ip ? $ip : $host).':'.$port.$path, 'b', false, $context);
            $fpflag = 1;
        }

        if(!$fp) {
            return '';
        } else {
            stream_set_blocking($fp, $block);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if(!$status['timed_out']) {
                while (!feof($fp) && !$fpflag) {
                    $header = @fgets($fp);
                    $headers .= $header;
                    if($header && ($header == "\r\n" ||  $header == "\n")) {
                        break;
                    }
                }
                $GLOBALS['filesockheader'] = $headers;

                if($position) {
                    for($i=0; $i<$position; $i++) {
                        $char = fgetc($fp);
                        if($char == "\n" && $oldchar != "\r") {
                            $i++;
                        }
                        $oldchar = $char;
                    }
                }

                if($limit) {
                    $return = stream_get_contents($fp, $limit);
                } else {
                    $return = stream_get_contents($fp);
                }
            }
            @fclose($fp);
            return $return;
        }
    }

    public static function _format_postkey($post, &$result, $key = '') {
        foreach($post as $k => $v) {
            $_k = $key ? $key.'['.$k.']' : $k;
            if(is_array($v)) {
                self::_format_postkey($v, $result, $_k);
            } else {
                $result[$_k] = $v;
            }
        }
    }

    public static function fsocketopen($hostname, $port = 80, &$errno, &$errstr, $timeout = 15) {
        $fp = '';
        if(function_exists('fsockopen')) {
            $fp = @fsockopen($hostname, $port, $errno, $errstr, $timeout);
        } elseif(function_exists('pfsockopen')) {
            $fp = @pfsockopen($hostname, $port, $errno, $errstr, $timeout);
        } elseif(function_exists('stream_socket_client')) {
            $fp = @stream_socket_client($hostname.':'.$port, $errno, $errstr, $timeout);
        }
        return $fp;
    }

    public static function random($length, $numeric = 0) {
        $seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
        $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
        if($numeric) {
            $hash = '';
        } else {
            $hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
            $length--;
        }
        $max = strlen($seed) - 1;
        for($i = 0; $i < $length; $i++) {
            $hash .= $seed{mt_rand(0, $max)};
        }
        return $hash;
    }
}
