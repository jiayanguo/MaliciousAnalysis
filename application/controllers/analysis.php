<?php 
	system("cmd /c execute.bat",$yasca);
	
	copy ("G:/yasca/Result/AnalysisResult.html",  "../../result/result.html") or die( "No result" );
	

?>



    <html>
    <head>
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=gb2312">
    <title>Analysis Result</title>
    </head>
    <body>
	<script language="javascript" type="text/javascript"> 

     setTimeout("javascript:location.href='../../result/result.html'", 1000); 

     </script>
    </body>
    </html>  

