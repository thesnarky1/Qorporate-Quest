<?php

    //Function takes in a list of tasks and spits out the appropriate HTML
    function render_character_tasks($tasks, $render=true) {
        $to_return = "";
        foreach($tasks as $task_row) {
            //Set up vars
            $task_name = $task_row['task_name'];
            $task_flavor = $task_row['task_flavor'];
            $task_experience = $task_row['task_experience'];
            $task_id = $task_row['task_id'];
            $boss_id = $task_row['boss_id'];
            $boss_name = $task_row['boss_name'];
            $boss_flavor = $task_row['boss_flavor'];
            $boss_experience = $task_row['boss_experience'];

            //Display
            $to_return .= "<div id='char_quest_single'>\n";
            $to_return .= "<div id='char_quest_single_head' onclick='toggle_my_p(this);'>\n";
            $to_return .= "<h3>$task_name</h3>\n";
            $to_return .= "<span>Experience: $task_experience</span>\n";
            $to_return .= "<div id='char_quest_single_id'>$task_id</div>\n";
            $to_return .= "</div> <!-- end char_quest_single_head -->\n";
            $to_return .= "<div id='char_quest_single_body'>\n";
            $to_return .= "<p>";
            $to_return .= "$task_flavor\n";
            $to_return .= "<span class='footer'>Requested by: <a href='#' onclick='swap_boss(this);'>$boss_name</a></span>\n";
            $to_return .= "</p>\n";
            $to_return .= "<div id='char_single_quest_boss' style='display: none;'>\n";
            $to_return .= "<span id='boss_name'>$boss_name</span>\n";
            $to_return .= "<span id='boss_experience'>$boss_experience</span>\n";
            $to_return .= "<span id='boss_flavor'>$boss_flavor</span>\n";
            $to_return .= "</div> <!-- end boss_div -->\n";
            $to_return .= "</div> <!-- end char_quest_single_body -->\n";
            $to_return .= "</div> <!-- end char_quest_single -->\n";
        }
        if($render) {
            echo "$to_return";
        } else {
            return $to_return;
        }
    }


    //Function to validate a given roll was made by a user
    //expects an indexed array with char_satisfaction, 
    //char_loyalty, char_brown_nosing, and char_competence
    function validate_roll($char_satisfaction, $char_brown_nosing, $char_competence, $char_loyalty, $user_id) {
        global $conn;

        $query = "SELECT roll_id FROM rolls WHERE roll_satisfaction=? AND ".
                 "roll_brown_nosing=? AND roll_competence=? AND roll_loyalty=? AND ".
                 "user_id=? LIMIT 1";
        $result = $conn->Execute($query, array($char_satisfaction, $char_brown_nosing, 
                                 $char_competence, $char_loyalty, $user_id));
        if($result && $result->RowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    //Function to verify a job id is valid
    function validate_job_id($job_id) {
        global $conn;

        $query = "SELECT job_id FROM jobs WHERE job_id=?";
        $result = $conn->Execute($query, array($job_id));
        if($result && $result->RowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    //Function to verify a department id is valid
    function validate_department_id($department_id) {
        global $conn;

        $query = "SELECT department_id FROM departments WHERE department_id=?";
        $result = $conn->Execute($query, array($department_id));
        if($result && $result->RowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    //Function to roll for a character's skills
    function roll($user_id) {
        global $conn;

        $satis = rand(0, 15);
        $loyal = rand(0, 15);
        $comp = rand(0, 15);
        $brown = rand(0, 15);

        //Remove any potential previous rolls
        $query = "DELETE FROM rolls WHERE user_id=?";
        $conn->Execute($query, array($user_id));

        $query = "INSERT INTO rolls(roll_satisfaction, roll_brown_nosing, roll_competence, roll_loyalty, user_id) ".
                 "VALUES(?, ?, ?, ?, ?)";
        $conn->Execute($query, array($satis, $brown, $comp, $loyal, $user_id));
        return array("roll_satis" => $satis, "roll_brown" => $brown, "roll_comp" => $comp, "roll_loyal" => $loyal);
    }

    //Function levels up a character
    function level_up_character($char_id, $level, $exp, $satis, $brown, $comp, $loyal) {
        global $conn, $LEVEL_UP_RATIO;

        $satis_add = rand(1, 2);
        $brown_add = rand(1, 2);
        $comp_add = rand(1, 2);
        $loyal_add = rand(1, 2);

        $satis -= $satis_add;
        $brown += $brown_add;
        $comp += $comp_add;
        $loyal += $loyal_add;
        $max_exp = $level * $LEVEL_UP_RATIO;


        $query = "UPDATE characters ".
                 "SET character_exp=?, character_level=?, character_satisfaction=?, ".
                 "character_brown_nosing=?, character_competence=?, character_loyalty=? ".
                 "WHERE character_id=?";
        $result = $conn->Execute($query, array($exp, $level, $satis, $brown, $comp, $loyal, $char_id));
        return array("return_value" => "<p class='error'>You are now level $level!</p>",
                     "level" => $level,
                     "exp" => $exp,
                     "max_exp" => $max_exp,
                     "satisfaction" => $satis,
                     "brown_nosing" => $brown,
                     "competence" => $comp,
                     "loyalty" => $loyal);
    }

    //Function to add experience to a given character, checks for level up
    function add_character_experience($char_id, $exp) {
        global $conn, $LEVEL_UP_RATIO;

        $query = "SELECT character_exp, character_level, ".
                 "character_satisfaction, character_brown_nosing, ".
                 "character_competence, character_loyalty ".
                 "FROM characters WHERE character_id=?";
        $result = $conn->GetRow($query, array($char_id));
        if($result) {
            $level = $result['character_level'];
            $curr_exp = $result['character_exp'];
            $curr_exp += $exp;
            $max_exp = $level * $LEVEL_UP_RATIO;
            if($curr_exp >= $max_exp) {
                //We have a level up
                $level++;
                $curr_exp = $curr_exp - $max_exp;
                $satisfaction = $result['character_satisfaction'];
                $brown_nosing = $result['character_brown_nosing'];
                $competence = $result['character_competence'];
                $loyalty = $result['character_loyalty'];
                $to_return = level_up_character($char_id, $level, $curr_exp, $satisfaction, $brown_nosing, $competence, $loyalty);

                return $to_return;
            } else {
                //Just update the exp
                $query = "UPDATE characters ".
                         "SET character_exp=? ".
                         "WHERE character_id=?";
                $result = $conn->Execute($query, array($curr_exp, $char_id));
                return array("return_value" => "<p class='error'>You gained $exp experience</p>", "exp" => $curr_exp);
            }
        } else {
            echo $conn->ErrorMsg();
        }
    }

    //Function to get a character's quests
    function get_character_tasks($char_id, $limit=false, $ignore=false) {
        global $conn;

        $to_return = array();
        $args = array($char_id);
        $query = "SELECT tasks.task_experience, tasks.task_id, ".
                 "tasks.task_name, tasks.task_flavor, ".
                 "bosses.boss_name, bosses.boss_id, ".
                 "bosses.boss_flavor, bosses.boss_experience ".
                 "FROM tasks, bosses ".
                 "WHERE tasks.character_id=? AND ";
        if($ignore) {
           $query .= "tasks.task_id != ? AND ";
           $args[] = $ignore;
        }
        $query .= "bosses.boss_id=tasks.boss_id ";
        if($limit) {
            $query .= "LIMIT ?";
            $args[] = $limit;
        }
        $result = $conn->Execute($query, $args);
        if($result) {
            //Check if we need more quests
            if($result->RecordCount() < 10 && (!$limit || $limit >= 10)) {
                generate_quests($char_id, 200);
                return get_character_tasks($char_id, $limit);
            }
            return $result->GetRows();
        } else {
            generate_quests($char_id, 200);
            return get_character_tasks($char_id, $limit);
        }
    }

    //Function to nab the character's information for the play field
    function get_character_info($char_id, $quest_limit=false) {
        global $conn;

        $to_return = array();
        $query = "SELECT characters.character_name, characters.character_level, ".
                 "characters.character_loyalty, characters.character_satisfaction, ".
                 "characters.character_competence, characters.character_brown_nosing, ".
                 "characters.character_exp, ".
                 "jobs.job_name, departments.department_name ".
                 "FROM characters, jobs, departments ".
                 "WHERE characters.character_id=$char_id AND jobs.job_id=characters.job_id AND ".
                 "departments.department_id=characters.department_id";
        $result = $conn->GetRow($query);
        if($result) {
            $to_return['bio'] = $result;
            $quests = get_character_tasks($char_id, $quest_limit);
            $to_return['quests'] = $quests;
        } else {
            $to_return = false;
        }

        return $to_return;
    }

    //Function to set up an initial character's quests
    function initialize_quests($char_id) {
        global $conn;

        $bosses = get_bosses();
        $query = "SELECT quest_name, quest_flavor FROM quests ".
                 "WHERE quest_group='initial' ".
                 "ORDER BY quest_order";
        $result = $conn->GetAll($query);
        if($result && count($result) > 0) {
            $to_return = true;

            //Insert them
            foreach($result as $quest_row) {
                $quest_name = $quest_row['quest_name'];
                $quest_flavor = $quest_row['quest_flavor'];
                $boss = get_random_element($bosses);
                $boss_id = $boss['boss_id'];
                $boss_experience = $boss['boss_experience'];

                $task_experience = 10 + $boss_experience;
                $query = "INSERT INTO tasks(task_name, task_flavor, task_experience, boss_id, character_id) ".
                         "VALUES(?, ?, ?, ?, ?)";
                $result = $conn->Execute($query, array($quest_name, $quest_flavor, $task_experience, $boss_id, $char_id));
                if(!$result || $result->RowCount() != 1) {
                    $to_return = false; //On error we don't want to return true
                }
            }
            return true;
        } else {
            return false;
        }
    }


?>
