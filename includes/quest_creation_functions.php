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
                   "protein bar",
                   "ramen",
                   "vodka",
                   "Mountain Dew",
                   "tea");
    $replacements["(FOOD)"] = $foods;

    //Reports
    $reports = array("Annual Annuity report",
                     "TPS report",
                     "budget",
                     "focus group feedback report",
                     "financial audit",
                     "optimization report",
                     "time cards",
                     "expense reports",
                     "closing offer",
                     "network optimization plan",
                     "press release",
                     "damage assessment",
                     "yearly asset appraisal",
                     "Standard Form A");
    $replacements["(REPORT)"] = $reports;

    //Office items
    $office_items = array("Red Swingline Stapler",
                          "Sharpie marker",
                          "company credit card",
                          "three-hole punch",
                          "binder",
                          "toner cartridge",
                          "picture frame",
                          "mouse pad",
                          "calendar",
                          "pens",
                          "pencils",
                          "CD-ROM",
                          "power cable",
                          "lotion",
                          "framed picture",
                          "candle",
                          "sticky notes",
                          "index cards",
                          "letter opener",
                          "thumb tacks",
                          "dry erase marker",
                          "pencil cup",
                          "staple remover",
                          "hand gun",
                          "shot glasses",
                          "deodorant",
                          "notes",
                          "Kleenex",
                          "copy paper",
                          "paper clips",
                          "staples",
                          "punch cards",
                          "eraser",
                          "business cards");
    $replacements["(OFFICE)"] = $office_items;

    $computers = array("DEC",
                       "Apple IIE",
                       "Dell Inspiracrap",
                       "Proprietary expensive Apple",
                       "White box",
                       "Linux servers",
                       "Cisco router",
                       "Linksucks router",
                       "Ancient laptop",
                       "Cutting edge computer you're not allowed to touch",
                       "main frame",
                       "Compy 386",
                       "storage racks");
    $replacements["(COMPUTER)"] = $computers;

    $music = array("Journey",
                   "Classical",
                   "Strong Bad Techno",
                   "death metal",
                   "Gwen Stefanie",
                   "Apple proprietary files",
                   "techno",
                   "country",
                   "rock",
                   "pop",
                   "Top 40",
                   "Lonely Island Band",
                   "hard core nerd rap");
    $replacements["(MUSIC)"] = $music;

//    $bosses = array("Pointy Haired Boss",
//                    "CEO's Cousin",
//                    "Megalomaniac",
//                    "Tyrannical Millionaire",
//                    "Supervisor From Hell",
//                    "Last Competent Manager",
//                    "Burninator",
//                    "Power Suit Soccer Mom");
    $replacements["(BOSS)"] = $bosses;

    $quest_supertypes = array(
                          array("Fetch the (OFFICE)",
                                "Apparently SOMEONE can't be bothered to go to the supply closet for their (OFFICE)... call in the intern.",
                                "(OFFICE)"),
                          array("Go shopping for the (OFFICE)",
                                "As you walk out of Staples you vow that you'll shove an 'Easy' button so far up the boss that ordered you to go buy the new (OFFICE) he'll say 'That was easy' every time he sneezes.",
                                "(OFFICE)"),
                          array("Eat Lunch",
                                "As if your sad existence couldn't get any worse when you open your lunch you notice a co-worker ate it and replaced it with only (FOOD).",
                                "(FOOD)"),
                          array("Gopher the (FOOD)",
                                "That snobby accountant can't be bothered to fetch his own (FOOD)? Yea, sure, I'll 'step on it'...",
                                "(FOOD)"),
                          array("M-M-M-M-M-M-MONSTER SPILL",
                                "In order to get those blasted yearly reports out on time your boss has started to require all employees take their lunch at their desks. This would have been fine if he didn't also have a habit of back slapping for encouragement and insist on doing this JUST as you were setting down your (FOOD). Now its all over the report and your suit.. that's what I call a MONSTER SPILL.",
                                "(FOOD)"),
                          array("Clean up the (FOOD)",
                                "It was so lovely for the boss to bring in all the (FOOD) for the office party, and even nicer for him to leave early and let you clean it all up. Is it bringing back good memories of college as a pledge?",
                                "(FOOD)"),
                          array("Compile the (REPORT)",
                                "Only danger you'll face here is death from boredom... and I thought cruel and unusual punishment was illegal.",
                                "(REPORT)"),
                          array("Copy the (REPORT)",
                                "Nothing is more demeaning than standing at a copier all day Xeroxing your boss's party fliers other than the fact that you know you won't be invited. Oh, and I suppose the whole 'asking you to come in on Saturday to copy the (REPORT) and having it turn out to be party fliers' thing...",
                                "(REPORT)"),
                          array("Collate the (REPORT)",
                                "Do paper cuts count for workman's comp? No? Well its going to be a very long week then.",
                                "(REPORT)"),
                          array("Deliver the (REPORT)",
                                "You know the difference between you and a New York courier? A New York courier gets respect.",
                                "(REPORT)"),
                          array("Undermine your coworker",
                                "Its promotion time and the boss is walking around. Might as well steal your cubemate's (OFFICE) to get an edge, huh?",
                                "(OFFICE)"),
                          array("Visit the Lost and Found",
                                "Yes it seems silly to go to the Lost and Found office for just a small (OFFICE), but given that you're allocated only one trip to the supply closet a year its worth it.",
                                "(OFFICE)"),
                          array("Remove the (OFFICE)...",
                                "From your boss's skull. Ok, don't panic. You finally snapped and blacked out a bit and now the boss has the (OFFICE) in his brain. Let's just remove that, frame the guy in accounting who always plays with lighters, and go back to our miserable life.",
                                "(OFFICE)"),
                          array("Introduce yourself to the (BOSS)",
                                "Its funny, no matter how many times you introduce yourself to the (BOSS) he never seems to recognize you. Oh well, once more can't hurt.",
                                "(BOSS)"),
                          array("Turn off that infernal noise!",
                                "Thanks to the complaints of those pie-in-the-sky mailmen the boss is making you turn down your (MUSIC). Its a sad day, I know just how hard it is to crunch numbers without that soothing melody.",
                                "(MUSIC)"),
                          array("Fetch the Boss's (MUSIC)",
                                "What's worse than having to see the boss dance around his office like a schoolgirl in love to some (MUSIC)? Being the guy that has to fetch aforementioned (MUSIC) from Best Buy after work so the boss can have it on his desk in the morning. *sigh*",
                                "(MUSIC)"),
                          array("Set the mood with (MUSIC)",
                                "Its a lovely Friday evening, the lights are low and the cleaners have finished up. Its just you and the annual audit. Why don't you set the mood by whipping out your coveted (MUSIC) CDs and see what happens?",
                                "(MUSIC)"),
                          array("Kick the (COMPUTER)",
                                "Once again someone has to venture into the artic habitat of a data center, pushing through the penguins and polar bears to get to the (COMPUTER) that needs rebooting. Of course it being the summer all you have is shorts and a dress shirt so you better go quick or they'll find you in 500 years and thaw you for a museum somewhere.",
                                "(COMPUTER)"),
                          array("Steal the (COMPUTER)",
                                "Word on the street is that the evil 'fruit' company left a very valuable (COMPUTER) sitting around thta may have their new chip architecture on it. Of course, it might also only have Doom 95, but the bossman felt you should add 'Breaking and Entering' onto your resume and under job experience put '7-10'",
                                "(COMPUTER)"),
                          array("Work on Saturday",
                                "Someone needs to come in on Saturday to make sure the (REPORT) is, well, I don't know why exactly as no one else will be in. But either way, someone must be in or life will end. And that someone is you. Congrats.",
                                "(REPORT)"),
                          array("Suck up to the (BOSS)",
                                "Of course back in your ivy league education you swore you'd never stoop to pure flattery to get ahead. You felt it'd be a combination of your charm, your skill, and of course your career drive that would yield great benefits. Sadly, once again, you were mistaken and the (BOSS) is again proving that to you. Better play nice or you'll be back in the mail room in no time.",
                                "(BOSS)")
                        );


    //Function to pull all the bosses out of the database in one fell swoop
    function get_bosses() {
        global $conn;
    
        $query = "SELECT * FROM bosses";
        $bosses = $conn->GetAll($query);
        return $bosses;
    }
    
    //Function to pull a random quest out
    function generate_quest($boss) {
        global $quest_supertypes;
    
        $rand_quest = get_random_element($quest_supertypes);
        $boss_name = $boss['boss_name'];
        $boss_id = $boss['boss_id'];
        $boss_string = "<a href='bosses.php?boss_id=$boss_id'>$boss_name</a>";
        $boss_exp = $boss['boss_experience'];
    
        //Go through and replace all our variables.
        $rand_quest = replace_variables($rand_quest, $boss_string);
    
        $quest_to_insert = array();
        $quest_to_insert['name'] = $rand_quest[0];
        $quest_to_insert['flavor'] = $rand_quest[1];
        $quest_to_insert['experience'] = 10 + $boss_exp;
        $quest_to_insert['boss_id'] = $boss_id;
    
        //return the quest
        return $quest_to_insert;
    }
    
    //Function to spit out a given number of quests for a given character (insert them into the tasks table
    /*
     * Also a tasks table
     * task_id
     * task_name
     * task_flavor
     * task_experience
     * boss_id
     * character_id
     */
    function generate_quests($char_id, $num) {
        global $conn;
    
        $bosses = get_bosses();
        $index = 0;
        $tasks = array();
        while($index < $num) {
            $boss = get_random_element($bosses);
            $tasks[] = generate_quest($boss);
            $index++;
        }
   
        $arguments = array();
        $initial = true;
        $query = "INSERT INTO tasks(task_name, task_flavor, task_experience, boss_id, character_id) VALUES";
        foreach($tasks as $task) {
            $task_name = $task['name'];
            $task_flavor = $task['flavor'];
            $task_experience = $task['experience'];
            $boss_id = $task['boss_id'];
            
        	if(!$initial) {
                $query.= ",";
            } else {
                $initial = false;
            }
            $query .= "(?, ?, ?, ?, ?)";
            $arguments[] = $task_name;
            $arguments[] = $task_flavor;
            $arguments[] = $task_experience;
            $arguments[] = $boss_id;
            $arguments[] = $char_id;
        }
        $conn->Execute($query, $arguments);
        $error = $conn->ErrorMsg();
        if($error) {
            echo $error;
        }
    }

    //Function to get a random element of an array
    function get_random_element($arr) {
        $index = array_rand($arr);
        return $arr[$index];
    }


    //Function to replace all our replacement variables
    function replace_variables($str_arr, $boss_string) {
        global $replacements, $foods, $reports, $computers;

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

    //
    //
    //
    //  DEPRECATED
    //
    //
    //
    //


//    function generate_all_quests() {
//        global $quest_supertypes, $replacements;
//        $quests = array();
//        foreach($quest_supertypes as $quest_supertype) {
//            $variable = $quest_supertype[2];
//            $var_arr = $replacements[$variable];
//            foreach($var_arr as $var) {
//                //Now we have an iterator for getting each item to replace.
//                $quest_name = str_replace($variable, $var, $quest_supertype[0]);
//                $quest_flavor = str_replace($variable, $var, $quest_supertype[1]);
//                $quests[] = array($quest_name, $quest_flavor);
//            }
//        }
//        return $quests;
//    }
//
//
//    //Function generates a random quest based on our supertypes
//    function generate_quest() {
//        global $quest_supertypes; 
//
//        $quest = get_random_element($quest_supertypes);
//        $quest_name = $quest[0];
//        $quest_flavor = $quest[1];
//        $finished_quest = replace_variables(array($quest_name, $quest_flavor));
//        echo "$finished_quest[0]\n$finished_quest[1]\n";
//    }
//
//    function generate_quest_for_character($char_id) {
//        global $conn;
//
//        $query = "SELECT quest_id ".
//                 "FROM quests ORDER BY RAND()";
//        $result = $conn->GetOne($query);
//        if($result) {
//            $query = "INSERT INTO adventures(adventure_experience, quest_id, character_id) ".
//                     "VALUES('10', $result, $char_id)";
//            $conn->Execute($query);
//        }
//    }
//
//    function generate_quests_for_character($char_id, $num) {
//        while($num > 0) {
//            generate_quest_for_character($char_id);
//            $num--;
//        }
//    }
//
//?>
