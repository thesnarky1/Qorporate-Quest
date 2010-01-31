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
                 "VALUES('$char_name', '1', '$user_id', '$job', '$department')";
        $success = $conn->Execute($query);
        if($success && $conn->Affected_Rows() == 1) {
            //make sure we select the new char_id so it starts playing!
            $char_id = $conn->Insert_ID();
            //Set up the newbie quests
            $set_up = initialize_quests($char_id);
            if($set_up) {
                //aka set location to be play.php?char_id....
                header("Location: play.php?char_id=$char_id");
            } else {
                render_footer();
                die();
            }
        } else {
            echo $conn->ErrorMsg();
        }
    }


    render_header();

    $characters = get_characters($user_id);
 
    //
    //Draw the sidebar, this will consist of a list of their characters to quickly switch
    //
    echo "<div id='sidebar'>\n";
    echo "<h3>Characters</h3>\n";
    if(!$characters) {
        echo "You have no characters yet.";
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
            echo "<p class='error'>Sorry, you're cheating... BACK TO WORK!</p>";
            render_footer();
            die();

        } else {

            $character_info = get_character_info($char_id);
            //echo "<div><p>\n";
            //print_r($character_info);
            //echo "</p></div>\n";


            //This user owns this character, lets play
            echo "<h3></h3>\n";
            echo "<div id='char_play_div'>\n";

            echo "<div id='char_sheet_upper'>\n";
            //Biographical area
            echo "<div id='char_bio_info'>\n";
            echo "<h3>Employee Personal Information</h3>\n";
            //Char name
            echo "<div id='char_bio_name'>\n";
            echo "<div class='char_bio_info_fixed'>Name: </div>";
            echo "<div>".$character_info['bio']['character_name']."</div>\n";
            echo "</div> <!-- end char_bio_name div -->\n";
            //Char job/Level
            echo "<div id='char_bio_job'>\n";
            echo "<div class='char_bio_info_fixed'>Job: </div>";
            echo "<span>Level ".$character_info['bio']['character_level']." ".
                 $character_info['bio']['job_name']."</span>\n";
            echo "</div> <!-- end char_bio_job div -->\n";
            //Char department
            echo "<div id='char_bio_department'>\n";
            echo "<div class='char_bio_info_fixed'>Dept: </div>";
            echo "<span>".$character_info['bio']['department_name']."</span>\n";
            echo "</div> <!-- end char_bio_department div -->\n";
            echo "</div> <!-- end char_bio_info div -->\n";
       
            //Stats div
            echo "<div id='char_stats_info'>\n";
            echo "<h3>Employee Statistics</h3>\n";
            echo "<table>\n";
            echo "<thead>\n";
            echo "<tr>\n";
            echo "<td>Agi</td>\n";
            echo "<td>Dex</td>\n";
            echo "<td>Str</td>\n";
            echo "<td>Int</td>\n";
            echo "</tr>\n";
            echo "</thead>\n";
            echo "<tr>\n";
            echo "<td>1</td>\n";
            echo "<td>2</td>\n";
            echo "<td>3</td>\n";
            echo "<td>4</td>\n";
            echo "</tr>\n";
            echo "</table>\n";
            echo "</div> <!-- end char_stats_info div -->\n";
            echo "</div> <!-- end char_sheet_upper div -->\n";

            //Current task area
            echo "<div id='char_quest_current'>\n";
            echo "<h3>Current quest</h3>\n";
            echo "<div id='char_quest_current_text'>\n";
            echo "</div> <!-- end char_quest_current_text div -->\n";
            echo "</div> <!-- end char_quest_current div -->\n";

            //Quest area
            echo "<h3>Task List</h3>\n";
            if(isset($character_info['quests'])) {
                echo "<div id='char_quests_div'>\n";
                foreach($character_info['quests'] as $quest_row) {
                    //Set up vars
                    $quest_name = $quest_row['quest_name'];
                    $quest_flavor = $quest_row['quest_flavor'];
                    $quest_experience = $quest_row['adventure_experience'];

                    //Display
                    echo "<div id='char_quest_single'>\n";
                    echo "<div id='char_quest_single_head' onclick='toggle_my_p(this);'>\n";
                    echo "<h3>$quest_name</h3>\n";
                    echo "<span>Experience: $quest_experience</span>\n";
                    echo "</div> <!-- end char_quest_single_head -->\n";
                    echo "<p>$quest_flavor</p>\n";
                    echo "</div> <!-- end char_quest_single -->\n";
                }
            } else {
                echo "<p class='error>No tasks assigned for the future, please refresh the page.</p>\n";
            }
            echo "</div> <!-- end char_quests_div -->\n";
            echo "</div> <!-- end char_play_div -->\n";
        }

    ///
    /// Display character creation form
    ///
    } else if(isset($_REQUEST['create_char'])) {
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
