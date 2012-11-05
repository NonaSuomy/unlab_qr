<?php
//This is the reader file

if ( isset($_FILES['file']) && !empty( $_FILES['file'] ) )
{
	//get the file
	//only accept images
	$types = array("image/jpg", "image/jpeg", "image/png", "image/gif", "image/pjpeg", "image/bmp");
	$file = $_FILES["file"];

	if ( in_array( $file["type"], $types ) )
	{
		$ch = curl_init();
		$data = array('f' => "@" . $file['tmp_name'], "full" => 1);
		curl_setopt($ch, CURLOPT_URL, 'http://zxing.org/w/decode');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		$return   = curl_exec($ch);
		$errmsg   = curl_error ( $ch );
		$header   = curl_getinfo ( $ch );
		$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );

		curl_close($ch);

		var_dump($return);
	}
}

?>


<html>
	<head>
		<title>QR Reader</title>
	</head>
	<body>

	<h2>Please choose your file to decode</h2>
	<form enctype="multipart/form-data" method="post">
		<p>
			<input name="file" size="50" type="file">&nbsp;<input type="submit">
			<input value="true" name="full" type="hidden"></p>
		</form>

	</body>
</html>