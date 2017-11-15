<?php


/**
 * 参数签名及发送请求
 *
 * User: even
 * Date: 2016/8/25
 * Time: 10:14
 */
class MzPushBase {
    protected $appId = null;
    protected $appSecret = '';
    protected $protocol = '';
    protected $host = '';
    protected $params = array();
    
    public function __construct($appId = '', $appSecret = '', $useSSL = false) {
        if(empty($appSecret) || empty($appId)) {
            throw new MzException('appId or appSecret is empty');
        }
        $this->appSecret = $appSecret;
        $this->appId = $appId;
        $this->protocol = $useSSL ? 'https://' : 'http://';
        $this->host = $this->protocol . 'server-api-push.meizu.com';
    }

    public function sign() {
        //将appId打包的参数中
        $this->params['appId'] = $this->appId;
        //对key进行排序
        ksort($this->params);
        $sign = '';
        foreach ($this->params as $key => $value) {
            $sign .= "$key=$value";
        }
        $sign .= $this->appSecret;
        $this->params['sign'] = md5($sign);
    }
    
    public function post($url) {
        $this->sign();
        $ret = HttpManager::post($url, $this->params);
        return $ret;
    }
}