<?php

    /*
      Site functions file
      Includes any functions or variables needed to actually display the site
    */

    //Renders the meta header, aka everything up until the actual body of the page
    function render_header() {
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'\n";
        echo "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>\n";
        echo "<head>\n";
        echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />";
        echo "<link rel='stylesheet' href='./includes/stylesheet.css' type='text/css' media='screen' />\n";
        echo "<title>Qorporate Quest - QQ moar, intern</title>\n";
        echo "</head>\n";

        // Farm out call to render the page header, just to keep the code neat
        render_page_header();
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
    }

    //Renders the quick login form in the header
    function render_header_quick_login() {
        echo "<div id='header_quick_login'>\n";
        if(is_logged_in()) {
            /*
            $user_name = $_SESSION['user_name'];
            $user_id = $_SESSION['user_id'];
            echo "<p class='player_name'>$user_name <span class='small_text'><a href='./logout.php'>(logout)</a></span></p>";
            echo "<span class='player_info_button'><a href='./account.php'>Account</a></span>\n";
            echo "<span class='player_info_button'><a href='./profile.php?id=$user_id'>Profile</a></span>\n";
            echo "<span class='player_info_button'><a href='./games.php'>Games</a></span>\n";
            */
        } else {
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

    //Renders the nav bar within the header
    function render_header_nav_bar() {
        echo "<div id='header_nav_buttons'>\n";
        echo "<span class='nav_button'><a href='index.php'>Home</a></span>\n";
        echo "<span class='nav_button'><a href='login.php'>Login</a></span>\n";
        echo "<span class='nav_button'><a href='help.php'>Help</a></span>\n";
        echo "</div> <!-- end header_nav_buttons div -->\n";
    }

    //Renders everything in the footer
    function render_footer() {
        echo "</div> <!-- end container div -->\n";
        echo "</body>\n";
        echo "</html>\n";
    }
    
?>
