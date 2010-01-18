<?php

    include('includes/functions.php');

    render_header();

    echo "<div id='login_form'>\n";
    echo "<h3>Login</h3>\n";
    echo "<form name='login' method='POST' action='login.php' class='form'>\n";
    echo "<label class='fixed_width'>Username: </label>\n";
    echo "<input type='text' name='user_name' />\n";
    echo "<br />\n";
    echo "<label class='fixed_width'>Password: </label>\n";
    echo "<input type='password' name='user_pass' />\n";
    echo "<br />\n";
    echo "<input type='submit' value='Login' />\n";
    echo "</form>\n";
    echo "</div> <!-- end login_form div -->\n";

    render_footer();

?>
