<?php
session_start();
include 'paypal.class.php';

global $wp_query;

$action = $_GET['action'];
$pid = $_GET['pay_escrow_by_pp'];


$p = new paypal_class;             // initiate an instance of the class
$bus = trim(get_option('projectTheme_payPal_email'));
if(empty($bus)) die('ERROR. Please Admin, add your paypal address in backend.');
if(!(is_user_logged_in())) die('ERROR. Please login.');


$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';   // testing paypal url

	$sandbox = get_option('ProjectTheme_paypal_enable_sdbx');

	if($sandbox == "yes")
	$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';     // paypal url


global $wpdb;
$this_script = home_url().'/?pay_escrow_by_pp=1';

if(empty($action)) $action = 'process';


$bid = projectTheme_get_winner_bid($pid);


switch ($action) {



   case 'process':      // Process and order...
   $total = trim($bid->bid);

	  global $current_user;
	  $current_user = wp_get_current_user();
	  $uid = $current_user->ID;


		$projectTheme_tax_fee_paypal_deposit = get_option('projectTheme_tax_fee_paypal_deposit');
		if($projectTheme_tax_fee_paypal_deposit > 0)
		{

				$fee = round(0.01*$total*$projectTheme_tax_fee_paypal_deposit, 2);

			} else $fee = 0;

//---------------------------------------------

      //$p->add_field('business', 'sitemile@sitemile.com');
      $p->add_field('business', $bus);
	  $p->add_field('currency_code', get_option('projectTheme_currency'));
	  $p->add_field('return', $this_script.'&action=success');
	  $p->add_field('bn', 'SiteMile_SP');
      $p->add_field('cancel_return', $this_script.'&action=cancel');
      $p->add_field('notify_url', $this_script.'&action=ipn');
      $p->add_field('item_name', __('Escrow for project #' . $pid,"ProjectTheme"));
	  $p->add_field('custom', $uid.'|'.current_time('timestamp',0)."|" . $pid);
      $p->add_field('amount', ProjectTheme_formats_special(($total+$fee),2));

      $p->submit_paypal_post(); // submit the fields to paypal

      break;

   case 'success':      // Order was successful...
	case 'ipn':

	$_POST = array_merge($_POST, json_decode(file_get_contents("php://input"), true));

			//mail("andreisaioc@gmail.com","asd", print_r($_POST, true));
			//mail("andreisaioc@gmail.com","asd2", print_r($_GET, true));

	if(isset($_POST['custom']) or isset($_GET['cm']))
	{




	$cust 					= empty($_POST['custom']) ? $_GET['cm'] : $_POST['custom'];
	$cust 					= explode("|",$cust);
	$uid					= $cust[0];
	$datemade 				= $cust[1];
	$pid 							= $cust[2];
  $bid = projectTheme_get_winner_bid($pid);
  $uid2 = $bid->uid;


	$op = get_option('ppt_escrow'.$uid.$datemade);


		if($op != "1")
		{
			$mc_gross = empty($_POST['mc_gross']) ? $_GET['amt'] : $_POST['mc_gross'];// - $_POST['mc_fee'];

			$cr = projectTheme_get_credits($uid);
			projectTheme_update_credits($uid,$mc_gross + $cr);

			update_option('ppt_escrow'.$uid.$datemade, "1");
			$reason = __("Deposit through PayPal.","ProjectTheme");
			projectTheme_add_history_log('1', $reason, $mc_gross, $uid);

			$user = get_userdata($uid);


      //---------

      $s = "select * from ".$wpdb->prefix."project_escrow where datemade='$datemade' and fromid='$uid'";
      $rr = $wpdb->get_results($s);

      if(count($rr) == 0)
      {

        $s = "insert into ".$wpdb->prefix."project_escrow (datemade, amount, fromid, toid, pid)
        values('$datemade','{$bid->bid}','$uid','$uid2','$pid')";
        $wpdb->query($s);

          // for logged in user, the user who sends
          //======================================================
          $cr = projectTheme_get_credits($uid);
          projectTheme_update_credits($uid, $cr - $amount);

      }


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
