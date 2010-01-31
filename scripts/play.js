var my_char_id = null;


$(document).ready(function() {
    my_char_id = $('#char_id_hidden').html();
    pick_next_task();
});

function finish_task(task_id) {
    $.post("tasks.php",
           { char_id: my_char_id, quest_id: task_id },
            function(data) {
                display_experience(data);
                pick_next_task();
            },
            "json"
    );
}

function display_experience(data) {
    if(data) {
        $('#char_messages').css('display', 'block').html(data.return_value);
        if(data.level) {
            $('#char_level').html(data.level);
        }
        if(data.satisfaction) {
            $('#char_satisfaction').html(data.satisfaction);
        }
        if(data.brown_nosing) {
            $('#char_brown_nosing').html(data.brown_nosing);
        }
        if(data.competence) {
            $('#char_competence').html(data.competence);
        }
        if(data.loyalty) {
            $('#char_loyalty').html(data.loyalty);
        }
    }
    window.setTimeout(function() {
                        $('#char_messages').css('display', 'none');
                      },
                      20000
                      );
}

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
    var task_id = current_quest.children('div').children('div').html();
    if(current_quest.parent().css("display") != "block") {
        current_quest.parent().css("display", "block");
    }
    // busted effin code....
    //current_quest.children('#div').children('#char_quest_single_head').click(function() { return false; });
    div.remove();
    //Start timer
    window.setTimeout(function() {
                        work_on_task(task_id, 0);
                      },
                      1000
                      );
}

function work_on_task(task_id, progress) {
    if(progress >= 100) {
        finish_task(task_id);
    } else {
        progress += 5;
        $('#char_quest_current').children('h3').children('span').html(progress + "% done");
        window.setTimeout(function() {
                            work_on_task(task_id, progress);
                          },
                          1000
                          );
    }
}

function pick_next_task() {
    do_task($($('#char_quests_div').children('#char_quest_single')[0]));
    //Check for enough tasks
    if(quests_left() < 5) {
        fetch_tasks();
    }
}

function quests_left() {
    return $('#char_quests_div').children().length;
}
