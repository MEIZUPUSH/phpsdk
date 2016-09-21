<?php

/**
 * SDK调用demo，详细参数传递，请参照使用说明文档
 * 说明：pushId由IMEI+appId构成，如：868773027203481100999，其中868773027203481 为IMEI号，100999为appId
 * User: even
 * Date: 2016/8/25
 * Time: 20:30
 */


include __DIR__ . '/../mzPushSDK/MzPush.php';



//参数分别对应appId，appSecret
$mzPush = new MzPush(100999, '531732bc45324098978bf41c6954c09e');

//透传消息对象
$unvarnishedMessage = new UnvarnishedMessage();
$unvarnishedMessage->setTitle('标题')->setContent('透传消息内容');

//通知栏消息对象
$varnishedMessage = new VarnishedMessage();
$varnishedMessage->setTitle('通知标题')->setContent('通知栏内容')->setClickType(2)->setUrl('http://www.baidu.com/')->setNoticeExpandType(1)->setNoticeExpandContent('扩展内容')->setOffLine(1);

//=================================消息推送相关==================
/**
 * 透传消息push，根据pushid
 * @param $pushIds pushid集合，
 * @param $unvarnishedMessage 通知栏消息对象实例
 */
var_dump($mzPush->unvarnishedPush(array('868773027203481100999'), $unvarnishedMessage));

/**
 * 通知栏消息，根据pushid
 * @param $pushIds pushid集合，
 * @param $varnishedMessage 通知栏消息对象实例
 */
var_dump($mzPush->varnishedPush(array('868773027203481100999'), $varnishedMessage));
//===========================end=============================





//========================获取推送任务taskId================================
/**
 * 获取通知栏推送 taskId
 * @param $pushType 取值为1或者0,1代表透传消息，0:代表通知栏
 * @param $message  对应的消息对象
 *
 */
$ret = json_decode($mzPush->getTaskId(0 , $varnishedMessage), true);
$varnishedTaskId = $ret['value']['taskId'];
var_dump($ret);

//根据通知栏消息taskId push
/**
 * 根据taskId 通知栏消息推送给多用户
 * @param $taskId 通知栏消息类型的taskId
 * @param $pushIds
 */
var_dump($mzPush->taskVarnished($varnishedTaskId,  array('868773027203481100999')));


//==============================获取透传taskId=====================
/**
 * 获取通知栏推送 taskId
 * @param $pushType 取值为1或者0,1代表透传消息，0:代表通知栏
 * @param $message  对应的消息对象
 *
 */
$ret = json_decode($mzPush->getTaskId(1 , $unvarnishedMessage), true);
var_dump($ret);
$unvarnishedTaskId = $ret['value']['taskId'];

//根据透传消息taskId推送
//var_dump($mzPush->taskUnvarnished($unvarnishedTaskId,  array('868773027203481100999')));



//=========================推送给所用App用户===========================
//所有给所有用户，通知栏消息，返回taskId, 不需要二次调用 taskVarnished，系统会自动推送
$ret = json_decode($mzPush->pushToApp(0 , $varnishedMessage), true);
var_dump($ret);
$varnishedAllUserTaskId = $ret['value']['taskId'];
//所有给所有用户，透传消息，返回taskId，系统会自动推送
$ret = json_decode($mzPush->pushToApp(1 , $unvarnishedMessage), true);
var_dump($ret);
$unvarnishedAllUserTaskId = $ret['value']['taskId'];

//取消推送,只能取消 pushToApp返回的taskId
//var_dump($mzPush->cancelTask(0, $varnishedAllUserTaskId));
//var_dump($mzPush->cancelTask(1, $unvarnishedAllUserTaskId));








