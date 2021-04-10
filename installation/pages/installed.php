<?php


echo '<div><div class="layout-installation">';

echo '<div class="el-installation-message el-installation-success">' . el_installation_print('el:installed:message') . '</div><br />';
echo '<a href="' . el_installation_paths()->url . '?action=finish" class="button-blue primary">' . el_installation_print('el:install:finish') . '</a>';
echo '</div>';
