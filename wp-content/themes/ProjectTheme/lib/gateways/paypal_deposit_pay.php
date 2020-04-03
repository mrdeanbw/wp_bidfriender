<?php
session_start();
include 'paypal.class.php';

global $wp_query;

$action = $_GET['action'];


$p = new paypal_class;             // initiate an instance of the class
$bus = trim(get_option('projectTheme_payPal_email'));
if(empty($bus)) die('ERROR. Please Admin, add your paypal address in backend.');

$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url

	$sandbox = get_option('ProjectTheme_paypal_enable_sdbx');

	if($sandbox == "yes")
	$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';     // paypal url


global $wpdb;
$this_script = home_url().'/?p_action=paypal_deposit_pay';

if(empty($action)) $action = 'process';

switch ($action) {



   case 'process':      // Process and order...
   $total = trim($_POST['amount']);

	 $projectTheme_tax_fee_paypal_deposit = get_option('projectTheme_tax_fee_paypal_deposit');
	 if($projectTheme_tax_fee_paypal_deposit > 0)
	 {
		 		$fee = round($projectTheme_tax_fee_paypal_deposit*0.01*$total,2);
				$total = $total + $fee;

	 }





	  global $current_user;
	  $current_user = wp_get_current_user();
	  $uid = $current_user->ID;

//---------------------------------------------

      //$p->add_field('business', 'sitemile@sitemile.com');
      $p->add_field('business', $bus);
	  $p->add_field('currency_code', get_option('projectTheme_currency'));
	  $p->add_field('return', $this_script.'&action=success');
	  $p->add_field('bn', 'SiteMile_SP');
      $p->add_field('cancel_return', $this_script.'&action=cancel');
      $p->add_field('notify_url', $this_script.'&action=ipn');
      $p->add_field('item_name', __('Payment Deposit',"ProjectTheme"));
	  $p->add_field('custom', $uid.'|'.current_time('timestamp',0).'|'.$_POST['amount']);
      $p->add_field('amount', ProjectTheme_formats_special($total,2));

      $p->submit_paypal_post(); // submit the fields to paypal

      break;

   case 'success':      // Order was successful...
	case 'ipn':



	if(isset($_POST['custom']))
	{


	$cust 					= $_POST['custom'];
	$cust 					= explode("|",$cust);
	$uid					= $cust[0];
	$datemade 				= $cust[1];
	$am 				= $cust[2];
	/*$txn_id					= $_POST['txn_id'];
	$item_name 				= $_POST['item_name'];
	$payment_date 			= $_POST['payment_date'];
	$mc_currency 			= $_POST['mc_currency'];
	$last_name 				= $_POST['last_name'];
	$first_name 			= $_POST['first_name'];
	$payer_email 			= $_POST['payer_email'];
	$address_country 		= $_POST['address_country'];
	$address_state 			= $_POST['address_state'];
	$address_country_code 	= $_POST['address_country_code'];
	$address_zip 			= $_POST['address_zip'];
	$address_street 		= $_POST['address_street'];
	$mc_fee 				= $_POST['mc_fee'];
	$mc_gross 				= $_POST['mc_gross'];

		$ss = "INSERT INTO `".$wpdb->prefix."ad_transactions` (
						`uid`,
						`pid` ,
						`datemade` ,
						`payment_date` ,
						`txn_id` ,
						`item_name` ,
						`mc_currency` ,
						`last_name` ,
						`first_name` ,
						`payer_email` ,
						`address_country` ,
						`address_state` ,
						`address_country_code` ,
						`address_zip` ,
						`address_street` ,
						`mc_fee` ,
						`mc_gross`
						)
						VALUES ('$uid',
						'$pid', '$datemade', '$payment_date', '$txn_id', '$item_name', '$mc_currency', '$last_name', '$first_name', '$payer_email',
						'$address_country', '$address_state', '$address_country_code', '$address_zip', '$address_street', '$mc_fee', '$mc_gross');";

*/
	$op = get_option('ProjectTheme_deposit_'.$uid.$datemade);


		if($op != "1")
		{
			$mc_gross = $am; //$_POST['mc_gross'] - $_POST['mc_fee'];

			$cr = projectTheme_get_credits($uid);
			projectTheme_update_credits($uid,$mc_gross + $cr);

			update_option('ProjectTheme_deposit_'.$uid.$datemade, "1");
			$reason = __("Deposit through PayPal.","ProjectTheme");
			projectTheme_add_history_log('1', $reason, $mc_gross, $uid);

			$user = get_userdata($uid);

			//--------------------------------
			// send emails to admin and user

			$message = "The user ".$user->user_login." has just deposited ".$mc_gross." ".projectTheme_currency()." into his account.";
		//	sitemile_send_email(get_bloginfo('admin_email'), __('Money received on your site: Deposit','ProjectTheme') , $message);

			//-------

			$message = "You have just deposited ".$mc_gross." ".projectTheme_currency()." into your account.";
		//	sitemile_send_email($user->user_email, __('Money deposit completed.','ProjectTheme') , $message);

			//-------------------------------

		}

	}

	$sss = $_SESSION['redir1'];
	if(!empty($sss))
	{
		$_SESSION['redir1'] = '';
		wp_redirect($sss);
	}
	else
	wp_redirect(get_permalink(get_option('ProjectTheme_my_account_payments_id')));

   break;

   case 'cancel':       // Order was canceled...

	wp_redirect(ProjectTheme_get_payments_page_url('deposit'));

       break;




 }

?>
