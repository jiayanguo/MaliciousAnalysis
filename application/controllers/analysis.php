<?php 
	system("/bin/bash ./execute",$yasca);
	$file_name=date('Y-m-d H:i:s').".html";
	echo $file_name;
	$file_path="../../result/".$file_name;
	copy ("../../yasca/Result/AnalysisResult.html",  "../../result/".$file_name) or die( "No result" );
	
?>



    <html>
    <head>
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=gb2312">
    <title>Analysis Result</title>
    </head>
    <body>
	<script language="javascript" type="text/javascript"> 
	alert("See the Analysis result!");
        setTimeout("javascript:location.href='<?php echo $file_path;?>'", 1000); 
    	</script>
    </body>
    </html>  

