<?php

namespace Plugins\mail;

use \Typemill\Plugin;

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

class Mail extends Plugin
{
    public static function getSubscribedEvents()
    {
		return [
			'onTwigLoaded' 	=> ['onTwigLoaded', 0]
		];
    }

	# add the mail configuration
	public function onTwigLoaded()
	{
		$mail 		= new PHPMailer;
		$config 	= $this->getPluginSettings();
		$twig		= $this->getTwig();
		$container 	= $this->container;

		$this->container->set('mail', function($container) use ($mail, $config, $twig)
		{
			$mail->From			= $config['from_address'];
			$mail->FromName		= $config['from_name'];
			$mail->Sender		= $config['from_address'];

			if(isset($config['CharSet'])) 
			{ 
				$mail->CharSet = $config['CharSet']; 
			}

			if(isset($config['SMTP']) && $config['SMTP'])
			{
				date_default_timezone_set('Etc/UTC');
				
				$mail->isSMTP();
				$mail->Host 		= $config['host'];
				$mail->Port 		= $config['port'];
				$mail->SMTPDebug 	= 0;
				
				# optional
				if(isset($config['SMTPSecure'])){ $mail->SMTPSecure = $config['SMTPSecure']; }
				if(isset($config['SMTPAuth'])){ $mail->SMTPAuth = $config['SMTPAuth']; }
				if(isset($config['username'])){ $mail->Username = $config['username']; }
				if(isset($config['password'])){ $mail->Password = $config['password']; }
			}
			else
			{
				$mail->isMail();
			}
			
			return new MailHandler($mail, $twig);
		});
	}
}