<?php
/**
 * Copyright 2017 GoneTone
 *
 * Line Bot
 * 範例 Example Bot 執行主文件
 *
 * 此範例 GitHub 專案：https://github.com/GoneTone/line-example-bot-php
 * 官方文檔：https://developers.line.biz/en/reference/messaging-api/
 */
error_reporting(0); // 不顯示錯誤 (Debug 時請註解掉)
date_default_timezone_set("Asia/Taipei"); // 設定時區為台北時區

require_once('LINEBotTiny.php');

if (file_exists(__DIR__ . '/config.ini')) {
    $config = parse_ini_file("config.ini", true); // 解析配置檔
    if ($config['Channel']['Token'] == Null || $config['Channel']['Secret'] == Null) {
        error_log("config.ini 配置檔未設定完全！", 0); // 輸出錯誤
    } else {
        $channelAccessToken = $config['Channel']['Token'];
        $channelSecret = $config['Channel']['Secret'];
    }
} else {
    $configFile = fopen("config.ini", "w") or die("Unable to open file!");
    $configFileContent = '; Copyright 2019 GoneTone
;
; Line Bot
; 範例 Example Bot 配置文件
;
; 此範例 GitHub 專案：https://github.com/GoneTone/line-example-bot-php
; 官方文檔：https://developers.line.biz/en/reference/messaging-api/

[Channel]
; 請在雙引號內輸入您的 Line Bot "Channel access token"
Token = ""

; 請在雙引號內輸入您的 Line Bot "Channel secret"
Secret = ""
';
    fwrite($configFile, $configFileContent); // 建立文件並寫入
    fclose($configFile); // 關閉文件
    error_log("config.ini 配置檔建立成功，請編輯檔案填入資料！", 0); // 輸出錯誤
}

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    require_once('includes/text.php'); // Type: Text
                    require_once('includes/image.php'); // Type: Image
                    require_once('includes/video.php'); // Type: Video
                    require_once('includes/audio.php'); // Type: Audio
                    require_once('includes/location.php'); // Type: Location
                    require_once('includes/sticker.php'); // Type: Sticker
                    require_once('includes/imagemap.php'); // Type: Imagemap
                    require_once('includes/template.php'); // Type: Template
                    break;
                default:
                    //error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        case 'postback':
            //require_once('postback.php'); // postback
            break;
        case 'follow': // 加為好友觸發
            $client->replyMessage(array(
                'replyToken' => $event['replyToken'],
                'messages' => array(
                    array(
                        'type' => 'text',
                        'text' => '感謝您加入二書小站，若不想接收提醒，可以點選本畫面右上方的選單圖示，然後關閉「提醒」的設定喔'
                    )
                )
            ));
            break;
        case 'join': // 加入群組觸發
            $client->replyMessage(array(
                'replyToken' => $event['replyToken'],
                'messages' => array(
                    array(
                        'type' => 'text',
                        'text' => '您好~歡迎您來到二書小站，我們這邊有提供各式各樣的書籍及物品，我是客服人員二二，有問題歡迎隨時詢問我哦~'
                    )
                )
            ));
            break;
        default:
            //error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
};
?>
