<?php

require_once(el_route()->classes . 'mail/PHPMailerAutoload.php');
class ElMail extends PHPMailer {
		/**
		 * Send email to user.
		 *
		 * @param string $email User email address
		 * @param string $subject Email subject
		 * @param string $body Email body
		 *
		 * @return boolean
		 */
		public function NotifiyUser($email, $subject, $body) {
				//Emails should be validated before sending emails #1080
				if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
					error_log('Can not send email to empty email address', 0);
				}
				//params contain initial params, while return may contain changed values
				$mail = el_call_hook('email', 'config', $this, $this); 
				
				$mail->setFrom(el_site_settings('notification_email'), el_site_settings('site_name'));
				$mail->addAddress($email);
				
				$mail->Subject = $subject;
				$mail->Body    = $body;
				$mail->CharSet = "UTF-8";
				$mail->XMailer = " "; //disable the exposure of x-mailer
				try {	
						$send = el_call_hook('email', 'send:policy', true, $mail);
						if($send) {
								if($mail->send()){
									return true;
								}
						} else {
							//allow system to intract with mail
							return el_call_hook('email', 'send', false, $mail);
						}
				}
				catch(phpmailerException $e) {
						error_log("Cannot send email " . $e->errorMessage(), 0);
				}
				return false;
		}
		
} //class
