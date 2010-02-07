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
    $rand_characters = get_random_characters(5, "character_level DESC");
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
//            $char_name = $character_row['character_name'];
//            $department_name = $character_row['department_name'];
//            $department_id = $character_row['department_id'];
//            $job_name = $character_row['job_name'];
//            $job_id = $character_row['job_id'];
//            echo "<h3>$char_name</h3>\n";
//            echo "<p>$char_name is a <a href='characters.php?job_id=$job_id'>$job_name</a> in the <a href='characters.php?department_id=$department_id'>$department_name</a> department.</p>\n";
        }
    } else {
        //Dsplay character picking stuffs
    }

    render_footer();

?>
