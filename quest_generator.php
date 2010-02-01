<?php

    include('includes/functions.php');

    

    $quests = generate_all_quests();
    if(false) {
        foreach($quests as $quest) {
            $quest_name = $quest[0];
            $quest_flavor = $quest[1];
            $query = "INSERT INTO quests(quest_name, quest_flavor) ".
                     "VALUES(?, ?)";
            $conn->Execute($query, array($quest_name, $quest_flavor));
            echo $conn->ErrorMsg();
        }
    }
?>
