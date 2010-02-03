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

                //If a task id is given its being given to complete the task
                if(isset($_REQUEST['task_id'])) {
                    $task_id = $_REQUEST['task_id'];
                    $to_return = "";

                    $query = "SELECT task_experience FROM tasks ".
                             "WHERE task_id=? AND character_id=? ".
                             "ORDER BY task_id LIMIT 1";
                    $result = $conn->GetRow($query, array($task_id, $char_id));
                    if($result) {
                        //We have a valid quest
                        //add the experience
                        $exp = $result['task_experience'];
                        $to_return = add_character_experience($char_id, $exp);
                        //Remove the quest
                        $query = "DELETE FROM tasks ".
                                 "WHERE task_id=? ".
                                 "LIMIT 1";
                        $result = $conn->Execute($query, array($task_id));
                        echo json_encode($to_return);
                    } else {
                        $error = $conn->ErrorMsg();
                        if(!$error || $error == "") {
                            $error = "No Mysql error....";
                        }
                        echo json_encode(array("return_value" => "$error - $query - $task_id - $char_id"));
                    }
                } else {
                    $to_return = "";
                    $tasks = get_character_tasks($char_id, 20);
                    foreach($tasks as $task) {
                        //Set up vars
                        $quest_name = $task['quest_name'];
                        $quest_flavor = $task['quest_flavor'];
                        $quest_experience = $task['task_experience'];
                        $task_id = $task['task_id'];
                        //Display
                        $to_return .= "<div id='char_quest_single'>\n";
                        $to_return .= "<div id='char_quest_single_head' onclick='toggle_my_p(this);'>\n";
                        $to_return .= "<h3>$quest_name</h3>\n";
                        $to_return .= "<span>Experience: $quest_experience</span>\n";
                        $to_return .= "<div id='char_quest_single_id'>$task_id</div>\n";
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
    } else {
        echo json_encode(array("return_value" => "Some error occured and you don't appear to be logged in. User: $_SESSION[user_name], hash: $_SESSION[user_hash], id: $_SESSION[user_id]."));
    }


?>
