<!DOCTYPE HTML>
<html>
	<head>
		<title>Static Analysis Tool</title>
		<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8">
	</head>
	<body>
		<div class="bg"><img src="images/1.jpg" id="bgPicture" /></div>
		<div class="input">
			<?php echo $error;?>
			<?php echo form_open_multipart('analysis');?>
			<!--<form action="application/controllers/uploadfile.php" method="post" enctype="multipart/form-data">-->
				<label for="file">Upload .zip file of code to be analyzed: </label>
				<input type="file" name="userfile" size="50" />
				<input type="submit" value="Upload" />
			</form>
		</div>
	</body>
</html>