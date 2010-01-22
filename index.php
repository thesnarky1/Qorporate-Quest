<?php

    include('includes/functions.php');

    render_header();

    echo "<div id='sidebar'>\n";
    echo "<div id='sidebar_stats'>\n";
    echo "<h3>Statistics</h3>\n";
    echo "<ul>\n";
    echo "<li>Users: 1</li>\n";
    echo "<li>Butt kicking: Infinite</li>\n";
    echo "</ul>\n";
    echo "</div> <!-- end sidebar_stats div -->\n";
    $rand_characters = get_random_characters(5);
    if($rand_characters) {
        echo "<div id='sidebar_stats'>\n";
        echo "<h3>Random Characters</h3>\n";
        echo "<ul>\n";
        foreach($rand_characters as $character_row) {
            $char_name = $character_row['character_name'];
            $char_id = $character_row['character_id'];
            echo "<li><a href='characters.php?char_id=$char_id'>$char_name</a></li>\n";
        }
        echo "</ul>\n";
        echo "</div> <!-- end sidebar_stats div -->\n";
    }
    $rand_characters = get_random_characters(5, "character_level DESC");
    if($rand_characters) {
        echo "<div id='sidebar_stats'>\n";
        echo "<h3>Top Characters</h3>\n";
        echo "<ul>\n";
        foreach($rand_characters as $character_row) {
            $char_name = $character_row['character_name'];
            $char_id = $character_row['character_id'];
            $char_level = $character_row['character_level'];
            echo "<li><a href='characters.php?char_id=$char_id'>$char_name ($char_level)</a></li>\n";
        }
        echo "</ul>\n";
        echo "</div> <!-- end sidebar_stats div -->\n";
    } else {
        echo $conn->ErrorMsg();
    }
    echo "</div> <!-- end sidebar div -->\n";

    echo "<div id='main_text'>\n";
    echo "<h1>&lt;Company Name&gt;</h1>\n";
    echo "<p>";
    echo "Welcome to &lt;Company Name&gt; where we live for our employees! Or is it our employees die for us? I can't remember. ";
    echo "Your goal while employed at &lt;Company Name&gt; is to pursue your career goals, have fun, and most importantly, slave at your desk for 15 hours a day to make sure the TPS reports get out on time!";
    echo "</p>\n";
    echo "</div> <!-- end main_text div -->\n";

    render_footer();

?>
