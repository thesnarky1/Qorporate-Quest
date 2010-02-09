<?php

    include('includes/functions.php');

    render_header();

    //
    // Sidebar
    //
    echo "<div id='sidebar'>\n";
    $rand_characters = get_random_characters(5);
    if($rand_characters) {
        echo "<div id='sidebar_stats'>\n";
        echo "<h3>Random Characters</h3>\n";
        echo "<ul>\n";
        foreach($rand_characters as $character_row) {
            $char_name = $character_row['character_name'];
            $char_id = $character_row['character_id'];
            echo "<li><a href='characters.php?char_id=$char_id'>$char_name</a></li>\n";
        }
        echo "</ul>\n";
        echo "</div> <!-- end sidebar_stats div -->\n";
    }
    $rand_characters = get_random_characters(5, "character_level DESC, character_exp DESC ");
    if($rand_characters) {
        echo "<div id='sidebar_stats'>\n";
        echo "<h3>Top Characters</h3>\n";
        echo "<ul>\n";
        foreach($rand_characters as $character_row) {
            $char_name = $character_row['character_name'];
            $char_id = $character_row['character_id'];
            $char_level = $character_row['character_level'];
            echo "<li><a href='characters.php?char_id=$char_id'>$char_name ($char_level)</a></li>\n";
        }
        echo "</ul>\n";
        echo "</div> <!-- end sidebar_stats div -->\n";
    }
    echo "<div id='sidebar_boss'>\n";
    echo "<h3>Boss Facts</h3>\n";
    echo "<span id='boss_name'></span>\n";
    echo "<br />\n";
    echo "<br />\n";
    echo "<span>Experience Bonus:</span>\n";
    echo "<span id='boss_experience'></span>\n";
    echo "<br />\n";
    echo "<p id='boss_flavor'></p>\n";
    echo "<div id='sidebar_footer' onclick=\"$('#sidebar_boss').css('display', 'none');\">Close me</div>\n";
    echo "</div> <!-- end sidebar_boss div -->\n";
    echo "</div> <!-- end sidebar div -->\n";
    //
    // End sidebar
    //

    if(isset($_REQUEST['char_id'])) {
        //Display Character info

        $char_id = safetify_input($_REQUEST['char_id']);

        $query = "SELECT characters.character_name, ".
                 "jobs.job_name, jobs.job_id, ".
                 "departments.department_name, departments.department_id ".
                 "FROM characters, jobs, departments ".
                 "WHERE characters.character_id=? AND ".
                 "jobs.job_id=characters.job_id AND ".
                 "departments.department_id=characters.department_id";
        $character_row = $conn->GetRow($query, array($char_id));
        if($character_row) {
            render_character_sheet($char_id);
        }
    } else {
        echo "<div id='main_text'>\n";
        echo "<h3>Characters</h3>\n";
        $user_id = get_logged_in_userid();
        $characters = get_characters($user_id, "characters.character_level DESC");
        if($characters && count($characters) > 0) {
            echo "<div id='user_chars'>\n";
            echo "<span>Your Characters:</span>\n";
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
        echo "</div> <!-- end main_text div -->\n";
    }

    render_footer();

?>
