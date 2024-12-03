<?php 
//header("Content-Type: application/octet-stream"); 
//header("content-type: application/pdf");
header("content-type: application/pdf");
readfile(base_url() . 'media/lpj/'.$url);

?>
