<?php

    include('includes/functions.php');
    
    $error = false;
    $user_name = false;
    $user_email = false;

    if(isset($_REQUEST['submit'])) {

        //make our input nice and safe as well as make sure its filled in
        if(!isset($_REQUEST['user_pass_again']) || $_REQUEST['user_pass_again'] == null) {
            $error = "Enter password twice";
        } else {
            $user_pass_again = safetify_input($_REQUEST['user_pass_again']);
        }

        if(!isset($_REQUEST['user_pass']) || $_REQUEST['user_pass'] == null) {
            $error = "Enter a password";
        } else {
            $user_pass = safetify_input($_REQUEST['user_pass']);
        }

        if($user_pass_again != $user_pass) {
            $error = "Passwords must match";
        }

        if(!isset($_REQUEST['user_email']) || $_REQUEST['user_email'] == null) {
            $error = "Enter an email";
        } else {
            $user_email = safetify_input($_REQUEST['user_email']);
        }

        if(!isset($_REQUEST['user_name']) || $_REQUEST['user_name'] == null) {
            $error = "Enter a username";
        } else {
            $user_name = safetify_input($_REQUEST['user_name']);
        }

        $user_hash = md5(uniqid('', TRUE));

        //Check if this is a valid login
        if($error == false) {
            //register them
            $query = "INSERT INTO users(user_name, user_pass, user_hash, user_email, user_join_date) ".
                     "VALUES(?, MD5(?), ?, ?, NOW())";
            $result = $conn->Execute($query, array($user_name, $user_pass, $user_hash, $user_email));
            $insert_id = $conn->Insert_ID();
            if($insert_id) {
                //successful
                login_user($user_name, $user_pass);
                if(is_logged_in()) {
                    //We're REALLY successful, send to create a character
                    header("Location: play.php?create_char");
                } else {
                    $error = "Unknown error logging in.";
                }
            } else { //Registration failed, lets test why

                //Check if email is already registered
                $query = "SELECT user_email FROM users WHERE user_email LIKE ? LIMIT 1";
                $result = $conn->Execute($query, array($user_email));
                if($result && $result->RowCount() == 1) {
                    $error = "Email already registered.";
                }

                //Check if user_name is already registered
                $query = "SELECT user_name FROM users WHERE user_name LIKE ? LIMIT 1";
                $result = $conn->Execute($query, array($user_name));
                if($result && $result->RowCount() == 1) {
                    $error = "Username already registered.";
                }

                if(!$error || $error == "") {
                    $error = "Unknown error registering";
                }
            }
        }
    }

    render_header();

    if(is_logged_in()) {
        if(isset($_REQUEST['submit'])) {
            //Recent joining, let's greet them.
            echo "<p>Welcome aboard, $user_name! Now get to work!</p>\n";
        } else {
            //Already employed, let's yell
            echo "<p class='error'>YOU'RE ALREADY AN EMPLOYEE! GET BACK TO WORK!</p>\n";
        }
    } else {
        echo "<h1>Join &lt;Company Name&gt; Today!</h1>\n";
        echo "<p>\n";
        echo "So, you want to join the &lt;Company Name&gt; family, do you? Well, like any good bureaucracy before you can submit an application for a job you'll need to be entered into our overall database. All we need is a name and an email to get started, and of course a password to protect your information.";
        echo "</p>\n";
    
        echo "<div id='login_form'>\n";
        echo "<h3>Application</h3>\n";
        echo "<form name='register' id='register_form' method='POST' action='register.php' class='form'>\n";
        //Check for any issues with login
        echo "<span id='register_error' class='error'>\n";
        if($error != "") {
            //Display our error nice and big
            echo $error;
        }
        echo "</span><br />\n";
        echo "<label class='fixed_width'>Username: </label>\n";
        echo "<input type='text' id='register_user_name' name='user_name' ";
        if($user_name) {
            echo "value='$user_name'";
        }
        echo "/>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Email: </label>\n";
        echo "<input type='text' id='register_user_email' name='user_email' ";
        if($user_email) {
            echo "value='$user_email'";
        }
        echo "/>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Password: </label>\n";
        echo "<input type='password' id='register_user_pass' name='user_pass' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Pass again: </label>\n";
        echo "<input type='password' id='register_user_pass2' name='user_pass_again' />\n";
        echo "<br />\n";
        echo "<input type='hidden' name='submit' value='submit' />\n";
        echo "<input type='submit' value='Apply!' />\n";
        echo "</form>\n";
        echo "</div> <!-- end login_form div -->\n";
    }

    render_footer();

?>
