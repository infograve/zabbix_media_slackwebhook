#!/usr/bin/php

<?php
/* ########## config ########## */
$urlSlackWebhook = 'https://hooks.slack.com/services/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';

/* ********** Get Argument ********** */
$argument = array(0=>'',1=>'',2=>'',3=>'');
if($argc>0) $argument = $argv + $argument;

/* ********** Create Payload ********** */
$message = array(
  'text' => $argument[2]
);

$message = json_encode($message);
$payload = 'payload='.urlencode($message);

/* ********** Send to SlackWebhook ********** */
$handlerCURL = curl_init();
curl_setopt($handlerCURL,CURLOPT_URL,$urlSlackWebhook);
curl_setopt($handlerCURL,CURLOPT_POST,true);
curl_setopt($handlerCURL,CURLOPT_RETURNTRANSFER,true);
curl_setopt($handlerCURL,CURLOPT_TIMEOUT,10);
curl_setopt($handlerCURL,CURLOPT_POSTFIELDS,$payload);
$result = curl_exec($handlerCURL);
curl_close($handlerCURL);

return $result;
?>
