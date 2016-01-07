<?php
namespace App\Helpers;
use mail;

// Constants
define("CMS_TITLE","Festember 15");
define("CMS_EMAIL","no-reply@festember.com");


class MailSender
{
    var $vars;
    

    public static function getVerificationKey($userEmail, $userPassword, $userRegistrationTime)
    {
		return md5(substr($userEmail, 0, 6).substr(md5($userPassword), -17).$userRegistrationTime.$userPassword);
    }

    function assign_vars($vars)
    {
	$this->vars = (empty($this->vars)) ? $vars : $this->vars + $vars;
    }

    public function sendmail($to,$mailtype,$key,$from)
    {
	
	if(empty($from)) 
	    $from="from: ".CMS_TITLE." <".CMS_EMAIL.">";
	
	//init mail template file path
	// $mail_filepath= "/var/www/html/15/cms/languages/en/email/$mailtype.txt"; 
	$mail_filepath= base_path()."/resources/emailtemplates/$mailtype.html";
	// echo($mail_filepath);
	$drop_header = '';
	if (substr($mail_filepath,-4)=="html") $from .= "\r\n".'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	if(!file_exists($mail_filepath))
	{
	    //check file
	    // displayerror(safe_html("NO FILE called $mail_filepath FOUND !"));
	    // echo("File doesn't exist");
	    return false;
	} 
	if(($data = @file_get_contents($mail_filepath)) === false)
	{
	    //read contents
	    // displayerror("$mail_filepath FILE READ ERROR !");
	    // echo("File doesn't exist Cant read");
	    return false;
	} 

	//escape quotes
	$body = str_replace ("'", "\'", $data); 
	//replace the vars in file content with those defined
	$body = preg_replace('#\{([a-z0-9\-_]*?)\}#is', "' . ((isset(\$this->vars['\\1'])) ? \$this->vars['\\1'] : '') . '", $body);
	//Make the content parseable
	eval("\$body = '$body';");

	//Extract the SUBJECT from mail content
	$match=array();
	
	if (preg_match('#^(Subject:(.*?))$#m', $body, $match))
	{
	    //Find SUBJECT
	    $subject = (trim($match[2]) != '') ? trim($match[2]) :  $subject ;
	    $drop_header .= '[\r\n]*?' . preg_quote($match[1], '#');
	}
	if ($drop_header)
	{
	    //Remove SUBJECT from BODY of mail
	    $body = trim(preg_replace('#' . $drop_header . '#s', '', $body));
	}

	//Debug info
	//echo displayinfo($from.' <br> '.$to.' <br> '.$subject.' <br> '.$body);
	// echo("Sending Mail");
	// var_dump($this->vars);
	// var_dump($to);
	// var_dump($subject);
	// var_dump($body);
	// var_dump($from);
	// die();
	//Send mail 
	return mail($to, $subject, $body, $from);
    }

}
