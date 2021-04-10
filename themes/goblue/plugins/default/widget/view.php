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
 $class = 'el-widget';
 if(isset($params['class'])){ 
 	$class = 'el-widget '.$params['class'];
 }
 unset($params['class']);
 if(empty($params['title'])){
	 return;
 } 
$defaults = array(
	'class' => $class,
);

$title 	  = $params['title'];
$contents = $params['contents'];

$params   = array_merge($defaults, $params);
unset($params['title']);
unset($params['contents']);
$attributes = el_args($params); 
?>
<div <?php echo $attributes;?>>
	<div class="widget-heading"><?php echo $title;?></div>
	<div class="widget-contents">
		<?php echo $contents;?>
	</div>
</div>
