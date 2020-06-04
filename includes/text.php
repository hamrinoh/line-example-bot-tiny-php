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

    $msg = "";
    if ($page) {

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom->loadHTML($page);

        
        // 用 tag 名稱擷取
        $h2s = $dom->getElementsByTagName('h2');
        $msg .= "開獎期間：".$h2s[1]->textContent."\n";

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
            $msg .= $dates[4]->textContent;
        } else {
            $msg .= "查無資料:";
        }
        libxml_clear_errors();
    } else {
        $msg .= "無法取得網頁";
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

/*
if ($message['text'] == "中央新聞社"){

    $url = "https://www.cna.com.tw/list/aall.aspx";
    $page = file_get_contents($url);
    // echo $page;

    if ($page) {

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $dom -> loadHTML('<?xml encoding="utf-8" ?>' .$page);
        // $dom -> loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));

        echo "<h1>中央社即時新聞</h1>";
        // 用 tag 名稱擷取
        $main = $dom->getElementById('jsMainList');
        $lists = $main->getElementsByTagName('li');

        $i=1;
        foreach ($lists as $node) {
            
            // 取得標題文字
            $ntxts = $node -> getElementsByTagName('span');
            $ntxt  = $ntxts[0]->textContent;

            // 取得超連結
            $links = $node->getElementsByTagName('a');
            $href  = $links[0]->getAttribute('href');
            
            // 取得日期時間
            $ndate = getElementsByClassName($node, 'date');
            $sdate = $ndate[0]->textContent;

            // 顯示結果
            echo "<p>".strval($i).".".$sdate." ".$ntxt."(".$href.")</p>";
            $i++;
        }

        libxml_clear_errors();
    } else {
        echo "無法取得網頁";
    }

    /*
    $doc = new DOMDocument();
    $doc -> loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));
    echo $doc->saveHTML();
    */

?>