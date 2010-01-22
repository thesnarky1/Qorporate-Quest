<?php

    //Function attempts to create a character, if its is successful it returns the char_id, else false
    function create_character($char_name, $user_id, $job_id, $department_id) {
        //If we want to belay that
    }

    //Function takes a user_id and returns an array of all the characters that belong to them
    function get_characters($user_id, $ordering='character_name') {
        global $conn;

        $query = "SELECT * FROM characters WHERE user_id=? ".
                 "ORDER BY $ordering";
        $characters = $conn->GetAll($query, array($user_id));
        return $characters;
    }

    //Function returns an array containing all the departments in our database
    function get_departments() {
        global $conn;

        $query = "SELECT * FROM departments";
        $departments = $conn->GetAll($query);
        return $departments;
    }

    //Function returns an array containing all the jobs in our database
    function get_jobs() {
        global $conn;

        $query = "SELECT * FROM jobs";
        $jobs = $conn->GetAll($query);

        return $jobs;
    }

    //Function fetches information for a given amount of random characters
    function get_random_characters($num, $ordering="RAND()") {
        global $conn;

        $characters = false;
        $query = "SELECT * FROM characters ORDER BY $ordering LIMIT $num";
        $characters = $conn->GetAll($query);
        return $characters;
    }

    //Function takes a character_id and user_id and says if the user owns this character
    function user_owns_character($user_id, $character_id) {
        global $conn;

        $query = "SELECT character_id FROM characters ".
                 "WHERE character_id=? AND user_id=?";
        $result = $conn->Execute($query, array($character_id, $user_id));
        if($result->RecordCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

?>
