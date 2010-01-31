var my_char_id = null;


$(document).ready(function() {
    my_char_id = $('#char_id_hidden').html();
    pick_next_task();
});

function fetch_tasks() {
    $.post("tasks.php", 
        { char_id: my_char_id }, 
        function(data) {
            display_tasks(data);
        },
        "json"
    );
}

function display_tasks(data) {
    $('#char_quests_div').html(data.return_value);
}

function toggle_my_p(div) {
    div = $(div).parent().children("p");
    var curr_display = div.css("display");
    if(curr_display == "block") {
        //hide it
        div.css("display", "none");
    } else {
        //show it
        div.css("display", "block");
    }
}

function do_task(div) {
    var current_quest = $("#char_quest_current_text");
    current_quest.html(div.html());
    if(current_quest.parent().css("display") != "block") {
        current_quest.parent().css("display", "block");
    }
    // busted effin code....
    //current_quest.children('#div').children('#char_quest_single_head').click(function() { return false; });
    div.remove();
}

function pick_next_task() {
    do_task($($('#char_quests_div').children('#char_quest_single')[0]));
    //Start timer
    //Check for enough tasks
    if(quests_left() < 10) {
        fetch_tasks();
    }
}

function quests_left() {
    return $('#char_quests_div').children().length;
}
