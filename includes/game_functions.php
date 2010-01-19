<?php

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
