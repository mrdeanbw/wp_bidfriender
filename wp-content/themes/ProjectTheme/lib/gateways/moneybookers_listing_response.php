<?php

if($_POST['status'] > -1)
{
		
		$c  	= $_POST['field1'];
		$c 		= explode('|',$c);
		
		$pid				= $c[0];
		$uid				= $c[1];
		$datemade 			= $c[2];		
		
		//---------------------------------------------------

			global $wpdb;
			$pref = $wpdb->prefix;
		
			//--------------------------------------------
		
			update_post_meta($pid, "paid", 				"1");
			update_post_meta($pid, "paid_listing_date", current_time('timestamp',0));
			update_post_meta($pid, "closed", 			"0");
			ProjectTheme_mark_images_cost_extra($pid);
			
			//--------------------------------------------
			
			update_post_meta($pid, 'base_fee_paid', '1');
			
			$featured = get_post_meta($pid,'featured',true);	
			if($featured == "1" or $featured == "yes") update_post_meta($pid, 'featured_paid', '1');
			
			$private_bids = get_post_meta($pid,'private_bids',true);	
			if($private_bids == "1" or $private_bids == "yes") update_post_meta($pid, 'private_bids_paid', '1');
			 
			$hide_project = get_post_meta($pid,'hide_project',true);	
			if($hide_project == "1" or $hide_project == "yes" ) update_post_meta($pid, 'hide_project_paid', '1');
			
			$ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);										
										
			$image_fee_paid = get_post_meta($pid, 'image_fee_paid', true);
			update_post_meta($pid, 'image_fee_paid', ($image_fee_paid + $ProjectTheme_get_images_cost_extra));
			
			//--------------------------------------------
			do_action('ProjectTheme_moneybookers_listing_response', $pid);
			
			$projectTheme_admin_approves_each_project = get_option('projectTheme_admin_approves_each_project');
			
			if($projectTheme_admin_approves_each_project != "yes")
			{
				wp_publish_post( $pid );	
				$xx = current_time('timestamp',0);
												$post_pr_new_date = date('Y-m-d H:i:s',$xx);  
												$gmt = get_gmt_from_date($xx);
												
												$post_pr_info = array(  "ID" 	=> $pid,
												  "post_date" 				=> $post_pr_new_date,
												  "post_date_gmt" 			=> $gmt,
												  "post_status" 			=> "publish"	);
				
				wp_update_post($post_pr_info);
				
				ProjectTheme_send_email_posted_project_approved($pid);
				ProjectTheme_send_email_posted_project_approved_admin($pid);
			
			}
			else 
			{  
				
				ProjectTheme_send_email_posted_project_not_approved($pid);
				ProjectTheme_send_email_posted_project_not_approved_admin($pid);
					
				ProjectTheme_send_email_subscription($pid);	
				
			}
			
			//---------------------------
}
	
?>