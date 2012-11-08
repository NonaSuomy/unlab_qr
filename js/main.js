$(function() {
	$("#qrGeneratorForm").submit(function(){
		var qTerm   	= $("#qTerm").val();
		var scale   	= $("#scale").val();
		var size    	= $("#size").val();
		var qrscale 	= $("#qrscale").val();
		var version 	= $("#version_selector option:selected").val();
		var urlString   = "";
		switch (version)
		{
			case "local":
				urlString = "new_create.php";
				break;

			case "google":
			default:
				urlString = "create.php";
		}

		jQuery.get('../' + urlString, {q: qTerm, logoScale: scale, qrSize: size, qrScale: qrscale}, function(data, textStatus, xhr) {
			$("#imgBox").attr("src", data);
			$("#url").val(data);
			$("#resultCNT").fadeIn();
		});
		return false;
	});

	$("#url").click(function(){
		$(this).select();
	});
});