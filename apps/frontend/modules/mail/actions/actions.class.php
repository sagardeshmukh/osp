<?php

/**
 * mail actions.
 *
 * @package    TutorBrite
 * @subpackage mail
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class mailActions extends sfActions
{

  private function setMailConfig()
  {
    $mail = new sfMail();
    //$mail = new sfEmail();
    $mail->initialize();
    $mail->setCharset('utf-8');
	$mail->setContentType('text/html');

    /*
    $mail->setMailer($type = 'SMTP');
    $mail->setHost     = sfConfig::get("app_mail_host");
    $mail->setSMTPauth   = sfConfig::get("app_mail_smtpauth");
    $mail->setUsername   = sfConfig::get("app_mail_username");
    $mail->setPassword   = sfConfig::get("app_mail_password");
    */

    $mail->addReplyTo('info@yozoa.mn');
    $mail->addEmbeddedImage(sfConfig::get('sf_web_dir').'/images/bg.gif', 'CID1', 'yozoa', 'base64', 'image/gif');
    $mail->addEmbeddedImage(sfConfig::get('sf_web_dir').'/images/yozoa_logo_header.png', 'CID2', 'yozoa Logo', 'base64', 'image/png');

    return $mail;
  }
}