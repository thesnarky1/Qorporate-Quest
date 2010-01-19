function swap_text(final_div, initial_div) {
    var content = $(initial_div).html();
    final_div = final_div + " > p";
    $(final_div).html(content);
    $(final_div).css("display", "block");
}

//Clears the text and hides the given div
function clear_text(final_div) {
    $(final_div).css("display", "none");
    $(final_div).html("");
}
