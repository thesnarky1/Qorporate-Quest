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
    div.remove();
}

function pick_next_task() {
    do_task($($('#char_quests_div').children('#char_quest_single')[0]));
}
