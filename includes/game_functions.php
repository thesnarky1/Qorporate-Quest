<?php

    //Function returns an array containing all the jobs in our database
    function get_jobs() {
        $query = "SELECT * FROM jobs";
        $jobs = mysqli_get_many($query);
        return $jobs;
    }

    //Function returns an array containing all the departments in our database
    function get_departments() {
        $query = "SELECT * FROM departments";
        $departments = mysqli_get_many($query);
        return $departments;
    }

?>
