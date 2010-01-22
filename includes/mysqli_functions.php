<?php

    /*
      PHP Database mucking module
      By Three Planets Software

      Include at a global level, assumes a mysqli object named $dbh at the global level
    */

    function mysqli_delete($query) {
        global $conn;

        $query = $conn->qstr($query);
        $result = $conn->Execute($query);
        if($result && $conn->Affected_Rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function mysqli_get_one($query) {
        global $conn;

        $query = $conn->qstr($query);
        $result = $conn->Execute($query);
        if($result && $conn->Affected_Rows() == 1) {
            $row = $result->FetchRow();
            return $row;
        } else {
            return false;
        }
    }

    function mysqli_get_many($query) {
        global $conn;

        $query = $conn->qstr($query, true);
        $result = $conn->Execute($query);
        if($result) {
            $to_return = array();
            while($row = $result->FetchRow()) {
                $to_return[] = $row;
            }
            return $to_return;
        }
        return false;
    }

    function mysqli_insert($query) {
        global $conn;

        $query = $conn->qstr($query);
        $result = $conn->Execute($query);
        if($result && $conn->Affected_Rows() == 1) {
            return $conn->Insert_Id();
        } else {
            return false;
        }
    }
    
    function mysqli_set_one($query) {
        global $conn;

        $query = $conn->qstr($query);
        $result = $conn->Execute($query);
        if($result && $conn->Affected_Rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function mysqli_set_many($query) {
        global $conn;

        $query = $conn->qstr($query);
        $result = $conn->Execute($query);
        if($result && $conn->Affected_Rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

?>
