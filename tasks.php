<?php

    include('includes/functions.php');

    if(is_logged_in()) {

        if(isset($_REQUEST['char_id'])) {
            //Get vars
            $char_id = $_REQUEST['char_id'];
            $user_hash = $_SESSION['user_hash'];
            $user_id = $_SESSION['user_id'];
    
            //check for valid char
            if(user_owns_character($user_id, $char_id, $user_hash)) {
                $tasks = get_character_tasks($char_id, 10);
                echo json_encode($tasks);
            }
        }

    }


?>
