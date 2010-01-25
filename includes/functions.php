<?php

    session_start();
    ob_start();

    include('adodb5/adodb.inc.php');
    include('mysql_config.php');
    include('mysqli_functions.php');
    include('login_functions.php');
    include('site_functions.php');
    include('game_functions.php');
    include('character_functions.php');
    include('quest_creation_functions.php');

?>
