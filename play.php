<?php

    include('includes/functions.php');

    render_header();

    //Make sure the player is logged in, otherwise we want to dump them out of the page
    if(!is_logged_in()) {
        echo "<p class='error'>";
        echo "Sorry, but if you want to have tons of fun and collate your weight in reports you'll have to <a href='login.php'>login</a> or <a href='register.php'>register</a> first!";
        echo "</p>\n";
        render_footer();
        die();
    }

    //We're logged in, lets set up the variables
    $user_id = get_logged_in_userid();
    $characters = get_characters($user_id);
  
    //Draw the sidebar, this will consist of a list of their characters to quickly switch
    echo "<div id='sidebar'>\n";
    echo "<h3>Characters</h3>\n";
    if(!$characters) {
        echo "You have no characters yet :(";
    } else {
        //Spit out characters
        echo "<ul>\n";
        foreach($characters as $character_row) {
            $character_name = $character_row['character_name'];
            $character_id = $character_row['character_id'];
            echo "<li><a href='play.php?char_id=$character_id'>$character_name</a></li>\n";
        }
        echo "<li><a href='play.php?create_char'>Create new character</a></li>\n";
        echo "</ul>\n";
    }
    echo "</div> <!-- end sidebar div -->\n";

    //Now draw the main area of the page
    echo "<div id='main_text'>\n";
    if(isset($_REQUEST['create_char'])) {
        //Display new character form
        echo "<h3>Character Creation</h3>\n";
        echo "<div id='job_description'>\n";
        echo "<h3>Job Description</h3>\n";
        echo "<p>Testing</p>\n";
        echo "</div> <!-- end job_description div -->\n";
        echo "<div id='char_creation'>\n";
        echo "<h3>&lt;Company Name&gt; Application</h3>\n";
        echo "<form name='char_creation' method='POST' action='play.php' class='form'>\n";
        if($error != "") {
            echo "<span class='error'>$error</span><br />\n";
        }
        echo "<label class='fixed_width'>Applicant Name:</label>\n";
        echo "<input type='text' name='character_name' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Applicant Position:</label>\n";
        echo "<select name='job'>\n";
        $jobs = get_jobs();
        foreach($jobs as $job_row) {
            $job_name = $job_row['job_name'];
            $job_id = $job_row['job_id'];
            echo "<option value='$job_id'>$job_name</option>\n";
            echo "<div id='job_".$job_id."' class='hidden'>\n";
            echo "<p>$job_name is really fun!</p>\n";
            echo "</div> <!-- end job_".$job_id." div -->\n";
        }
        echo "</select>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Applicant Department:</label>\n";
        echo "<select name='department'>\n";
        $departments = get_departments();
        foreach($departments as $department_row) {
            $department_name = $department_row['department_name'];
            $department_id = $department_row['department_id'];
            echo "<option value='$department_id'>$department_name</option>\n";
        }
        echo "</select>\n";
        echo "<br />\n";
        echo "<input type='submit' name='submit' value='Apply!' />\n";
        echo "</form>\n";
        echo "</div> <!-- end char_creation div -->\n";
    } else {
        //Display game view
        echo "<h3>Game view</h3>\n";
    }
    echo "</div> <!-- end main_text div -->\n";

    render_footer();

?>
