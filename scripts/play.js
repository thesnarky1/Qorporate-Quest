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
