<?php
session_start();
include 'paypal.class.php';

global $wp_query, $wpdb;
$pid = $wp_query->query_vars['pid'];

$action = $_GET['action'];


$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url

//---------------------

$ProjectTheme_paypal_enable_sdbx = get_option('ProjectTheme_paypal_enable_sdbx');
if($ProjectTheme_paypal_enable_sdbx == "yes")
$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';     // paypal url

//--------------------


$this_script = home_url().'/?p_action=pay_for_project_paypal&pid='.$pid;

$post = get_post($pid);

$bid 	= projectTheme_get_winner_bid($pid);

$paypal_email = get_user_meta($bid->uid, 'paypal_email', true);


if(empty($paypal_email)) { die('ERROR-DEBUG-> Missing Paypal Email of user.'); exit; }

if(empty($action)) $action = 'process';   

switch ($action) {


   case 'process':      // Process and order...
	

	$bid = projectTheme_get_winner_bid($pid);	
	$total = $bid->bid;
	  
//------------------------------------------------------

      $p->add_field('business', $paypal_email);
	  
	  $p->add_field('currency_code', get_option('ProjectTheme_currency'));
	  $p->add_field('return', $this_script.'&action=success');
	  $p->add_field('bn', 'SiteMile_SP'); 
      $p->add_field('cancel_return', $this_script.'&action=cancel');
      $p->add_field('notify_url', $this_script.'&action=ipn');
      $p->add_field('item_name', $post->post_title);
	  $p->add_field('custom', $pid.'|'.current_time('timestamp',0));
      $p->add_field('amount', ProjectTheme_formats($total,2));

      $p->submit_paypal_post(); // submit the fields to paypal

      break;

   case 'success':      // Order was successful...
	case 'ipn':
	

	
	if(isset($_POST['custom']))
	{
	
		global $current_user;
		$current_user = wp_get_current_user();
		
		$uid = $current_user->ID;
		
		$cust 					= $_POST['custom'];
		$cust 					= explode("|",$cust);
		$pid					= $cust[0];
		$datemade 				= $cust[1];
		
		
		update_post_meta($pid, 'paid_user',"1");
		update_post_meta($pid, "paid_user_date", $datemade);
	
	}

	
	wp_redirect(get_permalink($pid));
	
   break;

   case 'cancel':       // Order was canceled...

	wp_redirect(ProjectTheme_get_pay4project_page_url($pid));
	
       break;
     



 }     

?>