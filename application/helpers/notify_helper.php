<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sendNotification($deviceToken, $badge)
{
	$message = 'Your Match Finished. Check the result!';
	$ctx = stream_context_create();
	if(!$deviceToken)
		$deviceToken = 'ab8236f5377302508205fb46a603a3c7854506ebc1493e4d92fac858a3de17fd';
	stream_context_set_option($ctx, 'ssl', 'local_cert', dirname(__FILE__).'/ck.pem');
	/**/
	$apn = 'ssl://gateway.push.apple.com:2195';
	stream_context_set_option($ctx, 'ssl', 'passphrase', 'zinteo1');/**
	$apn = 'ssl://gateway.sandbox.push.apple.com:2195';
	stream_context_set_option($ctx, 'ssl', 'passphrase', 'antonio');/**/
	
	// Open a connection to the APNS server
	$fp = stream_socket_client( $apn, $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
	
	if (!$fp)
		return ("Failed to connect: $err $errstr" . PHP_EOL);
	
	//return 'Connected to APNS' . PHP_EOL;
	
	// Create the payload body
	$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default',
			'badge' => $badge
	);
	
	// Encode the payload as JSON
	$payload = json_encode($body);
	
	// Build the binary notification
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));
	
	
	if (!$result)
		return 'Message not delivered' . PHP_EOL;
	else
		return 'Message successfully delivered' . PHP_EOL;
	
	// Close the connection to the server
	fclose($fp);
}
