<?php

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
                $query = "INSERT INTO adventures(character_id, quest_id) ".
                         "VALUES('$char_id', '$quest_id')";
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
