<!DOCTYPE HTML>
<html>
<head>
<title>Static Analysis Tool</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<h1>Static Analysis Tool<h1>
<div class="bg">
<img src="images/1.jpg" id="bgPicture" />	
</div>

<div class="input">
<form action="application/controllers/uploadfile.php" method="post" enctype="multipart/form-data">
<label for="file">File path:  </label>  
<!--<input type="file" name="file" size="25" value='<?php echo $__FILE__;?>' />-->
<input type="file" name="file" size="25"  />
<input type="submit"  value="Submit"/>
</form>
</div>

</body>
</html>