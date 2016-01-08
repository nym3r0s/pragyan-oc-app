<?php
namespace App\Helpers;

use ldap;

class LDAPAuth
{
	public static function auth($user_roll, $user_pass)
	{
		$ldapconn = ldap_connect("10.0.0.38") 
					or die("Could not connect to LDAP Server");

		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
		ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

		$ldapbind = @ldap_bind($ldapconn,$user_roll,$user_pass);

		if ($ldapbind)
		{
			return true;       
		} 
		return false;
	}
}