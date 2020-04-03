<?php

	global $wp_query, $wpdb, $current_user;
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;

	$business = get_option('ProjectTheme_moneybookers_email');
	if(empty($business)) die('ERROR. Please input your Moneybookers email.');
	//-------------------------------------------------------------------------

	$total = trim($_POST['amount']);


	//---------------------------------

	$tm 			= current_time('timestamp',0);
	$cancel_url 	= ProjectTheme_get_payments_page_url('deposit');
	$response_url 	= home_url().'/?p_action=mb_deposit_response';
	$ccnt_url		= ProjectTheme_get_payments_page_url();
	$currency 		= get_option('ProjectTheme_currency');

	$title_post = "Deposit";
	//reponse: amount

?>


<html>
<head><title>Processing Skrill Payment...</title></head>
<body onLoad="document.form_mb.submit();">
<center><h3><?php _e('Please wait, your order is being processed...', 'ProjectTheme'); ?></h3></center>


    <form name="form_mb" action="https://www.skrill.com/app/payment.pl">
    <input type="hidden" name="pay_to_email" value="<?php echo get_option('ProjectTheme_moneybookers_email'); ?>">
    <input type="hidden" name="payment_methods" value="ACC,OBT,GIR,DID,SFT,ENT,EBT,SO2,IDL,PLI,NPY,EPY">

    <input type="hidden" name="recipient_description" value="<?php bloginfo('name'); ?>">

    <input type="hidden" name="cancel_url" value="<?php echo $cancel_url; ?>">
    <input type="hidden" name="status_url" value="<?php echo $response_url; ?>">

    <input type="hidden" name="language" value="EN">

    <input type="hidden" name="merchant_fields" value="field1">
    <input type="hidden" name="field1" value="<?php echo $uid.'|'.$tm; ?>">

    <input type="hidden" name="amount" value="<?php echo $total; ?>">
    <input type="hidden" name="currency" value="<?php echo $currency ?>">

    <input type="hidden" name="detail1_description" value="Product: ">
    <input type="hidden" name="detail1_text" value="<?php echo $title_post; ?>">

    <input type="hidden" name="return_url" value="<?php echo $ccnt_url; ?>">


    </form>


</body>
</html>
