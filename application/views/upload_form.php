<!DOCTYPE HTML>
<html>
	<head>
		<title>Static Analysis Tool</title>
		<!--<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8">-->
		<style type="text/css">
			body {
			background: -webkit-linear-gradient(top, #b0e0e6, #9370db);
			}
			div.bg{
				width: 100%;
				height: 100%;
			}
			img#bgPicture {
				display: block;
				margin-right:50px;
				margin-left:50px;
				margin-bottom:150px;
				width:  92%; 
				height: 80%;
			}
			div.input{
				position:absolute; 
				top:300px;  
				left:275px;
				color: #da70d6;
			}
			#file {
				color: #006400
			}
			#submit{ 
				color: #20b2aa
			}
			h1{
				color: #8a2be2;
				font-family:"Times New Roman",Times,serif;
				font-style:italic;
				font-size:40px;
				text-transform: capitalize;
				text-align:center;
			}
		</style>
	</head>
	<body>
		<h1>Static Analyzer</h1>
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