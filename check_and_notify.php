<?php

//----main-------------------------------------

$current_ip = get_current_ip();

$previous_ip = load_previous_ip();

if($current_ip !== $previous_ip)
{
	save_current_ip($current_ip);
	
	email_notify('someone@example.com', $previous_ip, $current_ip);
}

//----/main---------------------------------


//----utility-------------------------------

function get_current_ip()
{
	//see also trackip.sourceforge.net
	$candidates = array('http://ipecho.net/plain', 'http://icanhazip.com/');

	foreach($candidates as $url)
	{
		$result = file_get_contents($url);

		if($result)
		{
			return trim($result);
		}
	}
}

function load_previous_ip()
{
	return file_get_contents('./ip.dat');
}

function save_current_ip($ip)
{
	file_put_contents('./ip.dat', $ip);
}

//oooops, $recipient not actually used!
function email_notify($recipient, $old_ip, $new_ip)
{
	//----config-------------------------------------
	include('Mail.php');	//Pear
	
	$mail = @Mail::factory('smtp',
		array
		(
			'host' => 'ssl://mail.example.com',
			'port' => 465,
			'auth' => true,
			'username' => 'someone@example.com',
			'password' => 'abracadabra'
		)
	);
	//----/config------------------------------------
	
	$send_result = @$mail->send('you@example.com, someone@example.com', array('From' => 'donotreply@yourorganisation.co', 'Subject' => 'That person\'s IP address has changed'), "FYI That person's IP address has changed from {$old_ip} to {$new_ip}");
}

//----/utility-------------------------------
