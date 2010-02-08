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

    //Initialized to false so we can tell if they were set correctly by 
    //a creation attempt later on
    $char_satisfaction = false;
    $char_loyalty = false;
    $char_brown_nosing = false;
    $char_competence = false;
    $char_job = false;
    $char_department = false;
    $char_name = false;
    $error = false;

    ///
    /// Actual character creation code
    ///
    if(isset($_REQUEST['submit'])) {

        //Clean up  and inspect all our input for input errors
        if(isset($_REQUEST['character_name'])) {
            $char_name = safetify_input($_REQUEST['character_name']);
            if(trim($char_name) == "") {
                $error = "Your character name may not be blank.";
            }
        } else {
            $error = "You must set a character name.";
        }
    
        if(isset($_REQUEST['job'])) {
            $char_job = safetify_input($_REQUEST['job']);
            if(!validate_job_id($char_job)) {
                $error = "Your character job appears to be falsified.";
            }
        } else {
            $error = "You must select a job.";
        }
    
        if(isset($_REQUEST['department'])) {
            $char_department = safetify_input($_REQUEST['department']);
            if(!validate_department_id($char_department)) {
                $error = "Your character department appears to be falsified.";
            }
        } else {
            $error = "You must select a department.";
        }
    
        if(isset($_REQUEST['char_satisfaction'])) {
            $char_satisfaction = safetify_input($_REQUEST['char_satisfaction']);
        } else {
            $error = "You must roll for satisfaction.";
        }
    
        if(isset($_REQUEST['char_brown_nosing'])) {
            $char_brown_nosing = safetify_input($_REQUEST['char_brown_nosing']);
        } else {
            $error = "You must roll for brown nosing.";
        }
    
        if(isset($_REQUEST['char_loyalty'])) {
            $char_loyalty = safetify_input($_REQUEST['char_loyalty']);
        } else {
            $error = "You must roll for loyalty.";
        }

        if(isset($_REQUEST['char_competence'])) {
            $char_competence = safetify_input($_REQUEST['char_competence']);
        } else {
            $error = "You must roll for competence.";
        }

        $valid_roll = validate_roll($char_satisfaction, $char_brown_nosing, 
                                    $char_competence, $char_loyalty, $user_id);

        if(!$valid_roll) {
            $error = "Your roll appears falsified.";
        }

        if(!$error) {
            $query = "INSERT INTO characters(character_name, user_id, job_id, department_id, ".
                     "character_satisfaction, character_loyalty, character_competence, character_brown_nosing) ".
                     "VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $success = $conn->Execute($query, array($char_name, $user_id, $char_job, $char_department, 
                                                    $char_satisfaction, $char_loyalty, $char_competence, $char_brown_nosing));
            if($success && $conn->Affected_Rows() == 1) {

                //make sure we select the new char_id so it starts playing!
                $char_id = $conn->Insert_ID();

                //Set up the newbie quests
                $set_up = initialize_quests($char_id);
                if($set_up) {
                    //aka set location to be play.php?char_id....
                    header("Location: play.php?char_id=$char_id");
                } 
            } else {
                echo $conn->ErrorMsg();
            }
        }
    }


    //
    // Start displaying the page
    //
    render_header();

    $characters = get_characters($user_id, "character_level DESC");
 
    //
    //Draw the sidebar, this will consist of a list of their characters to quickly switch
    //
    echo "<div id='sidebar'>\n";
    echo "<div id='sidebar_stats'>\n";
    echo "<h3>Your Characters</h3>\n";
    if(!$characters) {
        echo "You have no characters yet.";
    } else {
        //Spit out characters
        echo "<ul>\n";
        foreach($characters as $character_row) {
            $character_name = $character_row['character_name'];
            $character_id = $character_row['character_id'];
            $character_level = $character_row['character_level'];
            echo "<li><a href='play.php?char_id=$character_id'>$character_name</a> ($character_level)</li>\n";
        }
        echo "<li><a href='play.php?create_char'>Create new character</a></li>\n";
        echo "</ul>\n";
    }
    echo "</div> <!-- end sidebar_stats div -->\n";
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
    echo "</div><!-- end sidebar div -->\n";
    //
    // End sidebar
    //
    

    //
    //Now draw the main area of the page
    //
    echo "<div id='main_text'>\n";

    //Do we know which character is playing?
    if(isset($_REQUEST['char_id'])) {
        $char_id = safetify_input($_REQUEST['char_id']);
    } else if(!isset($_REQUEST['create_char'])) {
        $characters = get_characters($user_id, "character_level ASC");
        $lowest_character = $characters[0];
        $char_id = $lowest_character['character_id'];
    }


    //
    // Draw the play area
    //
    if($char_id) {
   
        //We can play since we know which character we have
        if(!user_owns_character($user_id, $char_id)) {

            //Cheating... snarky comment needed
            echo "<p class='error'>Sorry, you're cheating... <a href='play.php'>BACK TO WORK</a>!</p>";
            render_footer();
            die();

        } else {
            render_character_sheet($char_id);
        }

    ///
    /// Display character creation form
    ///
    } else if(isset($_REQUEST['create_char'])) {
        //Display new character form
        echo "<h3>Character Creation</h3>\n";

        //echo "<p class='registration_flavor'>\n";
        //echo "Look at this lovely online application system code monkey #3 turned out! He earned himself a 5 minute trip out of the dungeon to any vending machine he wants! But enough about him, lets talk about you and your future. We've identified the positions and departments you are uniquely skilled for and--- oh I can't stop laughing, it kills me every time. Apply for whatever you want, no matter what we'll break your spirit and mold you into what we need.";
        //echo "</p>\n";

        //The main application bit
        echo "<div id='char_creation'>\n";
        echo "<h3>&lt;Company Name&gt; Application</h3>\n";
        echo "<form id='creation_form' name='char_creation' method='POST' action='play.php?create_char' class='form' >\n";
        echo "<span class='error' id='char_creation_error'>";
        if($error != "") {
            echo $error;
        }
        echo "</span><br />\n";
        echo "<label class='fixed_width'>Applicant Name:</label>\n";
        echo "<input type='text' name='character_name' id='creation_char_name' ";
        if($char_name) {
            echo "value='$char_name'";
        }
        echo "/>\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Applicant Position:</label>\n";
        echo "<select name='job' id='creation_char_job'>\n";
        echo "<option value='0'>--Select a Job Position</option>\n";
        $jobs = get_jobs();
        $to_show = "";
        foreach($jobs as $job_row) {
            $job_name = $job_row['job_name'];
            $job_id = $job_row['job_id'];
            $job_flavor = $job_row['job_flavor'];
            $job_div = "job_$job_id";
            echo "<option value='$job_id' ".
                   "onmouseover='swap_text(\"#descriptions\", \"#$job_div\");' ";
            if($char_job && $char_job == $job_id) {
                echo "selected='true'";
            }
            echo "/>$job_name</option>\n";
            $to_show .= "<div id='$job_div' style='display: none;'>\n";
            $to_show .= "$job_flavor\n";
            $to_show .= "</div> <!-- end $job_div div -->\n";
        }
        echo "</select>\n";
        echo "$to_show";
        echo "<br />\n";
        echo "<label class='fixed_width'>Applicant Department:</label>\n";
        echo "<select name='department' id='creation_char_dept'>\n";
        echo "<option value='0'>--Select a Department</option>\n";
        $departments = get_departments();
        $to_show = "";
        foreach($departments as $department_row) {
            $department_name = $department_row['department_name'];
            $department_id = $department_row['department_id'];
            $department_flavor = $department_row['department_flavor'];

            $department_div = "department_$department_id";
            echo "<option value='$department_id' ".
                   "onmouseover='swap_text(\"#descriptions\", \"#$department_div\");' ";
            if($char_department && $char_department == $department_id) {
                echo "selected='true'";
            }
            echo "/>$department_name</option>\n";
            $to_show .= "<div id='$department_div' style='display: none;'>\n";
            $to_show .= "$department_flavor\n";
            $to_show .= "</div> <!-- end $department_div div -->\n";
        }
        echo "</select>\n";
        echo "$to_show";
        echo "<br />\n";

        //Deal with stats
        if(!$char_satisfaction) {
            $roll = roll($user_id);
            $char_satisfaction = $roll['roll_satis'];
            $char_brown_nosing = $roll['roll_brown'];
            $char_loyalty = $roll['roll_loyal'];
            $char_competence = $roll['roll_comp'];
        }

        echo "<label class='fixed_width'>Job Satisfaction: </label>\n";
        echo "<input type='text' name='char_satisfaction' id='char_satisfaction' value='$char_satisfaction' readonly='true' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Brown Nosing: </label>\n";
        echo "<input type='text' name='char_brown_nosing' id='char_brown_nosing' value='$char_brown_nosing' readonly='true' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Competence: </label>\n";
        echo "<input type='text' name='char_competence' id='char_competence' value='$char_competence' readonly='true' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Loyalty: </label>\n";
        echo "<input type='text' name='char_loyalty' id='char_loyalty' value='$char_loyalty' readonly='true' />\n";
        echo "<br />\n";
        echo "<label class='fixed_width'>Reroll stats: </label>\n";
        echo "<input type='submit' id='reroll_button' value='Reroll' onclick='reroll_stats();' />\n";
        echo "<br />\n";
        echo "<div id='char_creation_stats'>\n";
        echo "</div> <!-- end char_creation_stats div -->\n";
        echo "<input type='submit' name='submit' value='Apply!' id='bad_hack_i_hate_javascript' />\n";
        echo "</form>\n";
        echo "</div> <!-- end char_creation div -->\n";

        //Our help field for the descriptions
        echo "<div id='descriptions'>\n";
        echo "<h3>Job/Department Description</h3>\n";
        echo "<p>\n";
        echo "Need to know more about a life endi^H^H^H^H changing position with us? Look no further!";
        echo "</p>\n";
        echo "</div> <!-- end descriptions div -->\n";
    }
    echo "</div> <!-- end main_text div -->\n";

    render_footer();

?>
