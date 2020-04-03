<?php
 header("HTTP/1.1 200 OK");
if(!is_user_logged_in()) { echo "not_right"; exit; }

$tm = time();
$rnd = rand(0,199);



if (!empty($_FILES)) {

	$pid = $_POST['ID'];
	$cid = $_POST['authora'];
	
 
	
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	  

	  
	  				$upload_overrides 	= array( 'test_form' => false );
                    $uploaded_file 		= wp_handle_upload($_FILES['file'], $upload_overrides);


					
						$file_name_and_location = $uploaded_file['file'];
                    	$file_title_for_media_library = $_FILES['file']['name'];
						
						$arr_file_type 		= wp_check_filetype(basename($_FILES['file']['name']));
                    	$uploaded_file_type = $arr_file_type['type'];

		
						
						$attachment = array(
                                'post_mime_type' => $uploaded_file_type,
                                'post_title' =>  addslashes($file_title_for_media_library),
                                'post_content' => '',
                                'post_status' => 'inherit',
								'post_parent' =>  $pid,

								'post_author' => $cid,
                            );
						 require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, $pid );
                       
                        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
                        wp_update_attachment_metadata($attach_id,  $attach_data);

						 
					

	//print_r($targetFile); echo "|"."a";
	echo $attach_id; //$uploads['url']."/".$xx;
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
