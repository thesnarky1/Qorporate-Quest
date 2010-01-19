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
            $query = "INSERT INTO users(user_name, user_pass, user_hash, user_email) ".
                     "VALUES('$user_name', MD5('$user_pass'), '$user_hash', '$user_email')";
            $insert_id = mysqli_insert($query);
            if($insert_id) {
                //successful
                login_user($user_name, $user_pass);
                if(is_logged_in()) {
                    //We're REALLY successful
                } else {
                    $error = "Unknown error, try again.";
                }
            } else {
                //Todo: add better logic here to see WHY it failed
                $error = "Error registering";
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
        echo "Flavor text of job vacency.\n";
        echo "</p>\n";
    
        echo "<div id='login_form'>\n";
        echo "<h3>Application</h3>\n";
        echo "<form name='register' method='POST' action='register.php' class='form'>\n";
        //Check for any issues with login
        if($error != "") {
            //Display our error nice and big
            echo "<span class='error'>$error</span><br />\n";
        }
        echo "<label class='fixed_width'>Username: </label>\n";
        echo "<input type='text' name='user_name' ";
        if($user_name) {
            echo "value='$user_name'";
        }
        echo "/>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Email: </label>\n";
        echo "<input type='text' name='user_email' ";
        if($user_email) {
            echo "value='$user_email'";
        }
        echo "/>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Password: </label>\n";
        echo "<input type='password' name='user_pass' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Pass again: </label>\n";
        echo "<input type='password' name='user_pass_again' />\n";
        echo "<br />\n";
        echo "<input type='hidden' name='submit' value='submit' />\n";
        echo "<input type='submit' value='Apply!' />\n";
        echo "</form>\n";
        echo "</div> <!-- end login_form div -->\n";
    }

    render_footer();

?>
