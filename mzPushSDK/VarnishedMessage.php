<?php


/**
 * 通知栏消息结构体
 *
 * User: even
 * Date: 2016/8/25
 * Time: 16:15
 */
class VarnishedMessage extends MzMessage {
    /**
     * @var String 推送标题, 【字数限制 1~32】
     */
    private $title = null;
    /**
     * @var String 推送内容, 【字数限制 1~100】
     */
    private $content = null;
    /**
     * @var int 通知栏样式(0, '标准')【非必填，默认值为 0】
     */
    private $noticeBarType = 0;
    /**
     * @var int 展开方式 (0, '标准'),(1, '文本')【非必填，默认值为 0】
     */
    private $noticeExpandType = 0;
    /**
     * @var String 展开内容, 【noticeExpandType 为文本时，必填】
     */
    private $noticeExpandContent = null;
    /**
     * @var int 点击动作 (0,'打开应用'),(1,'打开应用页面'),(2,'打开 URI 页面'),【非必填，默认值为0】
     */
    private $clickType = 0;
    /**
     * @var String URI 页面地址, 【clickType 为打开 URI 页面时，必填, 长度限制 1000】
     */
    private $url = null;
    /**
     * @var array 透传参数 【array 格式，非必填】
     */
    private $parameters = null;
    /**
     * @var String 应用页面地址, 【clickType 为打开应用页面时，必填, 长度限制 1000】
     */
    private $activity = null;
    /**
     * @var int 是否进离线消息, (0 否 1 是[validTime])【非必填，默认值为 1】
     */
    private $offLine = 1;
    /**
     * @var int 有效时长 (1~72 小时内的正整数), 【offLine值为 1 时，必填，值的范围 1~72】
     */
    private $validTime = 24;
    /**
     * @var int 定时推送 (0, '即时'),(1, '定时'), 【只对全部用户推送生效】
     */
    private $pushTimeType = 0;
    /**
     * @var String 任务定时开始时间【非必填 , ，pushTimeType为 True 必填】只对全部用户推送生效, 如：2016-08-20
     */
    private $startTime = null;
    /**
     * @var int 是否定速推送, 【非必填，默认值为 0】
     */
    private $fixSpeed = 0;
    /**
     * @var int 定速速率,【FixSpeed 为 1 时，必填】
     */
    private $fixSpeedRate = 0;
    /**
     * @var bool 是否通知栏悬浮窗显示 (1显示，0 不显示)【非必填，默认 1】
     */
    private $suspend = 1;
    
    /**
     * @var int 是否可清除通知栏 (1 可以 0 不可以)
     */
    private $clearNoticeBar = 1;
    
    /**
     * @var int 震动 (0关闭 1 开启)
     */
    private $vibrate = 1;
    
    /**
     * @var int 闪光 (0关闭 1 开启)
     */
    private $lights = 1;
    /**
     * @var int 声音 (0关闭 1 开启)
     */
    private $sound = 1;
    
    /**
     * @param String $title
     *
     * @return VarnishedMessage
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    /**
     * @param String $content
     *
     * @return VarnishedMessage
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    
    /**
     * @param int $noticeBarType
     *
     * @return VarnishedMessage
     */
    public function setNoticeBarType($noticeBarType) {
        $this->noticeBarType = $noticeBarType;
        return $this;
    }
    
    /**
     * @param int $noticeExpandType
     *
     * @return VarnishedMessage
     */
    public function setNoticeExpandType($noticeExpandType) {
        $this->noticeExpandType = $noticeExpandType;
        return $this;
    }
    
    /**
     * @param String $noticeExpandContent
     *
     * @return VarnishedMessage
     */
    public function setNoticeExpandContent($noticeExpandContent) {
        $this->noticeExpandContent = $noticeExpandContent;
        return $this;
    }
    
    /**
     * @param int $clickType
     *
     * @return VarnishedMessage
     */
    public function setClickType($clickType) {
        $this->clickType = $clickType;
        return $this;
    }
    
    /**
     * @param String $url
     *
     * @return VarnishedMessage
     */
    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }
    
    /**
     * @param array $parameters
     *
     * @return VarnishedMessage
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;
        return $this;
    }
    
    /**
     * @param String $activity
     *
     * @return VarnishedMessage
     */
    public function setActivity($activity) {
        $this->activity = $activity;
        return $this;
    }
    
    /**
     * @param int $offLine
     *
     * @return VarnishedMessage
     */
    public function setOffLine($offLine) {
        $this->offLine = $offLine;
        return $this;
    }
    
    /**
     * @param int $validTime
     *
     * @return VarnishedMessage
     */
    public function setValidTime($validTime) {
        $this->validTime = $validTime;
        return $this;
    }
    
    /**
     * @param int $pushTimeType
     *
     * @return VarnishedMessage
     */
    public function setPushTimeType($pushTimeType) {
        $this->pushTimeType = $pushTimeType;
        return $this;
    }
    
    /**
     * @param String $startTime
     *
     * @return VarnishedMessage
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
        return $this;
    }
    
    /**
     * @param boolean $fixSpeed
     *
     * @return VarnishedMessage
     */
    public function setFixSpeed($fixSpeed) {
        $this->fixSpeed = $fixSpeed;
        return $this;
    }
    
    /**
     * @param int $fixSpeedRate
     *
     * @return VarnishedMessage
     */
    public function setFixSpeedRate($fixSpeedRate) {
        $this->fixSpeedRate = $fixSpeedRate;
        return $this;
    }
    
    /**
     * @param boolean $suspend
     *
     * @return VarnishedMessage
     */
    public function setIsSuspend($suspend) {
        $this->suspend = $suspend;
        return $this;
    }
    
    /**
     * @param boolean $suspend
     *
     * @return VarnishedMessage
     */
    public function setSuspend($suspend) {
        $this->suspend = $suspend;
        return $this;
    }

    /**
     * @param int $clearNoticeBar
     *
     * @return VarnishedMessage
     */
    public function setClearNoticeBar($clearNoticeBar) {
        $this->clearNoticeBar = $clearNoticeBar;
        return $this;
    }

    /**
     * @param int $vibrate
     *
     * @return VarnishedMessage
     */
    public function setVibrate($vibrate) {
        $this->vibrate = $vibrate;
        return $this;
    }

    /**
     * @param int $lights
     *
     * @return VarnishedMessage
     */
    public function setLights($lights) {
        $this->lights = $lights;
        return $this;
    }

    /**
     * @param int $sound
     *
     * @return VarnishedMessage
     */
    public function setSound($sound) {
        $this->sound = $sound;
        return $this;
    }

    public function build() {
        $message = array(
            'noticeBarInfo'    => array(
                'noticeBarType' => $this->noticeBarType,
                'title'         => $this->title,
                'content'       => $this->content,
            ),
            'noticeExpandInfo' => array(
                'noticeExpandType'    => $this->noticeExpandType,
                'noticeExpandContent' => $this->noticeExpandContent,
            ),
            'clickTypeInfo'    => array(
                'clickType'  => $this->clickType,
                'url'        => $this->url,
                'parameters' => $this->parameters,
                'activity'   => $this->activity,
            ),
            'pushTimeInfo'     => array(
                'offLine'   => $this->offLine,
                'validTime' => $this->validTime,
            ),
            'advanceInfo'      => array(
                'suspend'          => $this->suspend,
                'clearNoticeBar'   => $this->clearNoticeBar,
                'notificationType' => array(
                    'vibrate' => $this->vibrate,
                    'lights'  => $this->lights,
                    'sound'   => $this->sound,
                )
            )
        );
        return $this->toJson($message);
    }

}