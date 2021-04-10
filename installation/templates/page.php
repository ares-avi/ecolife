<?php

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo $params['title']; ?></title>
    <link rel="stylesheet" href="./styles/el.install.css"/>
</head>

<body>
<div class="el-header">
    <div class="inner">
        <div class="logo-installation"></div>
        <img class="settings" src="./styles/settings.jpg" />
    </div>
</div>
<div id="el-page-menubar">
	<div class="inner">
	    <li><a href="#"><?php echo el_installation_print("el:installation"); ?></a></li>
   		<li><a href="#"> > </a></li>
  	 	<li><a href="#"><?php echo $params['title']; ?></a></li>
    </div>
</div>
<div style="margin:0 auto; width:1000px;">
    <div class="el-default">
        <div class="el-top">
            <table border="0">
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <div class="buddyexpresss-search-box inline" style="margin-top: -50px;"></div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
    <div>

        <div class="el-installation-message-marg">
            <?php
            echo el_installation_messages();?>
        </div>

        <div>
            <?php echo $params['contents']; ?>
        </div>

        <div class="el-installation-footer">
            <?php echo 'POWERED <a href="http://www.opensource-socialnetwork.org">OPEN SOURCE SOCIAL NETWORK</a>'; ?>
        </div>

</body>
</html>
