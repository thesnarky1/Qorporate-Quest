<?php

    include('includes/functions.php');

    render_header();


    //
    // Sidebar
    //
    echo "<div id='sidebar'>\n";
    echo "<div id='sidebar_stats'>\n";
    echo "<h3>Random Fun</h3>\n";
    echo "<ul>\n";
    echo "<li>1 * 1 = 1</li>\n";
    echo "<li>2 * 2 = 4</li>\n";
    echo "<li>3 * 3 = 9</li>\n";
    echo "<li>4 * 4 = 16</li>\n";
    echo "<li>0 * 0 = 42</li>\n";
    echo "</ul>\n";
    echo "</div> <!-- end sidebar_stats div -->\n";
    echo "</div> <!-- end sidebar div -->\n";
    //
    // End sidebar
    //

    if(!is_logged_in()) {
        echo "<div id='main_text'>\n";
        echo "<p class='error'>You must be <a href='login.php'>logged in</a> to mess with your settings.</p>\n";
        echo "</div>\n";

        render_footer();
        die;
    }

    $user_id = get_logged_in_userid();

    $query = "SELECT user_name, UNIX_TIMESTAMP(user_join_date) as user_join_date ".
             "FROM users WHERE user_id=?";
    $user = $conn->GetRow($query, array($user_id));
    if($user) {
        $user_name = $user['user_name'];
        $user_timestamp = $user['user_join_date'];
        $user_day = date("jS", $user_timestamp);
        $user_month = date("F", $user_timestamp);
        $user_year = date("Y", $user_timestamp);
        $user_join_date = "The $user_day day of $user_month, in the year of our daily grind, $user_year";
        echo "<div id='main_text'>\n";
        echo "<h2>Hi there $user_name!</h2>\n";
        echo "<span>Care to change your <a href='password.php'>password</a>?</span>\n";
        echo "<br />\n";
        echo "<span>Member since: $user_join_date</span>\n";
        echo "<br />\n";
        echo "<br />\n";


        $characters = get_characters($user_id, "characters.character_level DESC");
        if($characters && count($characters) > 0) {
            echo "<div id='user_chars'>\n";
            echo "<span>Characters:</span>\n";
            echo "<table>\n";
            echo "<thead>\n";
            echo "<td class='td_name'>Name</td>\n";
            echo "<td class='td_level'>Level</td>\n";
            echo "<td class='td_job'>Job</td>\n";
            echo "<td class='td_dept'>Department</td>\n";
            echo "</thead>\n";
            foreach($characters as $character) {
                $char_name = $character['character_name'];
                $char_id = $character['character_id'];
                $char_level = $character['character_level'];
                $char_job = $character['job_name'];
                $char_department = $character['department_name'];
                echo "<tr>\n";
                echo "<td><a href='characters.php?char_id=$char_id'>$char_name</a></td>\n";
                echo "<td>$char_level</td>\n";
                echo "<td>$char_job</td>\n";
                echo "<td>$char_department</td>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
            echo "</div> <!-- end user_chars div -->\n";
        } else {
            echo "<div id='user_chars'>\n";
            echo "<p>$user_name has no characters yet.</p>\n";
            echo "</div> <!-- end user_chars div -->\n";
        }
        echo "</div> <!--end main_text div -->\n";
    }

    render_footer();

?>
