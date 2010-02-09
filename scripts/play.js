var my_char_id = null;
var my_timeout = null;
var my_curr_task = null;

$(document).ready(function() {
    my_char_id = $('#char_id_hidden').html();
    pick_next_task();

    if($('#creation_form')) {
        $('#bad_hack_i_hate_javascript').bind('click', function() {
                                                                      validate_creation_form(); 
                                                                  });
        $('#creation_form').bind('submit', function(e) {
                                                e.preventDefault();
                                             });
    }

});

//Function to make sure our character creation form is valid
function validate_creation_form() {

    var char_name = $('#creation_char_name').val();
    var char_job = $('#creation_char_job').val();
    var char_dept = $('#creation_char_dept').val();
    var char_satis = $('#char_satisfaction').val();
    var char_comp = $('#char_competence').val();
    var char_brown = $('#char_brown_nosing').val();
    var char_loyal = $('#char_loyalty').val();

    char_name = $.trim(char_name);
    char_job = $.trim(char_job);
    char_dept = $.trim(char_dept);
    char_satis = $.trim(char_satis);
    char_comp = $.trim(char_comp);
    char_brown = $.trim(char_brown);
    char_loyal = $.trim(char_loyal);

    if(!char_name || char_name == "") {
        $('#char_creation_error').html("You must fill in a character name.");
    } else if(!char_job || char_job == "" || char_job == 0) {
        $('#char_creation_error').html("You must select a character job.");
    } else if(!char_dept || char_dept == "" || char_dept == 0) {
        $('#char_creation_error').html("You must select a character dept.");
    } else if(!char_brown || char_brown == "") {
        $('#char_creation_error').html("You must roll for brown nosing.");
    } else if(!char_satis || char_satis == "") {
        $('#char_creation_error').html("You must roll for satisfaction nosing.");
    } else if(!char_loyal || char_loyal == "") {
        $('#char_creation_error').html("You must roll for loyalty.");
    } else if(!char_comp || char_comp == "") {
        $('#char_creation_error').html("You must roll for competence.");
    } else {
        $('form').unbind('submit');
        $('form').submit();
    }
}

function finish_task(task_id) {
    $.post("tasks.php",
           { char_id: my_char_id, task_id: task_id },
            function(data) {
                display_data(data);
                pick_next_task();
            },
            "json"
    );
}

//Function to reroll our stats
function reroll_stats() {
    $('#reroll_button').attr('disabled', 'disabled');
    $.post("roll.php",
           { },
            function(data) {
                display_data(data);
                $('#reroll_button').removeAttr('disabled');
            },
            "json"
    );
    return false;
}

function display_data(data) {
    if(data) {
        if(data.return_value) {
            $('#char_messages').css('display', 'block').html(data.return_value);
        }
        if(data.quests) {
            $('#char_quests_div').html(data.quests);
            update_quests_left();
        }
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
        if(data.max_exp) {
            $('#max_exp').html(data.max_exp);
        }
        if(data.exp) {
            $('#current_exp').html(data.exp);
            var max_exp = $('#max_exp').html();
            var exp_percent = (data.exp / max_exp) * 100;
            $('#exp_progress_bar').progressbar('value', exp_percent);
        }
        if(data.roll_loyal) {
            $('#char_loyalty').val(data.roll_loyal);
        }
        if(data.roll_satis) {
            $('#char_satisfaction').val(data.roll_satis);
        }
        if(data.roll_brown) {
            $('#char_brown_nosing').val(data.roll_brown);
        }
        if(data.roll_comp) {
            $('#char_competence').val(data.roll_comp);
        }
    }
    my_timeout = window.setTimeout(function() {
                                     $('#char_messages').css('display', 'none');
                                     my_timeout = null;
                                   },
                                   20000
                                  );
}

function fetch_tasks() {
    $.post("tasks.php", 
        { char_id: my_char_id, curr_task: my_curr_task }, 
        function(data) {
            display_data(data);
        },
        "json"
    );
}

function do_task(div) {
    var current_quest = $("#char_quest_current_text");
    current_quest.html(div.html());
    var task_id = current_quest.children('#char_quest_single_head').children('div').html();
    if(current_quest.parent().css("display") != "block") {
        current_quest.parent().css("display", "block");
    }
    current_quest.children('#char_quest_single_body').css("display", "block");
    // busted effin code....
    //current_quest.children('#char_quest_single_head').unbind('click').bind('click', function(e) { e.preventDefault(); });
    div.remove();
    $('#task_progress_bar').progressbar('value', 0);
    $('#char_quest_current').children('h3').children('span').html("0% done");
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
        $('#task_progress_bar').progressbar('value', progress);
        $('#char_quest_current').children('h3').children('span').html(progress + "% done");
        window.setTimeout(function() {
                            work_on_task(task_id, progress);
                          },
                          1000
                          );
    }
}

function pick_next_task() {
    var next_task = $('#char_quests_div').children('#char_quest_single')[0];
    if(!next_task) {
        //Error out
        if(my_timeout) {
            window.clearTimeout(my_timeout);
        }
        $('#char_messages').css('display', 'block').html("<p class='error'>It seems your connection may have dropped, please reload the page and try again.</p>");
    } else {
        my_curr_task = $(next_task).children('div').children('#char_quest_single_id').html();
        //Keep going
        do_task($(next_task));

        //Check for enough tasks
        update_quests_left();
        if(quests_left() < 5) {
            fetch_tasks();
        }
    }
}

function quests_left() {
    return $('#char_quests_div').children().length;
}

function update_quests_left() {
    var quests_left = $('#char_quests_div').children().length;
    quests_left = "(" + quests_left + " left)";
    $('#char_tasks_remaining').html(quests_left);
}
