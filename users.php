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
    echo "<li>2 * 2 = 4</li>\n";
    echo "<li>0 * 0 = 42</li>\n";
    echo "</ul>\n";
    echo "</div> <!-- end sidebar_stats div -->\n";
    $query = "SELECT user_name, user_id FROM users ".
             "ORDER BY user_join_date DESC LIMIT 5";
    $newest_users = $conn->GetAll($query);
    if($newest_users) {
        echo "<div id='sidebar_stats'>\n";
        echo "<h3>Newest Users</h3>\n";
        echo "<ul>\n";
        foreach($newest_users as $user_row) {
            $user_name = $user_row['user_name'];
            $user_id = $user_row['user_id'];
            echo "<li><a href='users.php?user_id=$user_id'>$user_name</a></li>\n";
        }
        echo "</ul>\n";
        echo "</div> <!-- end sidebar_stats div -->\n";
    }
    echo "</div> <!-- end sidebar div -->\n";
    //
    // End sidebar
    //


    if(isset($_REQUEST['user_id'])) {
        $user_id = $_REQUEST['user_id'];

        $query = "SELECT user_name, user_join_date ".
                 "FROM users WHERE user_id=?";
        $user = $conn->GetRow($query, array($user_id));
        if($user) {
            $user_name = $user['user_name'];
            $user_join_date = $user['user_join_date'];
            echo "<div id='main_text'>\n";
            echo "<h2>$user_name</h2>\n";
            echo "<span>Member since: $user_join_date</span>\n";
            echo "<br />\n";
            echo "<br />\n";

            //User character table

            $characters = get_characters($user_id);
            if($characters && count($characters) > 0) {
                echo "<span>Characters:</span>\n";
                echo "<table>\n";
                echo "<tr>\n";
                echo "<td>Name</td>\n";
                echo "<td>Level</td>\n";
                echo "<td>Job</td>\n";
                echo "<td>Department</td>\n";
                echo "</tr>\n";
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
            } else {
                echo "<p>$user_name has no characters yet.</p>\n";
            }
            echo "</div> <!--end main_text div -->\n";
        }
    } else {
        //Show some form of search menu for users
    }

    render_footer();

?>
