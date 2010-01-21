<?php

    include('includes/functions.php');

    //Make sure the player is logged in, otherwise we want to dump them out of the page
    if(!is_logged_in()) {
        render_header();
        echo "<p class='error'>";
        echo "Sorry, but if you want to have tons of fun and collate your weight in reports you'll have to <a href='login.php'>login</a> or <a href='register.php'>register</a> first!";
        echo "</p>\n";
        render_footer();
        die();
    }

    //We're logged in, lets set up the variables
    $user_id = get_logged_in_userid();
    $char_name = false;
    $char_id = false;
    $job = false;
    $department = false;


    ///
    /// Actual character creation code
    ///
    if(isset($_REQUEST['submit'])) {
        //Clean up all our input
        if(isset($_REQUEST['character_name'])) {
            $char_name = safetify_input($_REQUEST['character_name']);
        }
    
        if(isset($_REQUEST['job'])) {
            $job = safetify_input($_REQUEST['job']);
        }
    
        if(isset($_REQUEST['department'])) {
            $department = safetify_input($_REQUEST['department']);
        }

        $query = "INSERT INTO characters(character_name, character_level, user_id, job_id, department_id) ".
                 "VALUES('$char_name', 1, '$user_id', '$job', '$department')";
        $success = mysqli_insert($query);
        if($success) {
            //make sure we select the new char_id so it starts playing!
        } else {
        }
    }


    render_header();

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

    //
    //Now draw the main area of the page
    //
    echo "<div id='main_text'>\n";

    //Do we know which character is playing?
    if(isset($_REQUEST['char_id'])) {
        $char_id = safetify_input($_REQUEST['char_id']);
    } else {
        $characters = get_characters($user_id, "character_level ASC");
        $lowest_character = $characters[0];
        $char_id = $lowest_character['character_id'];
    }

    if($char_id) {

        //We can play since we know which character to do
        $char_id = safetify_input($_REQUEST['char_id']);
    
        if(!user_owns_character($user_id, $char_id)) {

            //Cheating... snarky comment needed
            echo "<p class='error'>Sorry, you're cheating... BACK TO WORK!</p>";
            render_footer();
            die();

        } else {

            //This user owns this character, lets play
            echo "<h3>Game view</h3>\n";

        }

    ///
    /// Display character creation form
    ///
    } else if(isset($_REQUEST['create_char']) || !$char_id) {
        //Display new character form
        echo "<h3>Character Creation</h3>\n";

        //Our help field for the descriptions
        echo "<div id='descriptions'>\n";
        echo "<h3>Job/Department Description</h3>\n";
        echo "<p>\n";
        echo "Need to know more about a life endi^H^H^H^H changing position with us? Look no further!";
        echo "</p>\n";
        echo "</div> <!-- end descriptions div -->\n";

        //The main application bit
        echo "<div id='char_creation'>\n";
        echo "<h3>&lt;Company Name&gt; Application</h3>\n";
        echo "<form name='char_creation' method='POST' action='play.php?create_char' class='form'>\n";
        if($error != "") {
            echo "<span class='error'>$error</span><br />\n";
        }
        echo "<label class='fixed_width'>Applicant Name:</label>\n";
        echo "<input type='text' name='character_name' ";
        if($char_name) {
            echo "value='$char_name'";
        }
        echo "/>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Applicant Position:</label>\n";
        echo "<select name='job'>\n";
        echo "<option value='0'>--Select a Job Position</option>\n";
        $jobs = get_jobs();
        $to_show = "";
        foreach($jobs as $job_row) {
            $job_name = $job_row['job_name'];
            $job_id = $job_row['job_id'];
            $job_div = "job_$job_id";
            echo "<option value='$job_id' ".
                   "onmouseover='swap_text(\"#descriptions\", \"#$job_div\");' ";
            if($job && $job == $job_id) {
                echo "selected='true'";
            }
            echo "/>$job_name</option>\n";
            $to_show .= "<div id='$job_div' style='display: none;'>\n";
            $to_show .= "$job_name is really fun!\n";
            $to_show .= "</div> <!-- end $job_div div -->\n";
        }
        echo "</select>\n";
        echo "$to_show";
        echo "<br />\n";
        echo "<label class='fixed_width'>Applicant Department:</label>\n";
        echo "<select name='department'>\n";
        echo "<option value='0'>--Select a Department</option>\n";
        $departments = get_departments();
        $to_show = "";
        foreach($departments as $department_row) {
            $department_name = $department_row['department_name'];
            $department_id = $department_row['department_id'];
            $department_div = "department_$department_id";
            echo "<option value='$department_id' ".
                   "onmouseover='swap_text(\"#descriptions\", \"#$department_div\");' ";
            if($department && $department == $department_id) {
                echo "selected='true'";
            }
            echo "/>$department_name</option>\n";
            $to_show .= "<div id='$department_div' style='display: none;'>\n";
            $to_show .= "$department_name is really fun!\n";
            $to_show .= "</div> <!-- end $department_div div -->\n";
        }
        echo "</select>\n";
        echo "$to_show";
        echo "<br />\n";
        echo "<input type='submit' name='submit' value='Apply!' />\n";
        echo "</form>\n";
        echo "</div> <!-- end char_creation div -->\n";
    }
    echo "</div> <!-- end main_text div -->\n";

    render_footer();

?>
