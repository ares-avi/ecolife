<?php
/**
 * Open Source Social Network
 *
 * @package   Open Source Social Network
 * @author    Open Social Website Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (el LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$en = array(
	'com:el:invite' => 'Invite',			
	'com:el:invite:friends' => 'Invite Friends',
	'com:el:invite:friends:note' => 'To invite friends to join you on this network, enter their email addresses and a brief message. They will receive an email containing your invitation.',
	'com:el:invite:emails:note' => 'Email addresses (separated by a comma)',
	'com:el:invite:emails:placeholder' => 'smith@example.com, john@example.com',
	'com:el:invite:message' => 'Message',
		
    	'com:el:invite:mail:subject' => 'Invitation to join %s',	
    	'com:el:invite:mail:message' => 'You have been invited to join %s by %s. They included the following message:

%s

To join, click the following link:

%s

Profile link: %s
',	
	'com:el:invite:mail:message:default' => 'Hi,

I wanted to invite you to join my network here on %s.

Profile link : %s

Best regards.
%s',
	'com:el:invite:sent' => 'Your friends were invited. Invites sent: %s.',
	'com:el:invite:wrong:emails' => 'The following addresses are not valid: %s.',
	'com:el:invite:sent:failed' => 'Cannot invite the following addresses: %s.',
	'com:el:invite:already:members' => 'The following addresses are already members: %s',
	'com:el:invite:empty:emails' => 'Please add at least one email address',
);
el_register_languages('en', $en); 
