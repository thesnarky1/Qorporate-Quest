<?php

    session_start();
    ob_start();

    include('mysql_config.php');
    include('mysqli_functions.php');
    include('login_functions.php');
    include('site_functions.php');
    include('game_functions.php');

    //Function takes a user_id and returns an array of all the characters that belong to them
    function get_characters($user_id) {
        $query = "SELECT * FROM characters WHERE user_id='$user_id'";
        $characters = mysqli_get_many($query);
        return $characters;
    }

?>
