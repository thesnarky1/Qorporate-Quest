$(document).ready(function() {
    if($('#register_form')) {
        $('input[type=submit]').bind('click', function(e) {
                                                  validate_registration_form();
                                              });
        $('#register_form').bind('submit', function(e) {
                                                           e.preventDefault();
                                                       });
    }
});

function swap_text(final_div, initial_div) {
    var content = $(initial_div).html();
    var final_div_inner = final_div + " > p";
    $(final_div_inner).html(content);
}

function toggle_my_p(div) {
    div = $(div).parent().children("#char_quest_single_body");
    var curr_display = div.css("display");
    if(curr_display == "block") {
        //hide it
        div.css("display", "none");
    } else {
        //show it
        div.css("display", "block");
    }
}

//Function to swap a boss's information from the hidden fields in the quest to the sidebar
function swap_boss(link) {
    
    var footer_div = $(link).parent().parent().parent();
    var boss_div = footer_div.children('#char_single_quest_boss');
    var boss_name = boss_div.children('#boss_name').html();
    var boss_experience = boss_div.children('#boss_experience').html();
    var boss_flavor = boss_div.children('#boss_flavor').html();

    var boss_sidebar = $('#sidebar_boss');
    boss_sidebar.children('#boss_name').html(boss_name);
    boss_sidebar.children('#boss_experience').html(boss_experience);
    boss_sidebar.children('#boss_flavor').html(boss_flavor);

    if(boss_sidebar.css('display') == 'none') {
        boss_sidebar.css('display', 'block');
    }
}

//Clears the text and hides the given div
function clear_text(final_div) {
    $(final_div).css("display", "none");
    $(final_div).html("");
}

//Function to validate the registration form
function validate_registration_form() {
    var user_name = $('#register_user_name').val();
    var user_email = $('#register_user_email').val();
    var user_pass = $('#register_user_pass').val();
    var user_pass2 = $('#register_user_pass2').val();

    user_name = $.trim(user_name);
    user_email = $.trim(user_email);
    user_pass = $.trim(user_pass);
    user_pass2 = $.trim(user_pass2);

    if(!user_name || user_name == "") {
        $('#register_error').css('display', 'block').html("You must fill in a username.");
    } else if(!user_email || user_email == "") {
        $('#register_error').css('display', 'block').html("You must fill in an email.");
    } else if(!user_pass || user_pass == "") {
        $('#register_error').css('display', 'block').html("You must fill in a password.");
    } else if(!user_pass2 || user_pass2 == "" || user_pass2 != user_pass) {
        $('#register_error').css('display', 'block').html("You must fill in the same password twice.");
    } else {
        alert("Good to go");
        $('#register_form').unbind('submit');
        $('#register_form').submit();
    }
}
