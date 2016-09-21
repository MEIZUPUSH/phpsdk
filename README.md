# 魅族开放平台PUSH系统PHP版本SDK

**文档变更记录**

| 日期 | 作者 | 版本 | 变更描述 |
| --- | --- | --- | --- |
| 2016-08-26 | EvenZhou | 1.0 | 撰写文档 |

# **安装说明**
- **composer方式安装**
```json
  "require": {
    "evenzhou/mzpushsdk":"1.0.x-dev"
  }
```

- **不支持composer情况下**

	手动include mzPushSDK目录下autoload.php





# **类型定义**

## **返回格式**
```
{
	"code":"", //必选,返回码
	"message":"", //可选，返回消息，网页端接口出现错误时使用此消息展示给用户，手机端可忽略此消息，甚至服务端不传输此消息
	"value":"",// 必选，返回结果
	"redirect":"" //可选, returnCode=300 重定向时，使用此 URL 重新请求
}

```

## **返回码**

| **Code** | **Value** |
| --- | --- |
| 200 | 正常 |
| 500 | 其他异常 |
| 1001 | 系统错误 |
| 1003 | 服务器忙 |
| 1005 | 参数错误，请参考 API 文档 |
| 1006 | 签名认证失败 |
| 110000 | appId 不合法 |
| 110001 | appKey 不合法 |
| 110002 | pushId 未注册 |
| 110003 | pushId 非法 |
| 110004 | 参数不能为空 |
| 110009 | 应用被加入黑名单 |


## **嵌套返回码**

| **Code** | **Value** |
| --- | --- |
| 201 | 没有权限，服务器主动拒绝 |
| 501 | 推送消息失败（ db\_error） |
| 513 | 推送消息失败 |
| 518 | 推送超过配置的速率 |
| 519 | 推送消息失败服务过载 |
| 520 | 消息折叠（短时间内同一设备同一消息收到多次） |
| 110002 | pushId 未订阅 |
| 110003 | pushId 非法 |


## **推送服务接口MzPush**

实例参数：

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| appId | Long | 是 | null | 应用appId |
| appSecret | String | 是 | null | app\_secret |
| useSSL | boolen | 否 | false | https 或者http传输协议 |

## **通知消息**

UnvarnishedMessage

VarnishedMessage

### **透传消息UnvarnishedMessage：**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| title | String | 是 | null | 推送标题,任务推送建议填写，方便数据查询,【字数限制 1~100】 |
| content | String | 是 | null | 推送内容,【必填，字数限制 2000 以内】 |
| offLine | int | 否 | 1 | 是否进离线消息,【非必填，默认为 1】 |
| validTime | int | 否 | 24 | 有效时长 (1 72 小时内的正整数), 【offLine值为 1 时，必填，值的范围 1--72】 |
| pushTimeType | int | 否 | 0 | int 定时推送 (0, &quot;即时&quot;),(1, &quot;定时&quot;), 【只对全部用户推送生效】 |
| startTime | date | 否 | null | 任务定时开始时间, 【pushTimeType 为 1必填】只对全部用户推送生效，如：2016-08-21 |
| fixSpeed | int | 否 | 0 | 是否定速推送, 0 或 1【非必填，默认值为 0】 |
| fixSpeedRate | int | 否 | 0 | 定速速率 【fixSpeed 为 1 时，必填】 |

### **通知栏消息VarnishedMessage**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| title | String | 是 | null | 推送标题,任务推送建议填写，方便数据查询,【字数限制 1~100】 |
| content | String | 是 | null | 推送内容,【必填，字数限制 2000 以内】 |
| noticeBarType | int | 否 | 0 | 通知栏样式(0, &#39;标准&#39;)【非必填，默认值为 0】 |
| noticeExpandType | int | 否 | 0 | 展开方式 (0, &#39;标准&#39;),(1, &#39;文本&#39;)【非必填，默认值为 0】 |
| noticeExpandContent | String | 否 | null | 展开内容, 【noticeExpandType 为文本时，必填】 |
| clickType | int | 否 | 0 | 点击动作 (0,&#39;打开应用&#39;),(1,&#39;打开应用页面&#39;),(2,&#39;打开 URI 页面&#39;),【非必填，默认值为0】 |
| url | String | 否 | null | URI 页面地址, 【clickType 为打开 URI 页面时，必填, 长度限制 1000】 |
| parameters | array | 否 | null | 透传参数 【array格式，非必填】 |
| activity | String | 否 | null | 应用页面地址, 【clickType 为打开应用页面时，必填, 长度限制 1000】 |
| offLine | int | 否 | 1 | 是否进离线消息, (0 否 1 是[validTime])【非必填，默认值为 1】 |
| validTime | int | 否 | 24 | 有效时长 (1~72 小时内的正整数), 【offLine值为 1 时，必填，值的范围 1~72】 |
| pushTimeType | int | 否 | 0 | 定时推送 (0, &#39;即时&#39;),(1, &#39;定时&#39;), 【只对全部用户推送生效】 |
| startTime | date | 否 | null | 任务定时开始时间【非必填 , ，pushTimeType为 True 必填】只对全部用户推送生效, 如：2016-08-20 |
| fixSpeed | int | 否 | 0 | 是否定速推送, 【非必填，默认值为 0】 |
| fixSpeedRate | int | 否 | 0 | 定速速率,【FixSpeed 为 1 时，必填】 |
| suspend | int | 否 | 1 | 是否通知栏悬浮窗显示 (1显示，0 不显示)【非必填，默认 1】 |
| clearNoticeBar | int | 否 | 1 | 是否可清除通知栏 (1 可以 0 不可以) |
| vibrate | int | 否 | 1 | 震动 (0关闭 1 开启) |
| lights | int | 否 | 1 | 闪光 (0关闭 1 开启) |
| sound | int | 否 | 1 | 声音 (0关闭 1 开启) |

# **接口说明**

## **非任务推送**

### **通知栏消息推送（varnishedPush方法）**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| pushIds | Array | 是 | null | 需要推送的pushId集合 |
| varnishedMessage | VarnishedMessage | 是 | null | VarnishedMessage对象实例 |

### **透传消息推送 UnvarnishedPush方法**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| pushIds | Array | 是 | null | 需要推送的pushId集合 |
| unvarnishedMessage | UnvarnishedMessage | 是 | null | unvarnishedMessage对象实例 |

## **任务类推送**

### **获取推送 taskId（getTaskId）**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| pushType | Int | 是 | null | 取值为0或者1。1为透传消息，0为通知栏消息 |
| message | VarnishedMessage或者UnVarnishedMessage | 是 | null | 通知消息类型实例，应该与对应的pushType相对应 |

### **推送给所有APP用户（pushToApp方法）**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| pushType | Int | 是 | null | 取值为0或者1。1为透传消息，0为通知栏消息 |
| message | VarnishedMessage或者UnVarnishedMessage | 是 | null | 通知消息类型实例，应该与对应的pushType相对应 |

此接口调用之后，系统会自动推送给所有APP用户，不需要另外处理

### **任务透传消息推送（taskUnvarnished）**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| taskId | Int | 是 | null | taskId |
| pushIds | Array | 是 | null | 需要推送的pushId集合 |

### **任务通知栏消息推送（taskVarnished）**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| taskId | Int | 是 | null | taskId |
| pushIds | Array | 是 | null | 需要推送的pushId集合 |

### **取消推送任务（cancelTask）**

| 参数名称 | 类型 | 必填 | 默认值 | 描述 |
| --- | --- | --- | --- | --- |
| pushType | Int | 是 | null | 取值为0或者1。1为透传消息，0为通知栏消息 |
| taskId | Int | 是 | null | 消息类型对应的taskId |

> 取消推送只能取消pushToApp接口返回的taskId
