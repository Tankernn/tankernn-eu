function display_message(message, type="info") {
	if ($(".alert-wrapper").is(":empty")) {
		var flag = true;
	}

	$(".alert-wrapper").html("<div class='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+message+"</div>");
	$(".alert").addClass("alert-" + type);

	if (flag) {
		$(".alert").css('display', 'none');
	}

	if ($(".alert").css("display") == "none")
		$(".alert").slideToggle();
}

var updateSelect = function() {
	if ($("#typeselect").val() == "page") {
		$("#linkselect").css("display", "none");
		$("#linkselect input").attr("name", "inactive");
		$("#pageselect").css("display", "table");
		$("#pageselect select").attr("name", "value");
	} else if ($("#typeselect").val() == "link") {
		$("#linkselect").css("display", "table");
		$("#linkselect input").attr("name", "value");
		$("#pageselect").css("display", "none");
		$("#pageselect select").attr("name", "inactive");
	}
}

$(document).ready(function(){
	$("#typeselect").change(function(){
		updateSelect();
	});
	$('[data-toggle="tooltip"]').tooltip();
});

$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});
