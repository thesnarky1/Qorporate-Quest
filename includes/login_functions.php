<?php

    /*
      Login/Registration Module for websites
      By Three Planets Software


      Include this file at a global level.

      Assumes a database table 'users' with the following fields:

      user_id         (unique ID)
      user_name       (unique name, used for login)
      user_email      (unique email, used for password resets)
      user_hash       (uniqie hash, used for authentication)
    */


    //Login error most recently generated, will be overwritten upon new error
    $current_login_error = false;

    //Domain for the cookies
    $my_domain = "qorporate_quest";

    //Function to fetch the current login error for display
    function get_login_error() {
        global $current_login_error;

        return $current_login_error;
        $current_login_error = false;
    }

    //Function to tell if someone is currently logged in or not
    function is_logged_in() {
        if(isset($_SESSION['user_name']) &&
           isset($_SESSION['user_id']) &&
           isset($_SESSION['user_hash']) &&
           $_SESSION['user_id'] != null &&
           $_SESSION['user_name'] != null &&
           $_SESSION['user_hash'] != null) {
            return true;
        } else {
            return false;
        }
    }

    //Function to handle logging in a user.
    function login_user($user_name, $user_pass, $remember=false) {
        $query = "SELECT user_id, user_hash, user_name FROM users ".
                 "WHERE user_name LIKE '$user_name' AND user_pass=MD5('$user_pass')";
        if($user_row = mysqli_get_one($query)) {
            //Valid login
            $user_name = $user_row['user_name'];
            $user_hash = $user_row['user_hash'];
            $user_id = $user_row['user_id'];
            $_SESSION['user_name'] = $user_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_hash'] = $user_hash;
            if($remember) {
                //Set cookies
            }
            return true;
        } else {
            set_login_error("Invalid login combination");
            return false;
        }
    }

    //Function logs out the user by killing off SESSION
    function logout_user() {
        $_SESSION['user_name'] = null;
        $_SESSION['user_id'] = null;
        $_SESSION['user_hash'] = null;
        //Destroy cookies
        session_destroy();
    }

    //Function takes user input and makes it a tad safer
    function safetify_input($input) {
        global $dbh;

        $to_return = html_entity_decode($input);
        $to_return = mysqli_real_escape_string($dbh, $to_return);

        return $to_return;
    }

    //Function to set the current login error, will overwrite old data
    function set_login_error($new_error) {
        global $current_login_error;

        $current_login_error = $new_error;
    }


?>
