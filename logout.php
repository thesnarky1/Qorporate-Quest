<?php

    include('includes/functions.php');

    $was_logged_in = is_logged_in();

    if($was_logged_in) {
        logout_user();
    } 

    header("Location: index.php");

?>
