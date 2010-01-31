<?php

    //Function to add experience to a given character, checks for level up
    function add_character_experience($char_id, $exp) {
        global $conn;

        $query = "SELECT character_exp, character_level ".
                 "FROM characters WHERE character_id=?";
        $result = $conn->GetRow($query, array($char_id));
        if($result) {
            $level = $result['character_level'];
            $curr_exp = $result['character_exp'];
            $curr_exp += $exp;
            $max_exp = $level * 100;
            if($curr_exp > $level * 100) {
                //We have a level up
                $level++;
                $curr_exp = $curr_exp - $max_exp;
                $query = "UPDATE characters ".
                         "SET character_exp=?, character_level=? ".
                         "WHERE character_id=?";
                $result = $conn->Execute($query, array($curr_exp, $level, $char_id));
                return array("return_value"=>"<p class='error'>You are now level $level!</p>",
                             "level" => $level);
            } else {
                //Just update the exp
                $query = "UPDATE characters ".
                         "SET character_exp=? ".
                         "WHERE character_id=?";
                $result = $conn->Execute($query, array($curr_exp, $char_id));
                return array("return_value" => "<p class='error'>You gained $exp experience</p>");
            }
        } else {
            echo $conn->ErrorMsg();
        }
    }

    //Function to get a character's quests
    function get_character_tasks($char_id, $limit=false) {
        global $conn;

        $to_return = array();
        $query = "SELECT adventures.adventure_experience, adventures.adventure_id, ".
                 "quests.quest_name, ".
                 "quests.quest_flavor, quests.quest_id ".
                 "FROM adventures, quests ".
                 "WHERE adventures.character_id=? AND ".
                 "quests.quest_id=adventures.quest_id ";
        if($limit) {
            $query .= "LIMIT $limit";
        }
        $result = $conn->Execute($query, array($char_id));
        if($result) {
            if($result->RecordCount() < 10) {
                generate_quests_for_character($char_id, 200);
                return get_character_tasks($char_id, $limit);
            }
            return $result->GetRows();
        } else {
            generate_quests_for_character($char_id, 200);
            return get_character_tasks($char_id, $limit);
        }
    }

    //Function to nab the character's information for the play field
    function get_character_info($char_id, $quest_limit=false) {
        global $conn;

        $to_return = array();
        $query = "SELECT characters.character_name, characters.character_level, ".
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

        $query = "SELECT quest_id FROM quests ".
                 "WHERE quest_group='initial' ".
                 "ORDER BY quest_order";
        $result = $conn->GetAll($query);
        if($result && count($result) > 0) {
            //Insert them
            foreach($result as $quest_row) {
                $quest_id = $quest_row['quest_id'];
                $query = "INSERT INTO adventures(character_id, quest_id, adventure_experience) ".
                         "VALUES($char_id, $quest_id, '10')";
                $conn->Execute($query);
            }
            return true;
        } else {
            //Do... nothing
            //echo "$query\n"; //pure debug
            return false;
        }
    }


?>
