<?php
namespace App\Helpers;

use imap;

class IMAPAuth
{
	public static function auth($user_roll, $user_pass)
	{
		$username = $user_roll;
		$password = $user_pass;

	    $imap_server_address='webmail.nitt.edu';
	    $imap_port=143;
	    
	    $imap_stream = fsockopen($imap_server_address,$imap_port);
	    if ( !$imap_stream )
	    {
	        return false;
	    }
	    
	    $server_info = fgets ($imap_stream, 1024);
	    $query = 'b221 ' .  'LOGIN "' . $username .  '" "'  .$password . "\"\r\n";
	    $read = fputs ($imap_stream, $query);
	    $response = fgets ($imap_stream, 1024);
	    
	    $query = 'b222 ' . 'LOGOUT';
	    $read = fputs ($imap_stream, $query);
	    fclose($imap_stream);
	    strtok($response, " ");
	    $result = strtok(" ");
	    
	    if($result == "OK")
	        return true;
	    else
	        return false;

	}
}