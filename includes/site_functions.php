<?php

    /*
      Site functions file
      Includes any functions or variables needed to actually display the site
    */

    //Renders everything in the footer
    function render_footer() {
        echo "</div> <!-- end content div -->\n";
        echo "</div> <!-- end container div -->\n";
        echo "</body>\n";
        echo "</html>\n";
    }

    //Renders the meta header, aka everything up until the actual body of the page
    function render_header() {
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'\n";
        echo "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>\n";
        echo "<head>\n";
        echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />\n";
        echo "<link rel='stylesheet' href='./includes/stylesheet.css' type='text/css' media='screen' />\n";
        echo "<script type='text/javascript' src='./scripts/libs/jquery-1.4.min.js'></script>\n";
        echo "<script type='text/javascript' src='./scripts/common.js'></script>\n";
        echo "<title>Qorporate Quest - QQ moar, intern</title>\n";
        echo "</head>\n";

        // Farm out call to render the page header, just to keep the code neat
        render_page_header();
    }

    //Renders the nav bar within the header
    function render_header_nav_bar() {
        echo "<div id='header_nav_buttons'>\n";
        echo "<span class='nav_button'><a href='index.php'>Home</a></span>\n";
        //Toggle between login/logout
        if(is_logged_in()) {
            echo "<span class='nav_button'><a href='logout.php'>Logout</a></span>\n";
            echo "<span class='nav_button'><a href='play.php'>Play</a></span>\n";
        } else {
            echo "<span class='nav_button'><a href='login.php'>Login</a></span>\n";
            echo "<span class='nav_button'><a href='register.php'>Register</a></span>\n";
        }
        echo "<span class='nav_button'><a href='help.php'>Help</a></span>\n";
        echo "</div> <!-- end header_nav_buttons div -->\n";
    }

    //Renders the quick login form in the header
    function render_header_quick_login() {
        echo "<div id='header_quick_login'>\n";

        if(is_logged_in()) {

            //Show the player info small box
            $user_name = get_logged_in_username();
            $user_id = get_logged_in_userid();
            echo "<div id='header_character_picker'>\n";
            if(false) {
                //Show character picker dropdown menu
            } else {
                echo "<p><a href='play.php'>Create a character</a></p>\n";
            }
            echo "</div> <!-- end header_character_picker div -->\n";
            echo "<div id='header_username'>\n";
            echo "<p>Welcome <a href='users.php?user_id=$user_id'>$user_name</a>!</p>\n";
            echo "</div> <!-- end header_username div -->\n";

        } else {
        
            //Show the login form small box
            echo "<form name='header_login_form' method='POST' action='./login.php' ".
                 "style='padding: .25em; text-align: center;'>\n";
            echo "<label class='fixed_width'>Username: </label>\n";
            echo "<input type='text' name='user_name'  style='margin-top: .25em;'/>\n";
            echo "<br />\n";
            echo "<label class='fixed_width'>Password: </label>\n";
            echo "<input type='password' name='user_pass' style='margin-top: .25em;' />\n";
            echo "<br />\n";
            echo "<input type='hidden' name='next_page' value='$_SERVER[PHP_SELF]' />\n";
            echo "Remember login?<input type='checkbox' name='remember' value='true'/>\n";
            echo "<input type='submit' value='Login' style='margin-top: .25em'/>\n";
            echo "</form>\n";

        }
        echo "</div> <!-- end header_quick_login div -->\n";
    }

    //Renders the page header, aka the header within the body
    function render_page_header() {
        echo "<body>\n";
        echo "<div id='container'>\n";
        echo "<div id='header'>\n";

        //Logo on the left side
        echo "<div id='header_logo'>\n";
        echo "<!-- logo by Master_son - http://commons.wikimedia.org/wiki/File:WIS_County_QQ.svg -->\n";
        echo "<img src='images/site/qq_logo_export.png' />\n";
        echo "</div> <!-- End header_logo div -->\n";

        //Quick login form on the right side
        render_header_quick_login();

        //Nav bar in the middle
        render_header_nav_bar();

        echo "</div> <!-- end header div -->\n";
        echo "<div id='content'>\n";
    }

?>
