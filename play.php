<?php

    include('includes/functions.php');

    render_header();

    if(!is_logged_in()) {
        echo "<p class='error'>";
        echo "Sorry, but if you want to have tons of fun and collate your weight in reports you'll have to <a href='login.php'>login</a> or <a href='register.php'>register</a> first!";
        echo "</p>\n";
        render_footer();
        die();
    }

    $user_id = get_logged_in_userid();
    $characters = get_characters($user_id);
  
    //Draw the sidebar, this will consist of a list of their characters to quickly switch
    echo "<div id='sidebar'>\n";
    echo "<h3>Characters</h3>\n";
    if(!$characters) {
        echo "You have no characters yet :(";
    } else {
        //Spit out characters
        echo "<ul>\n";
        foreach($characters as $character_row) {
            $character_name = $character_row['character_name'];
            $character_id = $character_row['character_id'];
            echo "<li><a href='play.php?char_id=$character_id'>$character_name</a></li>\n";
        }
        echo "<li><a href='play.php?create_char'>Create new character</a></li>\n";
        echo "</ul>\n";
    }
    echo "</div> <!-- end sidebar div -->\n";

    echo "<div id='main_text'>\n";
    if(isset($_REQUEST['create_char'])) {
        //Display new character form
        echo "<h3>Character Creation</h3>\n";
    } else {
        //Display game view
        echo "<h3>Game view</h3>\n";
    }
    echo "</div> <!-- end main_text div -->\n";

    render_footer();

?>
