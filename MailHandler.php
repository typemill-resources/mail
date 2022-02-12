<?php

namespace Plugins\mail;

use Slim\Views\Twig;

class MailHandler
{
	protected $mail;
	protected $twig;
	
	public function __construct($mail, Twig $twig)
	{ 
		$this->mail = $mail;
		$this->twig = $twig;
	}
	
	public function addAdress($address, $name = '')
	{
		$this->mail->addAddress($address, $name);
	}
	
	public function addCC($adress, $name = '')
	{
		$this->mail->addCC($address, $name);
	}

    public function addBCC($address, $name = '')
    {
		$this->mail->addBCC($address, $name);
    }
	
    public function addReplyTo($address, $name = '')
    {
		$this->mail->addReplyTo($address, $name);
    }
	
    public function setFrom($address, $name = '')
    {
		$this->mail->setFrom($address, $name, $auto = true);
	}

    public function addCustomHeader($name, $value = null)
    {
		$this->mail->addCustomHeader($name, $value);
	}
	
    public function addAttachment($path, $name = '')
    {
		$this->mail->addAttachment($path, $name);
	}
	
    public function msgHTML($message, $basedir = '', $advanced = false)
	{
		$this->mail->msgHTML($message, $basedir, $advanced = false);
	}		

	public function isHTML()
	{
		$this->mail->isHTML(true);
	}
	
	public function setSubject($subject)
	{
		$this->mail->Subject = $subject;		
	}
	
	public function setBody($body)
	{
		$this->mail->Body    = $body;	// html-body		
	}
	
	public function setAltBody($altbody)
	{
		$this->mail->AltBody = $altbody;
	}

    public function ClearAttachments()
    {
        $this->mail->clearAttachments();
    }

    public function ClearCustomHeaders()
    {
        $this->mail->clearCustomHeaders();
    }

	public function ClearAllRecipients()
	{
		$this->mail->ClearAllRecipients();
	}

	public function ClearMail()
	{
		$this->mail->ClearAllRecipients();
        $this->mail->clearAttachments();
        $this->mail->clearCustomHeaders();
	}


    public function send()
    {	
		# create a mail-error-logger that stores error messages, maybe even displays in admin
		# catch the smtp-errors this way: https://stackoverflow.com/questions/39565769/get-full-error-message-from-phpmailer-exception/39571423
		try{
			$this->mail->send();
			return true;
		}
		catch (phpmailerException $e) 
		{
			# log errors here
			return $e->errorMessage(); //Pretty error messages from PHPMailer
		}
		catch (Exception $e)
		{
			# log errors here
			return $e->getMessage(); //Boring error messages from anything else!
		}
    }
}