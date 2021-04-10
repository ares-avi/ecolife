<?php
/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).el
 * @author    el Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 $subject_guid = input('subject_guid'); //with who, the loggedin user typing
 $type		   = input('status');
 if($type == 'yes' || $type == 'no'){
	 $MessageTyping = new MessageTyping;
	 $MessageTyping->setStatus($subject_guid, el_loggedin_user()->guid, $type);
	 echo 1;
	 exit;
 }
 echo 0;
 exit;