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


if ($message['text'] == "靜儀是天使嗎?"){

    $people = array('天使', '惡魔');

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


if ($message['text'] == "統一發票"){

    $url = "http://invoice.etax.nat.gov.tw";

    $page = file_get_contents($url);

    $msg = "今天是".date("Y-m-d");

    $msg = "";
    if ($page) {

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($page);

        // 用 tag 名稱擷取
        $h2s = $dom->getElementsByTagName('h2');
        echo "開獎期間：".$h2s[1]->textContent."\n";

        $xpath = new DOMXPath($dom);
        // 用 class 名稱擷取
        $nodes = $xpath->query("//span[contains(@class,'t18Red')]");
        $count = $nodes->length;
        $dates = $xpath->query("//p[contains(@class,'date')]");
        // echo "<p>Number:$count</p>";

        if ($count>0) {
            $msg .= "特別獎 ".$nodes[0]->textContent."\n";
            $msg .= "特獎 ".$nodes[1]->textContent."\n";
            $msg .= "頭獎 ".$nodes[2]->textContent."\n";
            $msg .= "增開六獎 ".$nodes[3]->textContent."\n";
            $msg .= $dates[0]->textContent;
        } else {
            echo "查無資料:";
        }
        libxml_clear_errors();
    } else {
        echo "無法取得網頁";
    }


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