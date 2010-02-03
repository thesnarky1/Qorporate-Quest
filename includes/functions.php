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


    //Global variables
    $LEVEL_UP_RATIO = 1000; //Amount of experience needed per level (i.e. 1000, then 2000, then 3000)

?>
