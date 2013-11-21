<?php 
function unzip_file($file, $destination){
	// create object
	$zip = new ZipArchive() ;
	// open archive
	if ($zip->open($file) !== TRUE) {
		die ('Could not open archive');
	}
	// extract contents to destination directory
	$zip->extractTo($destination);
	// close archive
	$zip->close();
	echo 'Archive extracted to directory';
}
?>

<?php
function del_dir( $dir )
{
   if ( $handle = opendir( "$dir" ) )
   {
     while ( false !== ( $item = readdir( $handle ) ) )
     {
       if ( $item != "." && $item != ".." )
       {
         if ( is_dir( "$dir/$item" ) )
         {
           del_dir( "$dir/$item" );
         }
         else
         {
           unlink( "$dir/$item" ) ;
         }
       }
     }
     closedir( $handle );
     rmdir( $dir ) ;

   }
}
?>

<?php   

  if( $_FILES['file']['name'] != '' )
  {
      copy ( $_FILES['file']['tmp_name'],  "../../upload/" . $_FILES['file']['name'] ) or die( "Could not copy file" );
      del_dir("G:/yasca/resources/test/");
      unzip_file("../../upload/".$_FILES['file']['name'], "G:/yasca/resources/test/");
  }
   else
   {

      die( "No file specified" );
   }
   
//   	system("cmd /c execute.bat",$yasca);

?>



<html>

 <head>
  <title>Upload complete</title>
 </head>

 <body>

  <h3>File upload succeeded...</h3>
  <ul>
  <li>Sent: <?php echo $_FILES['file']['name']; ?></li>
  <li>Size: <?php echo $_FILES['file']['size']; ?> bytes</li>
  <li>Type: <?php echo $_FILES['file']['type']; ?></li>
  </ul>
  <a href="analysis.php">
  <button type="button" >Analysis </button>
  </a>

 </body>

</html>