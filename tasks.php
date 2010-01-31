<?php

    include('includes/functions.php');

    if(is_logged_in()) {

        if(isset($_REQUEST['char_id'])) {
            //Get vars
            $char_id = $_REQUEST['char_id'];
            $user_hash = $_SESSION['user_hash'];
            $user_id = $_SESSION['user_id'];
    
            //check for valid char
            if(user_owns_character($user_id, $char_id, $user_hash)) {

                //If a quest id is given its being given to complete the quest
                if(isset($_REQUEST['quest_id'])) {
                    $adventure_id = $_REQUEST['quest_id'];
                    $to_return = "";

                    $query = "SELECT adventure_experience FROM adventures ".
                             "WHERE adventure_id=? AND character_id=? ".
                             "ORDER BY adventure_id LIMIT 1";
                    $result = $conn->GetRow($query, array($adventure_id, $char_id));
                    if($result) {
                        //We have a valid quest
                        //add the experience
                        $exp = $result['adventure_experience'];
                        $to_return = add_character_experience($char_id, $exp);
                        //Remove the quest
                        $query = "DELETE FROM adventures ".
                                 "WHERE adventure_id=? ".
                                 "LIMIT 1";
                        $result = $conn->Execute($query, array($adventure_id));
                    }
                    echo json_encode($to_return);
                } else {
                    $to_return = "";
                    $tasks = get_character_tasks($char_id, 20);
                    foreach($tasks as $task) {
                        //Set up vars
                        $quest_name = $task['quest_name'];
                        $quest_flavor = $task['quest_flavor'];
                        $quest_experience = $task['adventure_experience'];
    
                        //Display
                        $to_return .= "<div id='char_quest_single'>\n";
                        $to_return .= "<div id='char_quest_single_head' onclick='toggle_my_p(this);'>\n";
                        $to_return .= "<h3>$quest_name</h3>\n";
                        $to_return .= "<span>Experience: $quest_experience</span>\n";
                        $to_return .= "</div> <!-- end char_quest_single_head -->\n";
                        $to_return .= "<p>$quest_flavor</p>\n";
                        $to_return .= "</div> <!-- end char_quest_single -->\n";
                    }
                    echo json_encode(array("return_value" => $to_return));
                }
            } else {
                echo json_encode(array("return_value" => "<p class='error'>You a cheater</p>\n"));
            }
        }
    }


?>
