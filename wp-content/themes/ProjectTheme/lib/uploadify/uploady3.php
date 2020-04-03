<?php
error_reporting(0);
$cwd = getcwd();
$cwd = explode('wp-content',$cwd);

$cwd = $cwd[0];

include $cwd.'wp-config.php';

$tm = time();
$rnd = rand(0,199);



if (!empty($_FILES)) {

	$pid = $_POST['ID'];
	$cid = $_POST['author'];
	
	/*
	$args = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => -1,
	);
	$attachments = get_posts($args);
	if ($attachments) {	   
	   if(count($attachments) > get_option('ad_theme_pic_nr') - 1) { echo "NO"; exit; }
	}*/

	
	$namee = $_FILES['Filedata']['name'];
	$namee = str_replace(" ","-",$namee);
	
	$uploads = wp_upload_dir();
	if(!file_exists($uploads['path']))
		mkdir($uploads['path'],777);

	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$xx = $tm.$rnd."_".str_replace(" ","",$namee);
	$targetFile = $uploads['path'].'/'.$xx; // str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	// Uncomment the following line if you want to make the directory if it doesn't exist
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
	
	$id = ProjectTheme_insert_pic_media_lib($cid, $pid, $uploads['url'].'/'.$xx, $targetFile, $namee,'another_reserved1');
	
	
	//print_r($targetFile); echo "|"."a";
	echo $namee."|".$id; //$uploads['url']."/".$xx;
}


  			switch ($_FILES['Filedata']['error'])
				{  	case 0:
						$msg = "No Error";
						break;
					case 1:
           				$msg = "The file is bigger than this PHP installation allows";
           				break;
   					case 2:
           				$msg = "The file is bigger than this form allows";
           				break;
    				case 3:
           				$msg = "Only part of the file was uploaded";
           				break;
    				case 4:
          		 		$msg = "No file was uploaded";
           				break;
					case 6:
          		 		$msg = "Missing a temporary folder";
           				break;
    				case 7:
          		 		$msg = "Failed to write file to disk";
           				break;
    				case 8:
          		 		$msg = "File upload stopped by extension";
           				break;
 					default:
						$msg = "unknown error ".$_FILES['Filedata']['error'];
						break;
				}



?>
