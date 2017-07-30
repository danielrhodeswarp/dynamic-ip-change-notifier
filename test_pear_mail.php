<?php

include('Mail.php');

$mail = Mail::factory('smtp',
	array
	(
		'host' => 'ssl://mail.example.com',
		'port' => 465,
		'auth' => true,
		'username' => 'you@example.com',
		'password' => 'abracadabra'
	)
);

$send_result = $mail->send('you@example.com, someone@example.com', array('From' => 'donotreply@yourorganisation.co', 'Subject' => 'Test Mail'), 'This is a test');

VAR_DUMP($send_result);
