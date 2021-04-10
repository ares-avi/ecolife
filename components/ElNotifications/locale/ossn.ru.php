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

$ru = array(
	'elnotifications' => 'Уведомления',
    'el:notifications:comments:post' => "%s оставил комментарий к записи.",
    'el:notifications:like:post' => "%s полюбил вашу запись.",
    'el:notifications:like:annotation' => "%s полюбил ваш комментарий.",
    'el:notifications:like:entity:file:el:aphoto' => "%s полюбил ваше фото.",
    'el:notifications:comments:entity:file:el:aphoto' => '%s оставил комментарий к вашей фотографии.',
    'el:notifications:wall:friends:tag' => '%s отметил вас в записи.',
    'el:notification:are:friends' => 'Вы теперь друзья!',
    'el:notifications:comments:post:group:wall' => "%s оставил комментарий в записи группы.",
    'el:notifications:like:entity:file:profile:photo' => "%s полюбил вашу фотографию профиля.",
    'el:notifications:comments:entity:file:profile:photo' => "%s оставил комментарий к вашей фотографии профиля.",
    'el:notifications:like:entity:file:profile:cover' => "%s полюбил вашу обложку профиля.",
    'el:notifications:comments:entity:file:profile:cover' => "%s оставил комментарий к вашей обложке профиля.",

    'el:notifications:like:post:group:wall' => '%s полюбил вашу запись.',
	
    'el:notification:delete:friend' => 'Запрос в друзей удалён!',
    'notifications' => 'Уведомления',
    'see:all' => 'Смотреть все',
    'friend:requests' => 'Запросы в друзья',
    'el:notifications:friendrequest:confirmbutton' => 'Подтвердить',
    'el:notifications:friendrequest:denybutton' => 'Хз кто это',
	
    'el:notification:mark:read:success' => 'Успешно отмечено прочитаным',
    'el:notification:mark:read:error' => 'Не получилось отметить как прочитаные',
    
    'el:notifications:mark:as:read' => 'Отметить всё как прочитаные',
	'el:notifications:admin:settings:close_anywhere:title' => 'Закройте окна уведомлений, щелкнув в любом месте',
	'el:notifications:admin:settings:close_anywhere:note' => '<i class="fa fa-info-circle"></i> закрывает любое окно уведомлений, нажимая в любом месте на странице<br><br>',
);
el_register_languages('ru', $ru); 
