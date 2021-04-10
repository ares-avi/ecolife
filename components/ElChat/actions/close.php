<?php

$chat = input('fid');
if (elChat::removeChatTab($chat)) {
    echo 1;
} else {
    echo 0;
}