<?php

$adaptive = get_option('projectTheme_enable_paypal_ad');

if($adaptive != 'yes')
{
	include 'normal-paypal-project.php';	
}
else
{
	include 'adaptive-paypal-project.php';
}

?>