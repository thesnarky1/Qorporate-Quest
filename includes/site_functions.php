<?php

    /*
      Site functions file
      Includes any functions or variables needed to actually display the site
    */

    //Renders everything up until the actual body of the page
    function render_header() {
        echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'\n";
        echo "'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>\n";
        echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>\n";
        echo "<head>\n";
        echo "<meta http-equiv='Content-Type' content='text/html;charset=utf-8' />";
        echo "<title>Qorporate Quest - QQ moar, intern</title>\n";
        echo "</head>\n";
        echo "<body>\n";
    }
   

    //Renders everything in the footer
    function render_footer() {
        echo "</body>\n";
        echo "</html>\n";
    }
    
?>
