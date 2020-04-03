<?php

	global $wp_query, $wpdb;
	$pid = $wp_query->query_vars['pid'];

	global $current_user, $wpdb;
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;
	
	$bid = projectTheme_get_winner_bid($pid);	
	$total = $bid->bid;
	  

	$projectplugin_signature 	= get_option('project_theme_signature');	
	$projectplugin_apipass 		= get_option('project_theme_apipass');
	$projectplugin_apiuser 		= get_option('project_theme_apiuser');
	$projectplugin_appid 		= get_option('project_theme_appid');


  	$signature 	= $projectplugin_signature; 
  	$api_pass 	= $projectplugin_apipass; 
  	$api_user 	= $projectplugin_apiuser;  
  	$apiid 		= $projectplugin_appid;
 
 //------------------------------------------------------------------------
 	
	$pmnt_id = time().$pid;
	
	$ret = home_url()."/?return_chained=" . $pmnt_id; 
	$receiver_user_id = $bid->uid;			
	
 	$fee = get_option('projectTheme_fee_after_paid');
	if(empty($fee)) { die('ERROR. Please specify an amount for the percent taken by admin for each project.'); }
	
 //-------------------------------------------------------------------------	
	
 
	$adminfee = $total*($fee*0.01);
 
	$receiver1 	= get_option('ProjectTheme_paypal_email'); if(empty($receiver1)) { die('ERROR. The site admin has no paypal email defined.'); }
	$amount1 	= ProjectTheme_formats_special($adminfee, 2);
	
	
	$receiver2 	= get_user_meta($receiver_user_id, 'paypal_email', 'true'); if(empty($receiver2)) { die('ERROR. The bid winner has no paypal email defined.'); }
	$amount2 	= ProjectTheme_formats_special($total-$adminfee, 2); 
 
	$currency 	= get_option('ProjectTheme_currency');  
 	$enasdbx 	= get_option('ProjectTheme_paypal_enable_sdbx');
	
	if($enasdbx == "yes")
	$link = "https://svcs.sandbox.paypal.com/AdaptivePayments/Pay";
	else $link = "https://svcs.paypal.com/AdaptivePayments/Pay";
	
	$notifyURL = urlencode( home_url() . "/?notify_chained=" . $pid);
	$trID = $pid."_".time();
	
	$params = "actionType=PAY_PRIMARY&cancelUrl=".$ret."&trackingId=".$trID."&ipnNotificationUrl=".$notifyURL."&currencyCode=".$currency.
  	"&receiverList.receiver(0).amount=".($amount1 + $amount2)."&receiverList.receiver(0).email=".$receiver1.
  	"&receiverList.receiver(0).primary=true&receiverList.receiver(1).primary=false&receiverList.receiver(1).amount=".($amount2).
  	"&receiverList.receiver(1).email=".$receiver2."&requestEnvelope.errorLanguage=en_US&senderOptions.referrerCode=SiteMile_SP".
  	"&returnUrl=".$ret;
	
 
 
function array_push_assoc($array, $key, $value){
 $array[$key] = $value;
 return $array;
}
 
function my_xml2array($contents) 
{ 
    $xml_values = array(); 
    $parser = xml_parser_create(''); 
    if(!$parser) 
        return false; 

    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, 'UTF-8'); 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    xml_parse_into_struct($parser, trim($contents), $xml_values); 
    xml_parser_free($parser); 
    if (!$xml_values) 
        return array(); 
    
    $xml_array = array(); 
    $last_tag_ar =& $xml_array; 
    $parents = array(); 
    $last_counter_in_tag = array(1=>0); 
    foreach ($xml_values as $data) 
    { 
        switch($data['type']) 
        { 
            case 'open': 
                $last_counter_in_tag[$data['level']+1] = 0; 
                $new_tag = array('name' => $data['tag']); 
                if(isset($data['attributes'])) 
                    $new_tag['attributes'] = $data['attributes']; 
                if(isset($data['value']) && trim($data['value'])) 
                    $new_tag['value'] = trim($data['value']); 
                $last_tag_ar[$last_counter_in_tag[$data['level']]] = $new_tag; 
                $parents[$data['level']] =& $last_tag_ar; 
                $last_tag_ar =& $last_tag_ar[$last_counter_in_tag[$data['level']]++]; 
                break; 
            case 'complete': 
                $new_tag = array('name' => $data['tag']); 
                if(isset($data['attributes'])) 
                    $new_tag['attributes'] = $data['attributes']; 
                if(isset($data['value']) && trim($data['value'])) 
                    $new_tag['value'] = trim($data['value']); 

                $last_count = count($last_tag_ar)-1; 
                $last_tag_ar[$last_counter_in_tag[$data['level']]++] = $new_tag; 
                break; 
            case 'close': 
                $last_tag_ar =& $parents[$data['level']]; 
                break; 
            default: 
                break; 
        }; 
    } 
    return $xml_array; 
}  
 
 /*
function get_web_page( $url, $posts,$api_user,$api_pass,$signature,$apiid )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => false,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "sitemile", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_POSTFIELDS		 => $posts,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSLVERSION => 6,
        CURLOPT_HTTPHEADER		 => 
        array(
        "X-PAYPAL-SECURITY-USERID: ".$api_user,
        "X-PAYPAL-SECURITY-PASSWORD: ".$api_pass,
        "X-PAYPAL-SECURITY-SIGNATURE: ".$signature,
        "X-PAYPAL-APPLICATION-ID: ".$apiid,
      
        "X-PAYPAL-DEVICE-IPADDRESS: ".$_SERVER['REMOTE_ADDR'],
        "X-PAYPAL-REQUEST-DATA-FORMAT: NV",
        "X-PAYPAL-RESPONSE-DATA-FORMAT: XML")
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
} */


//$cont = get_web_page( $link, $params ,$api_user,$api_pass,$signature,$apiid );
$co = $cont['content'];

$arr =my_xml2array($co);
//echo '<pre>';
//print_r( $arr );
//echo '<pre>';

//exit;

$ap = $arr[0][1]['value'];

if(empty($ap))
{
	echo "ERROR<br/>";
	
	echo '<pre>';
	print_r( $arr );
	echo '<pre>';
	exit;	
}

	
	update_post_meta($pid, 'adaptive_key', $ap);
	
	if($enasdbx == "yes")
	header("Location: https://www.sandbox.paypal.com/webscr?cmd=_ap-payment&paykey=".$ap);
	else header("Location: https://www.paypal.com/webscr?cmd=_ap-payment&paykey=".$ap);



?>