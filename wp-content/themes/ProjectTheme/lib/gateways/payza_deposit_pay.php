<?php

	global $wp_query, $wpdb, $current_user;
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;

	$business = get_option('ProjectTheme_alertpay_email');
	if(empty($business)) die('ERROR. Please input your Payza email.');
	//-------------------------------------------------------------------------
	
	$total = trim($_POST['amount']);
	
	
	//---------------------------------
	
	$tm 			= current_time('timestamp',0);
 
	$currency 		= get_option('ProjectTheme_currency');
	
	$title_post = "Deposit";
	//reponse: amount
?>


<html>
<head><title>Processing Skrill Payment...</title></head>
<body onLoad="document.form_mb.submit();">
<center><h3><?php _e('Please wait, your order is being processed...', 'ProjectTheme'); ?></h3></center>

	
 
    
    <form action="https://secure.payza.com/checkout" method="post" name="form_mb">
        <input name="ap_purchasetype" type="hidden" value="item-goods">
        <input name="ap_merchant" type="hidden" value="<?php echo get_option('ProjectTheme_alertpay_email'); ?>">
        <input name="ap_itemname" type="hidden" value="<?php _e('Deposit money','ProjectTheme') ?>">
        <input name="ap_description" type="hidden" value="<?php _e('Deposit money','ProjectTheme') ?>"> 
        <input name="ap_cancelurl" type="hidden" value="<?php echo get_home_url() ?>">
        <input name="ap_returnurl" type="hidden" value="<?php echo get_permalink(get_option('ProjectTheme_my_account_payments_id')); ?>">
        <input name="ap_quantity" type="hidden" value="1">
        <input name="ap_currency" type="hidden" value="<?php echo $currency ?>">
        <input name="ap_itemcode" type="hidden" value="Dep_<?php echo time() ?>">
        <input name="ap_shippingcharges" type="hidden" value="0">
       <input name="ap_alerturl" type="hidden" value="<?php echo get_home_url() ?>/?alert_ipn=1">
        <input name="apc_1" type="hidden" value="<?php echo $uid.'|'.time() ?>">
        
        
        
        <input name="ap_amount" type="hidden" value="<?php echo $total; ?>"> 
                            </form>


</body>
</html>



