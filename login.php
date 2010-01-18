<?php

    include('includes/functions.php');

    $error = false;

    if(isset($_REQUEST['user_name']) && isset($_REQUEST['user_pass'])) {
        //make our input nice and safe
        $user_name = safetify_input($_REQUEST['user_name']);
        $user_pass = safetify_input($_REQUEST['user_pass']);

        //Check if this is a valid login
        if(login_user($user_name, $user_pass)) {
            //We're logged in, go home or where ever they came from
            if(isset($_REQUEST['next_page'])) {
                $next_page = safetify_input($_REQUEST['next_page']);
                header("Location: $next_page");
            } else {
                header("Location: index.php");
            }
        } else {
            //Display error
            $error = get_login_error();
        }
    }

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
    echo "<input type='hidden' name='next_page' value='$_SERVER[PHP_SELF]' />\n";
    echo "Remember login?<input type='checkbox' name='remember' value='true'/>\n";
    echo "<input type='submit' value='Login' />\n";
    echo "</form>\n";
    echo "</div> <!-- end login_form div -->\n";

    render_footer();

?>
