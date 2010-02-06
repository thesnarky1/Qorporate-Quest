function swap_text(final_div, initial_div) {
    var content = $(initial_div).html();
    var final_div_inner = final_div + " > p";
    $(final_div_inner).html(content);
}

//Clears the text and hides the given div
function clear_text(final_div) {
    $(final_div).css("display", "none");
    $(final_div).html("");
}
