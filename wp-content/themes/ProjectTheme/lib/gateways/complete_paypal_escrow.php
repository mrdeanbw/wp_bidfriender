<?php

	$pid = $_GET['complete_paypal_escrow'];
	global $current_user, $wpdb;
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;
	$post = get_post($pid);
	
	//-------------------------------------
	
	if($post->post_author != $uid) die('not your post.sorry.#3321E');
	
	//-------------------------------------
	 $enasdbx 	= get_option('ProjectTheme_paypal_enable_sdbx');
	
	if($enasdbx == "yes")
	$link = "https://svcs.sandbox.paypal.com/AdaptivePayments/ExecutePayment";
	else $link = "https://svcs.paypal.com/AdaptivePayments/ExecutePayment";
	
	//-----------------------
	
	$bid = projectTheme_get_winner_bid($pid);	
	$total = $bid->bid;
	  

	$projectplugin_signature 	= get_option('project_theme_signature');	
	$projectplugin_apipass 		= get_option('project_theme_apipass');
	$projectplugin_apiuser 		= get_option('project_theme_apiuser');
	$projectplugin_appid 		= get_option('project_theme_appid');


  	$signature 		= $projectplugin_signature; 
  	$api_pass 		= $projectplugin_apipass; 
  	$api_user 		= $projectplugin_apiuser;  
  	$apiid 			= $projectplugin_appid;
	$adaptive_key 	= get_post_meta($pid, 'adaptive_key', true);
	
	//------------------------------------

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
}*/

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


$params = 'payKey='.$adaptive_key.'&requestEnvelope.errorLanguage=en_US';
 


//$cont 	= get_web_page( $link, $params ,$api_user, $api_pass, $signature, $apiid );
$co 	= $cont['content'];
$arr 	= my_xml2array($co);
$comp = $arr[0][1]['value'];

if($comp == "COMPLETED")
{
 
update_post_meta($pid, 'paid_user',"1");
				update_post_meta($pid, "paid_user_date", current_time('timestamp',0));
				update_post_meta($pid, "adaptive_done", "done");
				
				$projectTheme_get_winner_bid = projectTheme_get_winner_bid($pid);				
				ProjectTheme_send_email_when_on_completed_project($pid, $projectTheme_get_winner_bid->uid, $projectTheme_get_winner_bid->bid);

	wp_redirect(get_permalink(get_option('ProjectTheme_my_account_completed_payments_id')));
}
else
{
	echo 'There was an error. See below: <br/><br/>';
	print_r($arr);	
	echo '<br/><br/>';
	
	echo '<a href="'.get_permalink(get_option('ProjectTheme_my_account_completed_payments_id')).'">continue to the site</a>';
}


?>