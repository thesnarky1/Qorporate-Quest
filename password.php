<?php

    include('includes/functions.php');

    $change_email_error = false;
    $change_pass_error = false;

    if(isset($_REQUEST['reset'])) {
        //deal with password reset
    } else if(isset($_REQUEST['change_email'])) {
        //change their email
        //stupidly assuming everything came through correctly
        $old_pass = $_REQUEST['curr_pass'];
        $new_email = $_REQUEST['new_email'];
        $new_email2 = $_REQUEST['new_email2'];

        if(trim($old_pass) != "" && trim($new_email) != "" &&
           trim($new_email2) != "" && $new_email == $new_email2) {
            $user_id = get_logged_in_userid();
            $query = "SELECT user_id FROM users WHERE user_id=? AND user_pass=MD5(?)";
            $real_user = $conn->Execute($query, array($user_id, $old_pass));
            if($real_user && $real_user->RowCount() == 1) {
                //valid user, update
                $query = "UPDATE users SET user_email=? WHERE user_id=?";
                $conn->Execute($query, array($new_email, $user_id));
                $change_email_error = "Email changed successfully to $new_email";
            } else {
                $change_email_error = "Invalid current password given.";
            }
        } else {
            $change_email_error = "Please ensure you fill in all required fields with non whitespace characters";
        }
    } else if(isset($_REQUEST['change_password'])) {
        //change their password
        //stupidly assuming everything came through correctly
        $old_pass = $_REQUEST['curr_pass'];
        $new_pass = $_REQUEST['new_pass'];
        $new_pass2 = $_REQUEST['new_pass2'];

        if(trim($old_pass) != "" && trim($new_pass) != "" &&
           trim($new_pass2) != "" && $new_pass == $new_pass2) {
            $user_id = get_logged_in_userid();
            $query = "SELECT user_id FROM users WHERE user_id=? AND user_pass=MD5(?)";
            $real_user = $conn->Execute($query, array($user_id, $old_pass));
            if($real_user && $real_user->RowCount() == 1) {
                //valid user, update
                $query = "UPDATE users SET user_pass=MD5(?) WHERE user_id=?";
                $conn->Execute($query, array($new_pass, $user_id));
                $change_pass_error = "Password changed successfully to ******";
            } else {
                $change_pass_error = "Invalid current password given.";
            }
        } else {
            $change_pass_error = "Please ensure you fill in all required fields with non whitespace characters";
        }
    }

    render_header();

    if(is_logged_in()) {
        //Must want to change password or email

        //Change password form
        echo "<div id='char_creation'>\n";
        echo "<h3>Change Password</h3>\n";
        echo "<div id='change_pass_error' style='text-align: center; color: red;'>";
        if($change_pass_error) {
            echo $change_pass_error;
        }
        echo "</div> <!-- end change_pass_error div -->\n";
        echo "<form action='password.php'  id='change_pass_form' method='POST'>\n";
        echo "<label class='fixed_width'>Current Password: </label>";
        echo "<input type='password' id='change_pass_pass' name='curr_pass' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Desired Password: </label>";
        echo "<input type='password' id='change_pass_new' name='new_pass' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Repeat Password: </label>";
        echo "<input type='password' id='change_pass_new2' name='new_pass2' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'></label>";
        echo "<input type='submit' id='change_pass_submit' name='change_password' value='Change password' />\n";
        echo "</form>\n";
        echo "</div> <!-- end char_creation div -->\n";

        //Change email form
        echo "<div id='char_creation'>\n";
        echo "<h3>Change Email</h3>\n";
        echo "<div id='change_email_error' style='text-align: center; color: red;'>";
        if($change_email_error) {
            echo $change_email_error;
        }
        echo "</div> <!-- end change_email_error div -->\n";
        echo "<form action='password.php' id='change_email_form' method='POST'>\n";
        echo "<label class='fixed_width'>Current Password: </label>";
        echo "<input type='password' id='change_email_pass' name='curr_pass' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>New Email: </label>";
        echo "<input type='text' id='change_email_new' name='new_email' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Repeat Email: </label>";
        echo "<input type='text' id='change_email_new2' name='new_email2' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'></label>";
        echo "<input type='submit' id='change_email_submit' name='change_email' value='Change email' />\n";
        echo "</form>\n";

        echo "</div> <!-- end char_creation div -->\n";
    } else {
        //Must be a password reset request
        echo "<div id='char_creation'>\n";
        echo "<h3>Reset Password</h3>\n";
        echo "<div id='reset_pass_error' style='text-align: center; color: red;'>";
        if($reset_pass_error) {
            echo $reset_pass_error;
        }
        echo "</div> <!-- end reset_pass_error div -->\n";
        echo "<form action='password.php'  id='reset_pass_form' method='POST'>\n";
        echo "<label class='fixed_width'>User Email: </label>";
        echo "<input type='text' id='reset_pass_email' name='curr_email' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'></label>";
        echo "<input type='submit' id='reset_pass_submit' name='reset_password' value='Reset password' />\n";
        echo "</form>\n";
        echo "</div> <!-- end char_creation div -->\n";
    }

    render_footer();

?>
