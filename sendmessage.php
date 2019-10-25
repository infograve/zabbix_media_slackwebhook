#!/usr/bin/php

<?php
/* ********** Get Argument ********** */
$argument = array(0=>'',1=>'',2=>'',3=>'');
if($argc>0) $argument = $argv + $argument;

/* ********** Create Payload ********** */
$messageColor = 'danger';
if(preg_match('/^OK:/',$argument[2])) $color = 'good';

$messageFields = array();
$tmpLine = explode("\n",$argument[3]);
for($count=0,$max=count($tmpLine); $count<$max; $count++){
  $tmpField = explode(': ',$tmpLine[count]);
  array_push($messageFields, array($tmpField[0]=>$tmpField[1]));
}

$message = array(
  'attachments' => array(
    array(
      'fallback' => $argument[2],
      'color' => $messageColor,
      'pretext' => '*'.$argument[2].'*',
      'fields' => json_encode($messageFields)
    )
  )
);

/*
"attachments": [
        {
            "fallback": "Required plain-text summary of the attachment.",
            "color": "#36a64f",
            "pretext": "Optional text that appears above the attachment block",
            "author_name": "Bobby Tables",
            "author_link": "http://flickr.com/bobby/",
            "author_icon": "http://flickr.com/icons/bobby.jpg",
            "title": "Slack API Documentation",
            "title_link": "https://api.slack.com/",
            "text": "Optional text that appears within the attachment",
            "fields": [
                {
                    "title": "Priority",
                    "value": "High",
                    "short": false
                }
            ],
            "image_url": "http://my-website.com/path/to/image.jpg",
            "thumb_url": "http://example.com/path/to/thumb.png",
            "footer": "Slack API",
            "footer_icon": "https://platform.slack-edge.com/img/default_application_icon.png",
            "ts": 123456789
        }
    ]

  'text' => '*'.$argument[2].'*'."\n".
*/

$message = json_encode($message);
$payload = 'payload='.urlencode($message);

/* ********** Send to SlackWebhook ********** */
$handlerCURL = curl_init();
curl_setopt($handlerCURL,CURLOPT_URL,$argument[1]);
curl_setopt($handlerCURL,CURLOPT_POST,true);
curl_setopt($handlerCURL,CURLOPT_RETURNTRANSFER,true);
curl_setopt($handlerCURL,CURLOPT_TIMEOUT,10);
curl_setopt($handlerCURL,CURLOPT_POSTFIELDS,$payload);
$result = curl_exec($handlerCURL);
curl_close($handlerCURL);

return $result;
?>
