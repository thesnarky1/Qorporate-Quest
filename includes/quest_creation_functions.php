<?php

    //Mapping of variable to item list
    $replacements = array();

    //Food items
    $foods = array("morning coffee",
                   "bagel",
                   "Mike and Ikes",
                   "ham sammich",
                   "lunch platter",
                   "energy drink",
                   "caviar",
                   "peanuts",
                   "protein bar");
    $replacements["(FOOD)"] = $foods;

    //Reports
    $reports = array("Annual Annuity report",
                     "TPS report",
                     "budget",
                     "focus group feedback report",
                     "Standard Form A");
    $replacements["(REPORT)"] = $reports;

    //Office items
    $office_items = array("Red Swingline Stapler",
                          "Sharpie marker",
                          "three-hole punch",
                          "binder",
                          "toner cartridge",
                          "picture frame",
                          "mouse pad",
                          "calendar",
                          "pens",
                          "pencils",
                          "CD-ROM",
                          "power cable");
    $replacements["(OFFICE)"] = $office_items;

    $quest_supertypes = array(
                          array("Fetch the (OFFICE)",
                                "Apparently SOMEONE can't be bothered to go to the supply closet for their (OFFICE)... someone call in the intern."),
                          array("Go for the (FOOD)",
                                "That snobby accountant can't be bothered to fetch his own (FOOD)? Yea, sure, I'll 'step on it'..."),
                          array("Compile the (REPORT)",
                                "Only danger you'll face here is death from boredom... and I thought cruel and unusual punishment was illegal."),
                          array("Undermine your coworker",
                                "Its promotion time and the boss is walking around. Might as well steal your cubemate's (OFFICE) to get an edge, huh?")
                        );

    //Function generates a quest based on our supertypes
    function generate_quest() {
        global $quest_supertypes; 

        $quest = get_random_element($quest_supertypes);
        $quest_name = $quest[0];
        $quest_flavor = $quest[1];
        $finished_quest = replace_variables(array($quest_name, $quest_flavor));
        echo "$finished_quest[0]\n$finished_quest[1]\n";
    }

    function generate_quest_for_character($char_id) {
        global $conn;

        $query = "SELECT quest_id ".
                 "FROM quests ORDER BY RAND()";
        $result = $conn->GetOne($query);
        if($result) {
            $query = "INSERT INTO adventures(adventure_experience, quest_id, character_id) ".
                     "VALUES('10', $result, $char_id)";
            $conn->Execute($query);
        }
    }

    function generate_quests_for_character($char_id, $num) {
        while($num > 0) {
            generate_quest_for_character($char_id);
            $num--;
        }
    }

    //Function to get a random element of an array
    function get_random_element($arr) {
        $index = array_rand($arr);
        return $arr[$index];
    }

    //Function to replace all our replacement variables
    function replace_variables($str_arr) {
        global $foods, $reports, $office_items, $replacements;

        //Initialize scoped vars
        $my_replacements = array();
        $to_return = array();

        foreach($str_arr as $str) {
            foreach($replacements as $var=>$arr) {
                if(strpos($str, $var) !== false) {
                    $replacement = false;

                    //Obtain replacement - first check if we have one recorded
                    if(!isset($my_replacements[$var])) {
                        $replacement = get_random_element($arr);
                        $my_replacements[$var] = $replacement;
                    } else {
                        $replacement = $my_replacements[$var];
                    }

                    //Do the replacement
                    $str = str_replace($var, $replacement, $str);
                }
            }
            $to_return[] = $str;
        }
        return $to_return;
    }
?>
