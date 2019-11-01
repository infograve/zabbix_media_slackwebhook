#!/usr/bin/php

<?php
/* ********** Get Argument ********** */
$argument = array(0=>'',1=>'',2=>'',3=>'');
if($argc>0) $argument = $argv + $argument;

/* ********** Create Payload ********** */
$messageColor = 'danger';
if(preg_match('/^OK:/',$argument[2])) $messageColor = 'good';

$messageFields = array();
$tmpMessage = explode("\n",$argument[3]);

for($count=0,$max=count($tmpMessage);$count<$max;$count++){
  $tmpLine = explode(':::',$tmpMessage[$count]);
  array_push($messageFields, array('title'=>$tmpLine[0],'value'=>$tmpLine[1],'short'=>'true'));
}

$message = array(
  'attachments' => array(
    array(
      'fallback' => $argument[2],
      'color' => $messageColor,
      'pretext' => '*'.$argument[2].'*',
      'fields' => $messageFields
    )
  )
);

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
