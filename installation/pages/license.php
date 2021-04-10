<?php



echo '<div><div class="layout-installation"><h2>' . el_installation_print('el:check') . '</h2><div style="margin:0 auto; width:900px;"><div style="background: #f9f9f9; padding: 20px; border-radius: 3px; border: 2px dashed #eee;">';
//echo nl2br(file_get_contents(dirname(dirname(dirname(__FILE__))) . '/LICENSE.md'));
echo '</div><br />';
echo '<a href="' . el_installation_paths()->url . '?page=settings" class="button-blue primary">'.el_installation_print('el:install:next').'</a>';
echo '</div><br /><br /></div>';
