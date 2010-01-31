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
                $to_return = "";
                $tasks = get_character_tasks($char_id, 10);
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
        }

    }


?>
