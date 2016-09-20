<?php

/**
 * 简述
 *
 * User: even
 * Date: 2016/8/25
 * Time: 16:28
 */
class UnvarnishedMessage extends MzMessage {
    /**
     * @var String 推送标题,任务推送建议填写，方便数据查询,【字数限制 1~100】
     */
    private $title = '';
    /**
     * @var String 推送内容,【必填，字数限制 2000 以内】
     */
    private $content = '';
    /**
     * @var int 是否进离线消息,【非必填，默认为 1】
     */
    private $offLine = 1;
    /**
     * @var int 有效时长 (1 72 小时内的正整数), 【offLine值为 1 时，必填，值的范围 1--72】
     */
    private $validTime = 24;
    /**
     * @var int 定时推送 (0, "即时"),(1, "定时"), 【只对全部用户推送生效】
     */
    private $pushTimeType = 0;
    /**
     * @var String 任务定时开始时间, 【pushTimeType 为 1必填】只对全部用户推送生效，如：2016-08-21
     */
    private $startTime = null;
    /**
     * @var int 是否定速推送, 0 或 1【非必填，默认值为 0】
     */
    private $fixSpeed = 0;
    /**
     * @var int 定速速率 【fixSpeed 为 1 时，必填】
     */
    private $fixSpeedRate = 0;
    
    /**
     * @param String $title
     *
     * @return UnvarnishedMessage
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    /**
     * @param String $content
     *
     * @return UnvarnishedMessage
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
    
    /**
     * @param int $offLine
     *
     * @return UnvarnishedMessage
     */
    public function setOffLine($offLine) {
        $this->offLine = $offLine;
        return $this;
    }
    
    /**
     * @param int $validTime
     *
     * @return UnvarnishedMessage
     */
    public function setValidTime($validTime) {
        $this->validTime = $validTime;
        return $this;
    }
    
    /**
     * @param int $pushTimeType
     *
     * @return UnvarnishedMessage
     */
    public function setPushTimeType($pushTimeType) {
        $this->pushTimeType = $pushTimeType;
        return $this;
    }
    
    /**
     * @param String $startTime
     *
     * @return UnvarnishedMessage
     */
    public function setStartTime($startTime) {
        $this->startTime = $startTime;
        return $this;
    }
    
    /**
     * @param int $fixSpeed
     *
     * @return UnvarnishedMessage
     */
    public function setFixSpeed($fixSpeed) {
        $this->fixSpeed = $fixSpeed;
        return $this;
    }
    
    /**
     * @param int $fixSpeedRate
     *
     * @return UnvarnishedMessage
     */
    public function setFixSpeedRate($fixSpeedRate) {
        $this->fixSpeedRate = $fixSpeedRate;
        return $this;
    }
    
    public function build() {
        $message = array(
            'title'        => $this->title,
            'content'      => $this->content,
            "pushTimeInfo" => array(
                "offLine"      => $this->offLine,
                "validTime"    => $this->validTime,
                'pushTimeType' => $this->pushTimeType,
                'startTime'    => $this->startTime,
            ),
            'advanceInfo'  => array(
                'fixSpeed'     => $this->fixSpeed,
                'fixSpeedRate' => $this->fixSpeedRate,
            ),
        );
        return $this->toJson($message);
    }
    
    
}