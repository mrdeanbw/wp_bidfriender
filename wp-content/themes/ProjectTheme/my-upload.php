<?php
/*
 * jQuery File Upload Plugin PHP Example 5.2.2
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 */

session_start();

class UploadHandlerMan_auction_theme
{
    private $options;
    
    function __construct($options=null) {
    	
		
	$uploads = wp_upload_dir();
	if(!file_exists($uploads['path']))
		mkdir($uploads['path'],777);


		
		
        $this->options = array(
            'script_url' => $_SERVER['PHP_SELF'],
            'upload_dir' => $uploads['path']."/",
            'upload_url' => $uploads['url']."/",
            'param_name' => 'files',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            'max_number_of_files' => null,
            'discard_aborted_uploads' => true,
            'image_versions' => array(
                // Uncomment the following version to restrict the size of
                // uploaded images. You can also add additional versions with
                // their own upload directories:
                /*
                'large' => array(
                    'upload_dir' => dirname(__FILE__).'/files/',
                    'upload_url' => dirname($_SERVER['PHP_SELF']).'/files/',
                    'max_width' => 1920,
                    'max_height' => 1200
                ),
                */
               /* 'thumbnail' => array(
                    'upload_dir' => dirname(__FILE__).'/thumbnails/',
                    'upload_url' => dirname($_SERVER['PHP_SELF']).'/thumbnails/',
                    'max_width' => 80,
                    'max_height' => 80
                )*/
            )
        );
        if ($options) {
            $this->options = array_merge_recursive($this->options, $options);
        }
    }
    
    private function get_file_object($pid) {
     
 
		$post = get_post($pid);
        
        
            $file = new stdClass();
            $file->name = $post->post_title;
            $file->size = filesize($file_path);
            $file->url = ProjectTheme_generate_thumb(wp_get_attachment_url($pid),70,70);
			$file->{'thumbnail_url'} = ProjectTheme_generate_thumb(wp_get_attachment_url($pid),70,70);
           
            $file->delete_url = home_url()."/?_ad_delete_pid=".$pid;
            $file->delete_type = 'DELETE';
            return $file;
     
    }
    
    private function get_file_objects() {
        	
			$pid = $_GET['pid'];
			
	$args = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => -1,
	); $arr = array();
	$attachments = get_posts($args); 
	if ($attachments) {
	    foreach ($attachments as $attachment) {
		array_push($arr,$attachment->ID);
	}
	}
			
        return array_values(array_filter(array_map(
            array($this, 'get_file_object'),
            $arr
        )));
    }

    private function create_scaled_image($file_name, $options) {
        $file_path = $this->options['upload_dir'].$file_name;
        $new_file_path = $options['upload_dir'].$file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
            $options['max_width'] / $img_width,
            $options['max_height'] / $img_height
        );
        if ($scale > 1) {
            $scale = 1;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                break;
            case 'gif':
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                break;
            case 'png':
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                break;
            default:
                $src_img = $image_method = null;
        }
        $success = $src_img && @imagecopyresampled(
            $new_img,
            $src_img,
            0, 0, 0, 0,
            $new_width,
            $new_height,
            $img_width,
            $img_height
        ) && $write_image($new_img, $new_file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }
    
    private function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
            ) {
            return 'maxFileSize';
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
            ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }
    
	private function count_the_number_pics($pid)
	{
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
		return count($attachments);
	
	}
	
		function multiple(array $_files, $top = TRUE)
	{
    	
		$new_array = array();
		
		$new_array['name'] = $_files['name'][0];
		$new_array['type'] = $_files['type'][0];
		$new_array['tmp_name'] = $_files['tmp_name'][0];
		$new_array['error'] = $_files['error'][0];
		$new_array['size'] = $_files['size'][0];


    	return $new_array;
	}
	
	
    private function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();

		
		$pid = $_POST['pid'];
		$cid = $_POST['cid'];
		session_start();
		
		if(isset($_SESSION['sitemile_max_picture_number'])):
		
			$nr = $_SESSION['sitemile_max_picture_number'];
			$cnt = $this->count_the_number_pics($pid);
			
			if($nr < ($cnt+1)): 
			
			$file->error = 'maxNumberOfFiles';
			return $file;
			
			endif;
		
		endif;
		
		
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	  
	  
	  	$new_FILES = $this->multiple($_FILES['files']);
	  
	  				$upload_overrides 	= array( 'test_form' => false );
                    $uploaded_file 		= wp_handle_upload($new_FILES, $upload_overrides);

					$file->url 	=  $uploaded_file;
			
					
						$file_name_and_location = $uploaded_file['file'];
                    	$file_title_for_media_library = $new_FILES['name'];
						
						$arr_file_type 		= wp_check_filetype(basename($new_FILES['name']));
                    	$uploaded_file_type = $arr_file_type['type'];

						 $file_size = $new_FILES['size'];
						
						$attachment = array(
                                'post_mime_type' => $uploaded_file_type,
                                'post_title' => 'Uploaded image ' . addslashes($file_title_for_media_library),
                                'post_content' => '',
                                'post_status' => 'inherit',

								'post_author' => $cid,
                            );
						 require_once(ABSPATH . "wp-admin" . '/includes/image.php');
						$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, $pid );
                       
                        $attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
                        wp_update_attachment_metadata($attach_id,  $attach_data);

						$go = ProjectTheme_generate_thumb(wp_get_attachment_url($attach_id),70,70);
					
						$file->id 	= $attach_id;
						$file->url 	= wp_get_attachment_url($attach_id);
					
	  					$file->size 		= $new_FILES['size'];
            			$file->delete_url 	= home_url()."/?_ad_delete_pid=".$attach_id;
            			$file->delete_type 	= 'DELETE';
						$file->name		 	= $new_FILES['name'];
	  					$file->type 			= $new_FILES['type'];
						 $file->thumbnail_url = $go;
		
        return $file;
    }
    
    public function get() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null; 
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }
    
    public function post() {
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : array(
                'tmp_name' => null,
                'name' => null,
                'size' => null,
                'type' => null,
                'error' => null
            );
        $info = array();
        if (is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index]
                );
            }
        } else {
            $info[] = $this->handle_file_upload(
                $upload['tmp_name'],
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'],
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'],
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'],
                $upload['error']
            );
        }
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        $json =  json_encode($info);
	
		echo $json;    
}
    
    public function delete() {
        $file_name = isset($_REQUEST['file']) ?
            basename(stripslashes($_REQUEST['file'])) : null;
        $file_path = $this->options['upload_dir'].$file_name;
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            foreach($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'].$file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }
}


if(isset($_GET['_ad_delete_pid']))
{
	if(is_user_logged_in())
	{
		
		wp_delete_post($_GET['_ad_delete_pid']);	
		
	}
	exit;	
}


//-------------------------------------------------------------


if(isset($_GET['uploady_thing']))
{

		
	
$upload_handler = new UploadHandlerMan_auction_theme();

header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('Content-Disposition: inline; filename="files.json"');



switch ($_SERVER['REQUEST_METHOD']) {
    case 'HEAD':
    case 'GET':
        $upload_handler->get();
        break;
    case 'POST':
		
        $upload_handler->post();
        break;
    case 'DELETE':
        $upload_handler->delete();
        break;
    default:
        header('HTTP/1.0 405 Method Not Allowed');
		
	
}
	exit;
}
?>