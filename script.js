$(function() {

var current_fs, next_fs, previous_fs; 
var left, opacity, scale; 
var animating; 
$(".next").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	next_fs.css({ 'display': 'block', 'visibility': 'visible' });
	current_fs.css({ 'display': 'none' });
	animating = false; // End animation
	});


$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	previous_fs.css({ 'display': 'block', 'visibility': 'visible' });	
	current_fs.css({ 'display': 'none' });
	animating = false; // End animation
	});


	$(".submit").click(function() {
        // Show the loader
        $("#loading").show();

        // Make sure all fieldsets are visible before submission
        $("fieldset").css({ 'display': 'block', 'visibility': 'visible' });

        // Allow form submission
        return true;
    });

});