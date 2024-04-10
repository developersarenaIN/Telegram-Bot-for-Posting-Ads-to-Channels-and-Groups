<?php
/* 
THIS IS A FREE SCRIPT DON'T SELL IT.
Author: Developers Arena
POSTED at : @spamming_forum

*/

// Your Telegram bot token
$botToken = 'YOUR_BOT_TOKEN_HERE';

// Function to send message to Telegram
function sendMessage($chatId, $message, $botToken) {
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'HTML', // Set parse mode to HTML to preserve line breaks
    ];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($data)
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result, true);
}

// Function to post ad to channels and groups
function postAd($channelsGroups, $messageFile, $botToken) {
    // Read the entire contents of the message file
    $message = file_get_contents($messageFile);

    foreach ($channelsGroups as $chatId) {
        $response = sendMessage($chatId, $message, $botToken);
        if (!$response['ok']) {
            echo "TOOL BY @spamming_forum Error posting ad to {$chatId}: {$response['description']}\n";
        } else {
            echo "TOOL BY @spamming_forum Ad posted to {$chatId}\n";
        }
    }
}

// Read channel and group IDs from the file
$channelsGroups = file('ids.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Path to the file containing the ad message
$messageFile = 'ad.txt';

// Post ad to channels and groups
postAd($channelsGroups, $messageFile, $botToken);

?>