<?php

    //Function takes a user_id and returns an array of all the characters that belong to them
    function get_characters($user_id, $ordering='character_name') {
        $query = "SELECT * FROM characters WHERE user_id='$user_id' ".
                 "ORDER BY $ordering";
        $characters = mysqli_get_many($query);
        return $characters;
    }

    //Function returns an array containing all the departments in our database
    function get_departments() {
        $query = "SELECT * FROM departments";
        $departments = mysqli_get_many($query);
        return $departments;
    }

    //Function returns an array containing all the jobs in our database
    function get_jobs() {
        $query = "SELECT * FROM jobs";
        $jobs = mysqli_get_many($query);
        return $jobs;
    }

    //Function fetches information for a given amount of random characters
    function get_random_characters($num, $ordering="RAND()") {
        $characters = false;
        $query = "SELECT * FROM characters ORDER BY $ordering LIMIT $num";
        $characters = mysqli_get_many($query);
        return $characters;
    }

?>
