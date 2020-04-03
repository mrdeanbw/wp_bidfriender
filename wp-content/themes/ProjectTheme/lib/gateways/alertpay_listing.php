<?php

function projectTheme_alert_pay_IPN2()
{
/**
 * 
 * Sample IPN Handler for Item Payments
 * 
 * The purpose of this code is to help you to understand how to process the Instant Payment Notification 
 * variables for a payment received through AlertPay's buttons and integrate it in your PHP site. The following
 * code will ONLY handle ITEM payments. For handling IPNs for SUBSCRIPTIONS, please refer to the appropriate
 * sample code file.
 *	
 * Put this code into the page which you have specified as Alert URL.
 * The variables being read from the $_POST object in the code below are pre-defined IPN variables and the
 * the conditional blocks provide you the logical placeholders to process the IPN variables. It is your responsibility
 * to write appropriate code as per your requirements.
 *	
 * If you have any questions about this script or any suggestions, please visit us at: dev.alertpay.com
 * 
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY
 * OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT
 * LIMITED TO THE IMPLIED WARRANTIES OF FITNESS FOR A PARTICULAR PURPOSE.
 * 
 * @author AlertPay
 * @copyright 2010
 */
 
	//The value is the Security Code generated from the IPN section of your AlertPay account. Please change it to yours.
	//define("IPN_SECURITY_CODE", "");
	//define("MY_MERCHANT_EMAIL", "@gmail.com");

	//Setting information about the transaction
	$receivedSecurityCode = $_POST['ap_securitycode'];
	$receivedMerchantEmailAddress = $_POST['ap_merchant'];	
	$transactionStatus = $_POST['ap_status'];
	$testModeStatus = $_POST['ap_test'];	 
	$purchaseType = $_POST['ap_purchasetype'];
	$totalAmountReceived = $_POST['ap_totalamount'];
	$feeAmount = $_POST['ap_feeamount'];
    $netAmount = $_POST['ap_netamount'];
	$transactionReferenceNumber = $_POST['ap_referencenumber'];
	$currency = $_POST['ap_currency']; 	
	$transactionDate= $_POST['ap_transactiondate'];
	$transactionType= $_POST['ap_transactiontype'];
	
	//Setting the customer's information from the IPN post variables
	$customerFirstName = $_POST['ap_custfirstname'];
	$customerLastName = $_POST['ap_custlastname'];
	$customerAddress = $_POST['ap_custaddress'];
	$customerCity = $_POST['ap_custcity'];
	$customerState = $_POST['ap_custstate'];
	$customerCountry = $_POST['ap_custcountry'];
	$customerZipCode = $_POST['ap_custzip'];
	$customerEmailAddress = $_POST['ap_custemailaddress'];
	
	//Setting information about the purchased item from the IPN post variables
	$myItemName = $_POST['ap_itemname'];
	$myItemCode = $_POST['ap_itemcode'];
	$myItemDescription = $_POST['ap_description'];
	$myItemQuantity = $_POST['ap_quantity'];
	$myItemAmount = $_POST['ap_amount'];
	
	//Setting extra information about the purchased item from the IPN post variables
	$additionalCharges = $_POST['ap_additionalcharges'];
	$shippingCharges = $_POST['ap_shippingcharges'];
	$taxAmount = $_POST['ap_taxamount'];
	$discountAmount = $_POST['ap_discountamount'];
	 
	//Setting your customs fields received from the IPN post variables
	$myCustomField_1 = $_POST['apc_1'];
	$myCustomField_2 = $_POST['apc_2'];
	$myCustomField_3 = $_POST['apc_3'];
	$myCustomField_4 = $_POST['apc_4'];
	$myCustomField_5 = $_POST['apc_5'];
	$myCustomField_6 = $_POST['apc_6'];

	if (0) { //$receivedMerchantEmailAddress != MY_MERCHANT_EMAIL) {
		// The data was not meant for the business profile under this email address.
		// Take appropriate action 
	}
	else {	
		//Check if the security code matches
		if (0) { //$receivedSecurityCode != IPN_SECURITY_CODE) {
			// The data is NOT sent by AlertPay.
			// Take appropriate action.
		}
		else {
			if ($transactionStatus == "Success") {
				if ($testModeStatus == "1") {
					// Since Test Mode is ON, no transaction reference number will be returned.
					// Your site is currently being integrated with AlertPay IPN for TESTING PURPOSES
					// ONLY. Don't store any information in your production database and 
					// DO NOT process this transaction as a real order.
					projecttheme_listing_payza_resp();
				}

				else {
					// This REAL transaction is complete and the amount was paid successfully.
					// Process the order here by cross referencing the received data with your database. 														
					// Check that the total amount paid was the expected amount.
					// Check that the amount paid was for the correct service.
					// Check that the currency is correct.
					// ie: if ($totalAmountReceived == 50) ... etc ...
					// After verification, update your database accordingly.
					
						projecttheme_listing_payza_resp();
					
				}			
			}
			else {
					// Transaction was cancelled or an incorrect status was returned.
					// Take appropriate action.
			}
		}
	}	
	
}

function projecttheme_listing_payza_resp()
{
	
		$c  	= $_POST['apc_1'];
		$c 		= explode('|',$c);
 		
			 $pid				= $c[0];
			$uid				= $c[1];
			$datemade 			= $c[2];	
		
		//---------------------------------------------------

		$amount = $_POST['ap_amount'];
		
		$op = get_option('ProjectTheme_listing_'.$pid.$datemade);
	
	
		if($op != "1")
		{
			 
			
		
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
	
}

?>