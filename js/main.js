
$(function() {
	var myurl = "http://www.bytenight.de/gd/";
	$("#qrGeneratorForm").submit(function(){
		var qTerm = $("#qTerm").val();
		var scale  = $("#scale").val();
		var size  = $("#size").val();
		jQuery.get('create.php', {q: qTerm, sa: scale, si: size}, function(data, textStatus, xhr) {
			$("#imgBox").attr("src", data);
			$("#url").val(myurl + data);
			$("#resultCNT").fadeIn();
		});
		return false;
	});

	$("#url").click(function(){
		$(this).select();
	});
});


