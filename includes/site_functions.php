<?php

    /*
      Site functions file
      Includes any functions or variables needed to actually display the site
    */

    //Function to render the entire play sheet for a given character
    function render_character_sheet($char_id) {
        global $LEVEL_UP_RATIO;
        $character_info = get_character_info($char_id, 20);

        //This user owns this character, lets play
        echo "<h3></h3>\n";
        echo "<div id='char_id_hidden' style='display:none;'>$char_id</div>\n";
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
        echo "<span>Level <span id='char_level'>".$character_info['bio']['character_level']."</span> ".
             $character_info['bio']['job_name']."</span>\n";
        echo "</div> <!-- end char_bio_job div -->\n";

        //Char department
        echo "<div id='char_bio_department'>\n";
        echo "<div class='char_bio_info_fixed'>Dept: </div>";
        echo "<span>".$character_info['bio']['department_name']."</span>\n";
        echo "</div> <!-- end char_bio_department div -->\n";

        //Char Experience
        $max_exp = $character_info['bio']['character_level'] * $LEVEL_UP_RATIO;
        echo "<div id='char_bio_exp'>\n";
        echo "<div class='char_bio_info_fixed'>Exp: </div>";
        echo "<span id='current_exp'>".$character_info['bio']['character_exp']."</span> of ";
        echo "<span id='max_exp'>$max_exp</span>\n";
        echo "</div> <!-- end char_bio_exp div -->\n";

        //Progress Bar
        $exp_percent = ($character_info['bio']['character_exp'] / $max_exp) * 100;
        echo "<div id='exp_percent' style='display: none'>$exp_percent</div><!-- end exp_percent div -->\n";
        echo "<div id='exp_progress_bar'></div>\n";

        echo "</div> <!-- end char_bio_info div -->\n";
   
        //Stats div
        echo "<div id='char_stats_info'>\n";
        echo "<h3>Employee Stats</h3>\n";

        //Job Satisfaction
        echo "<div id='char_stats_stat'>\n";
        echo "<div class='char_stats_fixed'>Job Satisfaction: </div>";
        echo "<div>".$character_info['bio']['character_satisfaction']."</div>\n";
        echo "</div> <!-- end char_stats_stat div -->\n";

        //Loyalty
        echo "<div id='char_stats_stat'>\n";
        echo "<div class='char_stats_fixed'>Loyalty: </div>";
        echo "<div>".$character_info['bio']['character_loyalty']."</div>\n";
        echo "</div> <!-- end char_stats_stat div -->\n";

        //Competence
        echo "<div id='char_stats_stat'>\n";
        echo "<div class='char_stats_fixed'>Competence: </div>";
        echo "<div>".$character_info['bio']['character_competence']."</div>\n";
        echo "</div> <!-- end char_stats_stat div -->\n";

        //Brown Nosing
        echo "<div id='char_stats_stat'>\n";
        echo "<div class='char_stats_fixed'>Brown Nosing: </div>";
        echo "<div>".$character_info['bio']['character_brown_nosing']."</div>\n";
        echo "</div> <!-- end char_stats_stat div -->\n";


        echo "</div> <!-- end char_stats_info div -->\n";
        echo "</div> <!-- end char_sheet_upper div -->\n";

        echo "<div id='char_messages' style='display: none;'></div>\n";
        //Current task area
        echo "<div id='char_quest_current'>\n";
        echo "<h3>Current task: <span id='progress'></span></h3>\n";
        echo "<div id='task_progress_bar'></div><!-- end task_progress_bar div -->\n";
        echo "<div id='char_quest_current_text'>\n";
        echo "</div> <!-- end char_quest_current_text div -->\n";
        echo "</div> <!-- end char_quest_current div -->\n";

        //Task area
        $quest_num = 0;
        if($character_info['quests']) {
            $quest_num = count($character_info['quests']);
        }
        echo "<h3>Task List <span id='char_tasks_remaining'>($quest_num left)</span></h3>\n";
        if(isset($character_info['quests'])) {
            echo "<div id='char_quests_div'>\n";
            //Handy function spits out the HTML for us
            render_character_tasks($character_info['quests']);
        } else {
            echo "<p class='error>No tasks assigned for the future, please refresh the page.</p>\n";
        }
        echo "</div> <!-- end char_quests_div -->\n";
        echo "</div> <!-- end char_play_div -->\n";
    }


    //Renders everything in the footer
    function render_footer() {
        echo "</div> <!-- end content div -->\n";
        echo "</div> <!-- end container div -->\n";
        echo "</body>\n";
        echo "</html>\n";
    }

    //Renders the meta header, aka everything up until the actual body of the page
    function render_header() {
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'\n";
        echo "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>\n";
        echo "<head>\n";
        echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />\n";
        echo "<link rel='shortcut icon' href='favicon.ico' type='image/x-icon' />\n";
        echo "<link rel='stylesheet' href='./includes/stylesheet.css' type='text/css' media='screen' />\n";
        echo "<link rel='stylesheet' href='./scripts/libs/jquery_ui/css/smoothness/jquery-ui-1.7.2.custom.css' type='text/css' media='screen' />\n";
        echo "<script type='text/javascript' src='./scripts/libs/jquery-1.4.min.js'></script>\n";
        echo "<script type='text/javascript' src='./scripts/libs/jquery_ui/js/jquery-ui-1.7.2.custom.min.js'></script>\n";
        echo "<script type='text/javascript' src='./scripts/common.js'></script>\n";
        $curr_file = basename($_SERVER['REQUEST_URI']);
        if(strpos($curr_file, "play.php") === false) {
        } else {
            echo "<script type='text/javascript' src='./scripts/play.js'></script>\n";
        }
        echo "<title>Qorporate Quest - QQ moar, intern</title>\n";
        echo "</head>\n";

        // Farm out call to render the page header, just to keep the code neat
        render_page_header();
    }

    //Renders the nav bar within the header
    function render_header_nav_bar() {
        echo "<div id='header_nav_buttons'>\n";
        //Toggle between login/logout
        if(is_logged_in()) {
            echo "<span class='nav_button'><a href='index.php'>Home</a></span>\n";
            echo "<span class='nav_button'><a href='play.php'>Play</a></span>\n";
            echo "<span class='nav_button'><a href='http://threeplanetssoftware.com/forums/index.php?board=7.0' target='blank'>Forums</a></span>\n";
            echo "<span class='nav_button'><a href='logout.php'>Logout</a></span>\n";
        } else {
            echo "<span class='nav_button'><a href='index.php'>Home</a></span>\n";
            //echo "<span class='nav_button'><a href='login.php'>Login</a></span>\n";
            echo "<span class='nav_button'><a href='register.php'>Register</a></span>\n";
            echo "<span class='nav_button'><a href='http://threeplanetssoftware.com/forums/index.php?board=7.0' target='blank'>Forums</a></span>\n";
        }
        echo "</div> <!-- end header_nav_buttons div -->\n";
    }

    //Renders the quick login form in the header
    function render_header_quick_login() {
        echo "<div id='header_quick_login'>\n";

        if(is_logged_in()) {

            //Show the player info small box
            $user_name = get_logged_in_username();
            $user_id = get_logged_in_userid();
            echo "<div id='header_character_picker'>\n";
            $characters = get_characters($user_id, "character_level DESC");
            if($characters) {
                //Show character picker dropdown menu
                echo "<span>Quick Play:</span>\n";
                echo "<select name='character_picker'>\n";
                foreach($characters as $character_row) {
                    $char_name = $character_row['character_name'];
                    $char_level = $character_row['character_level'];
                    $char_id = $character_row['character_id'];
                    echo "<option onclick='window.location=\"play.php?char_id=$char_id\";'>";
                    echo "$char_name ($char_level)";
                    echo "</option>\n";
                }
                echo "</select>\n";
            } else {
                echo "<p><a href='play.php?create_char'>Start Playing!</a></p>\n";
            }
            echo "</div> <!-- end header_character_picker div -->\n";
            echo "<div id='header_username'>\n";
            echo "<span>Welcome <a href='users.php'>$user_name</a>!</span>\n";
            echo "</div> <!-- end header_username div -->\n";

        } else {
        
            //Show the login form small box
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

    //Renders the page header, aka the header within the body
    function render_page_header() {
        echo "<body>\n";
        echo "<div id='container'>\n";
        echo "<div id='header'>\n";

        //Title on the left side
        echo "<div id='header_title'>\n";
        echo "<a href='index.php'>";
        echo "<div id='header_title_qq'>QQ</div>";
        echo "<div id='header_title_moar'>moar</div>";
        echo "</a>\n";
        echo "</div> <!-- End header_logo div -->\n";

        //Quick login form on the right side
        render_header_quick_login();

        //Nav bar in the middle
        render_header_nav_bar();

        echo "</div> <!-- end header div -->\n";
        echo "<div id='content'>\n";
    }

?>
