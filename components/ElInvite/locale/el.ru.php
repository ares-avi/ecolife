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
$ru = array(
	'com:el:invite' => 'Приглашения',			
	'com:el:invite:friends' => 'Пригласить друзей',
	'com:el:invite:friends:note' => 'Чтобы пригласить друзей, введите их электронную почту и короткое сообщение. Они получат приглашения на почту.',
	'com:el:invite:emails:note' => 'Электронные ящики разделённые запятой',
	'com:el:invite:emails:placeholder' => 'smith@example.com, john@example.com',
	'com:el:invite:message' => 'Сообщение',
		
    	'com:el:invite:mail:subject' => 'Приглашение присоединиться к %s',	
    	'com:el:invite:mail:message' => ' %s пригласил вас присоединиться к %s. Он написало следующее сообщение:

%s

Нажми на ссылку:

%s

Ссылка на профиль: %s
',	
	'com:el:invite:mail:message:default' => 'Привет,

Я хочу чтобы ты заценил %s.

Ссылка на профиль : %s

Чмоки.
%s',
	'com:el:invite:sent' => 'Ваши друзья были приглашены. Преглашения отправил: %s.',
	'com:el:invite:wrong:emails' => 'Следующие электронные адреса неправильные: %s.',
	'com:el:invite:sent:failed' => 'Не получилось пригласить следующих товарищей: %s.',
	'com:el:invite:already:members' => 'Следующее товарищи уже здесь: %s',
	'com:el:invite:empty:emails' => 'Пожалуйста, добавьте хотя бы один электронный ящик',
);
el_register_languages('ru', $ru); 
