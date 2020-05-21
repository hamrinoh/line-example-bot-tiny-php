<?php
/**
 * Copyright 2017 GoneTone
 *
 * Line Bot
 * 範例 Example Bot (Text)
 *
 * 此範例 GitHub 專案：https://github.com/GoneTone/line-example-bot-php
 * 官方文檔：https://developers.line.biz/en/reference/messaging-api#text-message
 */
/**
陣列輸出 Json
==============================
{
    "type": "text",
    "text": "Hello, world!"
}
==============================
*/
if (strtolower($message['text']) == "text" || $message['text'] == "文字"){
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', // 訊息類型 (文字)
                'text' => 'Hello, world!' // 回復訊息
            )
        )
    ));
}

if (strtolower($message['text'] == "您好")){
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', // 訊息類型 (文字)
                'text' => '歡迎來到二書小站，我是二二!' // 回復訊息
            )
        )
    ));
}

if (strtolower($message['text'] == "今天是")){
    $date = date("Y-m-d");
    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', // 訊息類型 (文字)
                'text' => $date   // 回復訊息
            )
        )
    ));
}

if ($message['text']) == "靜儀是天使嗎?"){

    $people = array('天使', '惡魔')

    $num = rand(0, count($people)-1);

    $msg = "靜儀一直都是" . $people[$num];

    $client->replyMessage(array(
        'replyToken' => $event['replyToken'],
        'messages' => array(
            array(
                'type' => 'text', // 訊息類型 (文字)
                'text' => $msg // 回復訊息
            )
        )
    ));
}
?>