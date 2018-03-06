function moveMenuSelector(menuItem) {
	var offset = menuItem.offset();

	$("#menuselector").width(menuItem.width());
	$("#menuselector").offset(offset);

	$("nav ul li").find("a").css("color", "#337ab7");

	menuItem.find("a").css("color", "white");
}

$(document).ready(function() {
	$("#menuselector").height($("#menuselector").parent().height());

	$("nav ul li").mouseenter(function() {
		moveMenuSelector($(this));
	});

	$("nav ul li").mouseleave(function() {
		moveMenuSelector($(".active"));
	});

	moveMenuSelector($(".active"));
});
