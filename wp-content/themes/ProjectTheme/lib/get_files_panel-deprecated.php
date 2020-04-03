<?php

	global $wpdb,$wp_rewrite,$wp_query;
	$pid = $_GET['get_files_panel'];
	$uid = $_GET['uid'];
	
	
	global $current_user;
	$current_user = wp_get_current_user();
	$cid = $current_user->ID;
	
	$post = get_post($pid);
	
?>

	<div class="box_title"><?php echo sprintf(__("Files Uploaded: %s",'ProjectTheme'), $post->post_title ); ?></div>
  	<div class="bid_panel" style="width:550px;height:450px">
                <div class="padd10">
                
                
                 <?php


	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'post_author'    => $uid,
	'meta_key'		 => 'is_bidding_file',
	'meta_value'	 => '1',
	'numberposts'    => -1,
	'post_status'    => null,
	);
	$attachments = get_posts($args);
	
	$vv1 = 0;
	
	if ($attachments) {
	    foreach ($attachments as $attachment) {
		$url = $attachment->post_title;
		$imggg = $attachment->post_mime_type; 
		
			if($attachment->post_author == $uid){
	
			echo '<div class="div_div"  id="image_ss'.$attachment->ID.'"><a target="_blank" href="'.wp_get_attachment_url($attachment->ID).'">'.$url.'</a>
			</div>';
				$vv1++;
			}
	  
	}
	} 
	
	if($vv1 == 0) { _e("There are no files attached.","ProjectTheme"); }


	?>
                
                </div>
                </div>