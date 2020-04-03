<?php

include 'paypal.class.php';


	global $wp_query, $wpdb, $current_user;
	$pid = $wp_query->query_vars['pid'];
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;
	$post = get_post($pid);

$action = $_GET['action'];
$business = trim(get_option('ProjectTheme_paypal_email'));
if(empty($business)) die('Error. Admin, please add your paypal email in backend!');

$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url

//--------------

	$ProjectTheme_paypal_enable_sdbx = get_option('ProjectTheme_paypal_enable_sdbx');
	if($ProjectTheme_paypal_enable_sdbx == "yes")
	$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';     // paypal url

//--------------

$this_script = home_url().'/?p_action=paypal_listing&pid='.$pid;

if(empty($action)) $action = 'process';   



switch ($action) {

    

   case 'process':      // Process and order...
		
			$features_not_paid = array();		
			$catid = ProjectTheme_get_project_primary_cat($pid);
			$ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);
			$payment_arr = array();
			
			//-----------------------------------
			
			$base_fee_paid 	= get_post_meta($pid, 'base_fee_paid', true);
			$base_fee 		= get_option('projectTheme_base_fee');
			
			$catid = ProjectTheme_get_project_primary_cat($pid);
			
			$custom_set = get_option('projectTheme_enable_custom_posting');
			if($custom_set == 'yes')
			{
				$base_fee = get_option('projectTheme_theme_custom_cat_'.$catid);
				if(empty($base_fee)) $base_fee = 0;		
			}
			
			//----------------------------------------------------------
			
			if($base_fee_paid != "1" && $base_fee > 0)
			{
				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost for base fee','ProjectTheme');
				$new_feature_arr[1] = $base_fee;	
				array_push($features_not_paid, $new_feature_arr);
				
				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'base_fee';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $base_fee;
				$my_small_arr['description'] 	= __('Base Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
				
			}
			
			//----------------------------------------------------------
			
				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'extra_img';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $ProjectTheme_get_images_cost_extra;
				$my_small_arr['description'] 	= __('Extra Images Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			
			
			//-------- Featured Project Check --------------------------
			
			
			$featured 		= get_post_meta($pid, 'featured', true);
			$featured_paid 	= get_post_meta($pid, 'featured_paid', true);
			$feat_charge 	= get_option('projectTheme_featured_fee');
			
			if($featured == "1" && $featured_paid != "1" && $feat_charge > 0)
			{
				$not_OK_to_just_publish = 1;
				
				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost to make project featured','ProjectTheme');
				$new_feature_arr[1] = $feat_charge;	
				array_push($features_not_paid, $new_feature_arr);
				
				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'feat_fee';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $feat_charge;
				$my_small_arr['description'] 	= __('Featured Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
				
			}
			
			//---------- Private Bids Check -----------------------------
			
			$private_bids 		= get_post_meta($pid, 'private_bids', true);
			$private_bids_paid 	= get_post_meta($pid, 'private_bids_paid', true);
			
			$projectTheme_sealed_bidding_fee = get_option('projectTheme_sealed_bidding_fee');
			if(!empty($projectTheme_sealed_bidding_fee))
			{
				$opt = get_post_meta($pid,'private_bids',true);
				if($opt == "0") $projectTheme_sealed_bidding_fee = 0;
			}
			
			
			if($private_bids == "1" && $private_bids_paid != "1" && $projectTheme_sealed_bidding_fee > 0)
			{
				$not_OK_to_just_publish = 1;	
				
				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost to add sealed bidding','ProjectTheme');
				$new_feature_arr[1] = $projectTheme_sealed_bidding_fee;	
				array_push($features_not_paid, $new_feature_arr);
				
				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'sealed_project';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $projectTheme_sealed_bidding_fee;
				$my_small_arr['description'] 	= __('Sealed Bidding Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}
			
			
			//---------- Hide Project Check -----------------------------
			
			$hide_project 		= get_post_meta($pid, 'hide_project', true);
			$hide_project_paid 	= get_post_meta($pid, 'hide_project_paid', true);
			
			$projectTheme_hide_project_fee = get_option('projectTheme_hide_project_fee');
			if(!empty($projectTheme_hide_project_fee))
			{
				$opt = get_post_meta($pid,'hide_project',true);
				if($opt == "0") $projectTheme_hide_project_fee = 0;
			}
			
			
			if($hide_project == "1" && $hide_project_paid != "1" && $projectTheme_hide_project_fee > 0)
			{
				$not_OK_to_just_publish = 1;
				
				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost to hide project from search engines','ProjectTheme');
				$new_feature_arr[1] = $projectTheme_hide_project_fee;	
				array_push($features_not_paid, $new_feature_arr);	
				
				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'hide_project';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $projectTheme_hide_project_fee;
				$my_small_arr['description'] 	= __('Hide Project From Search Engines Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}
			
			//---------------------
			
			$payment_arr = apply_filters('ProjectTheme_filter_payment_array', $payment_arr, $pid);
		
						
			$my_total = 0;
			foreach($payment_arr as $payment_item):
				if($payment_item['amount'] > 0):
					$my_total += $payment_item['amount'];
				endif;
			endforeach;			
			
			$my_total = apply_filters('ProjectTheme_filter_payment_total', $my_total, $pid);

//----------------------------------------------
	$additional_paypal = 0;
	$additional_paypal = apply_filters('ProjectTheme_filter_paypal_listing_additional', $additional_paypal, $pid);
	
	//$ProjectTheme_get_show_price = ProjectTheme_get_show_price($pid);
	$total = $my_total + $additional_paypal;
	
	$title_post = $post->post_title;
	$title_post = apply_filters('ProjectTheme_filter_paypal_listing_title', $title_post, $pid);
	  
//---------------------------------------------	
 
      //$p->add_field('business', 'sitemile@sitemile.com');
      $p->add_field('business', $business);
	  
	  $p->add_field('currency_code', get_option('ProjectTheme_currency'));
	  $p->add_field('return', $this_script.'&action=success');
      $p->add_field('cancel_return', $this_script.'&action=cancel');
      $p->add_field('notify_url', $this_script.'&action=ipn');
      $p->add_field('item_name', $title_post);
	  $p->add_field('custom', $pid.'|'.$uid.'|'.current_time('timestamp',0));
      $p->add_field('amount', ProjectTheme_formats_special($total,2));
	  $p->add_field('bn', 'SiteMile_SP'); 

      $p->submit_paypal_post(); // submit the fields to paypal

      break;

   case 'success':      // Order was successful...
	case 'ipn':
	

	
	if(isset($_POST['custom']))
	{

		$cust 					= $_POST['custom'];
		$cust 					= explode("|",$cust);
		
		$pid					= $cust[0];
		$uid					= $cust[1];
		$datemade 				= $cust[2];
		
		//--------------------------------------------
		
		update_post_meta($pid, "paid", 				"1");
		update_post_meta($pid, "closed", 			"0");
		ProjectTheme_mark_images_cost_extra($pid);
		//--------------------------------------------
		
		update_post_meta($pid, 'base_fee_paid', '1');
		
		$featured = get_post_meta($pid,'featured',true);	
		if($featured == "1") update_post_meta($pid, 'featured_paid', '1');
		
		$private_bids = get_post_meta($pid,'private_bids',true);	
		if($private_bids == "1" or $private_bids == "yes" ) update_post_meta($pid, 'private_bids_paid', '1');
		 
		$hide_project = get_post_meta($pid,'hide_project',true);	
		if($hide_project == "1" or $hide_project == "yes" ) update_post_meta($pid, 'hide_project_paid', '1');
		
		$ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);										
										
		$image_fee_paid = get_post_meta($pid, 'image_fee_paid', true);
		update_post_meta($pid, 'image_fee_paid', ($image_fee_paid + $ProjectTheme_get_images_cost_extra));
		
		//--------------------------------------------
		
		do_action('ProjectTheme_paypal_listing_response', $pid);
		
		$projectTheme_admin_approves_each_project = get_option('projectTheme_admin_approves_each_project');
		$paid_listing_date = get_post_meta($pid,'paid_listing_date_paypal' . $datemade,true);
		
		if(empty($paid_listing_date))
		{
			
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
			
			update_post_meta($pid, "paid_listing_date_paypal" .$datemade, current_time('timestamp',0));
		}
	}

	if(get_option('projectTheme_admin_approves_each_project') == 'yes')
	{
		if(ProjectTheme_using_permalinks())
		{
			wp_redirect(get_permalink(get_option('ProjectTheme_my_account_page_id')) . "?prj_not_approved=" . $pid);	
		}
		else
		{
			wp_redirect(get_permalink(get_option('ProjectTheme_my_account_page_id')) . "&prj_not_approved=" . $pid);	
		}
	}
	else	wp_redirect(get_permalink($pid));
   
   break;

   case 'cancel':       // Order was canceled...

	wp_redirect(home_url());

       break;
     



 }     

?>