<?php

if (!defined('FORUM'))
	exit;

function is_valid_checksum($invite)
	{

	$forbidden_chars = array(";","$","*","!","[","]","@","#","%","^","&");
	$minimal_lenght = 41;
	
	$errors_sum =0;
	//check pubkey lenght
	if (strlen($invite)<$minimal_lenght)
		$errors_sum=$errors_sum+1;	
	//check if forbidden chars occure
	foreach ($forbidden_chars as &$forbidden_character)
		{
		if (strpos($invite, $forbidden_character))
			$errors_sum=$errors_sum+1;	
		}
	//check checksum value
	$proper_checksum = get_checksum($invite);
	$recived_checksum = substr($invite,-1);
	if ($proper_checksum!=$recived_checksum)
		{
		$errors_sum++;	
		}
	//result of checking
	if ($errors_sum ==0)
		return true;
	else
		return false;

	}

function get_checksum($invite)
	{
	$invite_lenght = strlen($invite);
	$invite = substr($invite,0,-1);
	$checksum = dechex(abs(crc32($invite.'3')%16));
	return $checksum;
	}

function get_username($invite)
	{
	return substr($invite,40,-1);	
	}

function get_salt($username)
	{
	global $forum_db, $forum_user;
	$query = array(
		'SELECT'	=> '*',
		'FROM'		=> 'users',
		'WHERE'	=> 'username=\''.$username.'\''
	);		
	
	$result = $forum_db->query_build($query) or error(__FILE__, __LINE__);
	$row = $forum_db->fetch_assoc($result);
	return $row['password'];
	}
	
function get_proper_invitation($username, $requested_username)
	{
	$salt = get_salt($username);
	$time=date('m');
	$hashedTxt = sha1($salt.$username.$requested_username);
	$invite = $hashedTxt.$username;
	$checksum = get_checksum($invite);
	$invite = $invite.$checksum;
	return $invite;
	}

?>
