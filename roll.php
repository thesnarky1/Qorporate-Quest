<?php

    include('includes/functions.php');

    if(is_logged_in()) {
        $user_id = get_logged_in_userid();
        $roll = roll($user_id);
        echo json_encode($roll);
    }



?>
