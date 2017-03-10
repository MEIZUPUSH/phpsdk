<?php
/**
 * 魅族消息推送SDK
 *
 * User: even
 * Date: 2016/8/25
 * Time: 10:44
 */


//===========错误码=============
//参数错误
define('ERROR_ARGS', -1);
//非透传消息类型
define('ERROR_NOT_UNVARNISHED_MESSAGE', -2);
//非通知栏消息类型
define('ERROR_NOT_VARNISHED_MESSAGE', -3);

// =========普通常量==========
//通知栏类型
define('STATUSBAR', 0);
//透传类型
define('DIRECT', 1);




class MzPush extends MzPushBase {

    /**
     * 根据pushid 透传消息
     * @param $pushIds
     * @param $unvarnishedMessage
     *
     * @return int|mixed
     */
    public function unvarnishedPush($pushIds, $unvarnishedMessage
    ) {
        if (!($unvarnishedMessage instanceof UnvarnishedMessage)) {
            return ERROR_NOT_UNVARNISHED_MESSAGE;
        }
        $this->params = array(
            'pushIds' => is_array($pushIds) ? implode(',', $pushIds) : $pushIds,
            'messageJson' => $unvarnishedMessage->build()
        );
        return $this->post(
            $this->host . '/garcia/api/server/push/unvarnished/pushByPushId'
        );
    }

    /**
     * 通知栏消息，根据pushid
     * @param $pushIds
     * @param $varnishedMessage
     *
     * @return int|mixed
     */
    public function varnishedPush($pushIds, $varnishedMessage) {
        if (!($varnishedMessage instanceof VarnishedMessage)) {
            return ERROR_NOT_VARNISHED_MESSAGE;
        }
        $this->params = array(
            'pushIds' => is_array($pushIds) ? implode(',', $pushIds) : $pushIds,
            'messageJson' => $varnishedMessage->build()
        );

        return $this->post(
            $this->host . '/garcia/api/server/push/varnished/pushByPushId'
        );
    }

    /**
     * 获取推送 taskId
     * @param $pushType 取值为1或者0,1代表透传消息，0:代表通知栏
     * @param $message  对应的消息对象
     *
     * @return int|mixed
     */
    public function getTaskId($pushType, $message) {
        if ($pushType == STATUSBAR) {
            if (!$message instanceof VarnishedMessage) {
                return ERROR_NOT_VARNISHED_MESSAGE;
            }
        } else {
            if (!$message instanceof UnvarnishedMessage) {
                return ERROR_NOT_UNVARNISHED_MESSAGE;
            }
        }
        $this->params = array(
            'pushType' => $pushType,
            'messageJson' => $message->build()
        );
        return $this->post(
            $this->host . '/garcia/api/server/push/pushTask/getTaskId'
        );
    }

    /**
     * 获取全部用户推送 taskId
     * @param $pushType 取值为1或者0,1代办透传消息，0:代表通知栏
     * @param $message  对应的消息对象
     *
     * @return int|mixed
     */
    public function pushToApp($pushType, $message) {
        if ($pushType == STATUSBAR) {
            if (!$message instanceof VarnishedMessage) {
                return ERROR_NOT_VARNISHED_MESSAGE;
            }
        } else {
            if (!$message instanceof UnvarnishedMessage) {
                return ERROR_NOT_UNVARNISHED_MESSAGE;
            }
        }
        $this->params = array(
            'pushType' => $pushType,
            'messageJson' => $message->build()
        );
        return $this->post(
            $this->host . '/garcia/api/server/push/pushTask/pushToApp'
        );
    }
    
    /**
     * 根据taskId 通知栏消息推送给多用户
     * @param $taskId
     * @param $pushIds
     *
     * @return mixed
     */
    public function taskVarnished($taskId, $pushIds) {
        if (empty($pushIds)) {
            return ERROR_ARGS;
        }
        $this->params = array(
            'taskId' => $taskId,
            'pushIds' => is_array($pushIds) ? implode(',', $pushIds) : $pushIds
        );
        return $this->post(
            $this->host . '/garcia/api/server/push/task/varnished/pushByPushId'
        );
    }
    
    /**
     * 根据taskId 及 appId 透传消息推送给多用户
     * @param $taskId
     * @param $pushIds
     *
     * @return mixed
     */
    public function taskUnvarnished($taskId, $pushIds) {
        $this->params = array(
            'taskId' => $taskId,
            'pushIds' => is_array($pushIds) ? implode(',', $pushIds) : $pushIds
        );
        return $this->post(
            $this->host . '/garcia/api/server/push/task/unvarnished/pushByPushId'
        );
    }

    /**
     * 取消任务推送（只针对待推送和推送中的任务取消）
     * @param $pushType 
     * @param $taskId
     *
     * @return mixed
     */
    public function cancelTask($pushType, $taskId) {
        $this->params = array(
            'taskId' => $taskId,
            'pushType' => $pushType
        );
        return $this->post(
            $this->host . '/garcia/api/server/push/pushTask/cancel'
        );
    }
}

