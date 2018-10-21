<?php

include __DIR__ . '/vendor/autoload.php'; // 引入 composer 入口文件

use EasyWeChat\Foundation\Application;

$options = [
    'debug'  => true,
    'app_id' => 'wx41062c669764375f',
    'secret' => 'ef2f6981aff5d6d83c88868c9874f9f6',
    'token'  => 'dongsanqian',
    'aes_key' => 'a4TXQM8Q7uBOOEPmCRCfXNUlkN56Bxe84MqXJbJ7g0C', // 可选

    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],

    //...
];

$app = new Application($options);
$server = $app->server;

$accessToken = $app->access_token->getToken(); // EasyWeChat\Core\AccessToken 实例
file_put_contents('/tmp/del', $accessToken);

$server->setMessageHandler(function ($message) {
    switch ($message->MsgType) {
        case 'event':
            return '收到事件消息';
            break;
        case 'text':
            $post = [
                'reqType' => 0,
                'perception' => [
                            'inputText' => [
                                'text' => $message->Content
                              ]
                        ],
                 'userInfo' => [
                            'apiKey' => '739f028a9706408084f4a281c1756edd',
                            'userId' => md5($message->FromUserName),
                 ],
            ];
            
            $save = [$message->FromUserName, $message->Content, date('Y-m-d H:i:s')];
            file_put_contents('/home/menmei/wechat.log', implode(' | ', $save) . "\n", FILE_APPEND);
            
            $url= 'http://openapi.tuling123.com/openapi/api/v2';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                return(curl_error($ch));
            }
            curl_close($ch);
            $ret = json_decode($result,TRUE);
            return isset($ret['results'][0]['values']['text']) ? ($ret['results'][0]['values']['text']) : '罢工了，等会儿来。';
            break;
        case 'image':
            return '收到图片消息';
            break;
        case 'voice':
            /* $post = [
                    'reqType' => 2,
                    'perception' => [
                        'inputMedia' => [
                        'url' => $message->MediaId
                    ]
                ],
                'userInfo' => [
                    'apiKey' => '739f028a9706408084f4a281c1756edd',
                    'userId' => md5($message->FromUserName),
                ],
            ];
            
            $save = [$message->FromUserName, $message->MediaId, date('Y-m-d H:i:s')];
            file_put_contents('/home/menmei/wechat.log', implode(' | ', $save) . "\n", FILE_APPEND);
            
            $url= 'http://openapi.tuling123.com/openapi/api/v2';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
            $result = curl_exec($ch);
            if(curl_errno($ch)){
                return(curl_error($ch));
            }
            curl_close($ch); */
            return '收到语音消息';
            //return $message->MediaId;
            break;
        case 'video':
            return '收到视频消息';
            break;
        case 'location':
            return '收到坐标消息';
            break;
        case 'link':
            return '收到链接消息';
            break;
        // ... 其它消息
        default:
            return '收到其它消息';
            break;
    }

    // ...
});

$response = $app->server->serve();

// 将响应输出
$response->send(); // Laravel 里请使用：return $response;

