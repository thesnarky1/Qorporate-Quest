<?php

    include('includes/functions.php');

    $was_logged_in = is_logged_in();

    if($was_logged_in) {
        logout_user();
    } 

    render_header();

    if($was_logged_in) {
        echo "<p>You are now logged out</p>\n";
    } else {
        echo "<p>You weren't logged in anyhow!</p>\n";
    }

    render_footer();

?>
