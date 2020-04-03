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
	

	
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	  

	  
	  				$upload_overrides 	= array( 'test_form' => false );
                    $uploaded_file 		= wp_handle_upload($_FILES['Filedata'], $upload_overrides);


					
						$file_name_and_location = $uploaded_file['file'];
                    	$file_title_for_media_library = $_FILES['Filedata']['name'];
						
						$arr_file_type 		= wp_check_filetype(basename($_FILES['Filedata']['name']));
                    	$uploaded_file_type = $arr_file_type['type'];

		
						
						$attachment = array(
                                'post_mime_type' => $uploaded_file_type,
                                'post_title' => 'Uploaded image ' . addslashes($file_title_for_media_library),
                                'post_content' => '',
                                'post_status' => 'inherit',
								'post_parent' =>  0,

								'post_author' => $cid,
                            );
						 require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, $pid );
                       
                        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
                        wp_update_attachment_metadata($attach_id,  $attach_data);

						$go = ProjectTheme_generate_thumb(wp_get_attachment_url($attach_id),70,70);
						update_post_meta($attach_id, 'is_portfolio', "1");

	//print_r($targetFile); echo "|"."a";
	echo $go."|".$attach_id; //$uploads['url']."/".$xx;
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