<?php
include __DIR__ . '/vendor/autoload.php'; 

use EasyWeChat\Foundation\Application;

$options = [
    'debug'  => true,
    'app_id' => 'wx41062c669764375f',
    'secret' => '4a188eb5c6004c2a1cb73a4108c4eb82',
    'token'  => 'dongsanqian',
    'aes_key' => 'a4TXQM8Q7uBOOEPmCRCfXNUlkN56Bxe84MqXJbJ7g0C', // 可选

    'log' => [
        'level' => 'debug',
        'file'  => '/tmp/easywechat.log',
    ],

    //...
];

$app = new Application($options);

$menu = $app->menu;

$buttons = [
    [
        "type" => "click",
        "name" => "历史文章",
        "key"  => "V1001_HISTORY",
        "url" => "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI3NjE1NjA1OQ==#wechat_redirect"
    ],
];
$menu->add($buttons);

//https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI3NjE1NjA1OQ==#wechat_redirect
