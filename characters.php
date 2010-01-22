<?php

    include('includes/functions.php');

    render_header();

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
            $char_name = $character_row['character_name'];
            $department_name = $character_row['department_name'];
            $department_id = $character_row['department_id'];
            $job_name = $character_row['job_name'];
            $job_id = $character_row['job_id'];
            echo "<h3>$char_name</h3>\n";
            echo "<p>$char_name is a <a href='characters.php?job_id=$job_id'>$job_name</a> in the <a href='characters.php?department_id=$department_id'>$department_name</a> department.</p>\n";
        }
    } else {
        //Dsplay character picking stuffs
    }

    render_footer();

?>
