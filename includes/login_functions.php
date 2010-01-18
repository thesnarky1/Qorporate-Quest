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

    function login_user($user_name, $password) {
        
    }

    function logout_user() {
    }

?>
