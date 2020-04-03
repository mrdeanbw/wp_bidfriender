<?php
/***************************************************************************
*
*	ProjectTheme - copyright (c) - sitemile.com
*	The only project theme for wordpress on the world wide web.
*
*	Coder: Andrei Dragos Saioc
*	Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
*	More info about the theme here: http://sitemile.com/products/wordpress-project-freelancer-theme/
*	since v1.2.5.3
*
***************************************************************************/

 	session_start();
	global $current_user, $wp_query;
	$pid 	=  $wp_query->query_vars['pid'];

	function ProjectTheme_filter_ttl($title){return __("Relist Project Project",'ProjectTheme')." - ";}
	add_filter( 'wp_title', 'ProjectTheme_filter_ttl', 10, 3 );

	if(!is_user_logged_in()) { wp_redirect( home_url() ."/wp-login.php"); exit; }


	get_currentuserinfo;

	$post = get_post($pid);

	$uid 	= $current_user->ID;
	$title 	= $post->post_title;
	$cid 	= $current_user->ID;

	if($uid != $post->post_author) { echo 'Not your post. Sorry!'; exit; }

	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

		global $wpdb,$wp_rewrite,$wp_query;
		$post = get_post($pid);
		$cid = $uid;

		$ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);

//-------------------------------------

	get_header();
?>


                    <div class="page_heading_me_project pt_template_page_1 " id="pt_template_page_1">
                                              <div class="page_heading_me_inner page_heading_me_inner_project container" > <div class="row">
                                              <div class="main-pg-title col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
                                                  <div class="mm_inn mm_inn21"><?php _e("Finalise Relist Project", "ProjectTheme"); ?> </div>
                                    </div></div></div></div>

<!-- ########## -->

<div class="container pt-4">

<?php 			do_action('pt_for_demo_work_3_0'); ?>

  <?php pt_account_main_menu_new(); ?>

<div class="row">



	<?php ProjectTheme_get_users_links(); ?>


<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">

            <div class="card">
            	<div class="padd10">

                <div class="box_content">

     <?php

    	//--------------------------------------------------
	// hide project from search engines fee calculation

	$projectTheme_hide_project_fee = get_option('projectTheme_hide_project_fee');
	if(!empty($projectTheme_hide_project_fee))
	{
		$opt = get_post_meta($pid,'hide_project',true);
		if($opt == "0" or $opt == "no" or empty($opt)) $projectTheme_hide_project_fee = 0;


	} else $projectTheme_hide_project_fee = 0;


	//-------------------------------------------------------------------------------
	// sealed bidding fee calculation

	$projectTheme_sealed_bidding_fee = get_option('projectTheme_sealed_bidding_fee');
	if(!empty($projectTheme_sealed_bidding_fee))
	{
		$opt = get_post_meta($pid,'private_bids',true);
		if($opt == "0" or $opt == "no" or empty($opt)) { $projectTheme_sealed_bidding_fee = 0; }


	} else $projectTheme_sealed_bidding_fee = 0;


	//-------

	$featured	 = get_post_meta($pid, 'featured', true);
	$feat_charge = get_option('projectTheme_featured_fee');

	if($featured != "1" or empty($featured) ) $feat_charge = 0;

	//update_post_meta($pid, 'featured_paid', '0');
	//update_post_meta($pid, 'private_bids_paid', '0');
	//update_post_meta($pid, 'hide_project_paid', '0');

	//--------------------------------------------

	$catid = ProjectTheme_get_project_primary_cat($pid);

	$custom_set = get_option('projectTheme_enable_custom_posting');
	if($custom_set == 'yes')
	{
		$posting_fee = get_option('projectTheme_theme_custom_cat_'.$catid);
		if(empty($posting_fee)) $$posting_fee = 0;
	}
	else
	{
		$posting_fee = get_option('projectTheme_base_fee');
	}

	//-----------------------------------------------

	$total = $ProjectTheme_get_images_cost_extra + $feat_charge + $posting_fee + $projectTheme_sealed_bidding_fee + $projectTheme_hide_project_fee;

	$post 			= get_post($pid);
	$admin_email 	= get_bloginfo('admin_email');
	global $total_prc;
	$total_prc = $total;

	//----------------------------------------
	$finalize = isset($_GET['finalize']) ? true : false;

	if($total == 0)
	{
			echo '<div >';
			echo __('Thank you for posting your project with us.','ProjectTheme');
			update_post_meta($pid, "paid", "1");



				if(get_option('projectTheme_admin_approves_each_project') == 'yes')
				{
					$my_post = array();
					$my_post['ID'] = $pid;
					$my_post['post_status'] = 'draft';

					wp_update_post( $my_post );

					if($finalize == true){
						ProjectTheme_send_email_posted_project_not_approved($pid);
						ProjectTheme_send_email_posted_project_not_approved_admin($pid);
					}

					echo '<br/>'.__('Your project isn`t live yet, the admin needs to approve it.', 'ProjectTheme');

				}
				else
				{
					$my_post = array();
					$my_post['ID'] = $pid;
					$my_post['post_status'] = 'publish';

					if($finalize == true){

						wp_update_post( $my_post );
						wp_publish_post( $pid );


						ProjectTheme_send_email_posted_project_approved($pid);
						ProjectTheme_send_email_posted_project_approved_admin($pid);

						ProjectTheme_send_email_subscription($pid);

					}
				}

			echo '</div>';


	}
	else
	{
			update_post_meta($pid, "paid", "0");

			echo '<div >';
			echo __('Thank you for posting your project with us. Below is the total price that you need to pay in order to put your project live.<br/>
			Click the pay button and you will be redirected...', 'ProjectTheme');
			echo '</div>';


			$message = sprintf(__('A new project was posted on your website. <br/>
			See it here: <a href="%s">%s</a>','ProjectTheme'), get_permalink($pid), $post->post_title);

			//sitemile_send_email($admin_email, sprintf(__('New project Posted - %s','ProjectTheme'),$post->post_title),
			//$message, 'html', get_bloginfo('name'), $admin_email);

	}

	//----------------------------------------

	if($total > 0)
	{

	echo '<div class="p-3"><table class="table">';
	echo '<tr>';
	echo '<td width="450">'.__('Base Fee', 'ProjectTheme').'</td>';
	echo '<td>'.ProjectTheme_get_show_price($posting_fee,2).'</td>';
	echo '<tr>';

	if($ProjectTheme_get_images_cost_extra > 0)
	{
		echo '<tr>';
		echo '<td>'.__('Extra Images Fee', 'ProjectTheme').'</td>';
		echo '<td>'.ProjectTheme_get_show_price($ProjectTheme_get_images_cost_extra,2).'</td>';
		echo '<tr>';
	}

	echo '<tr>';
	echo '<td>'.__('Featured Fee', 'ProjectTheme').'</td>';
	echo '<td>'.ProjectTheme_get_show_price($feat_charge,2).'</td>';
	echo '<tr>';

	//if(get_post_meta($pid,'private_bids',true) == "1"):

		echo '<tr>';
		echo '<td>'.__('Sealed Bidding Fee', 'ProjectTheme').'</td>';
		echo '<td>'.ProjectTheme_get_show_price($projectTheme_sealed_bidding_fee,2).'</td>';
		echo '<tr>';

	//endif;


	//if(get_post_meta($pid,'hide_project',true) == "1"):

		echo '<tr>';
		echo '<td>'.__('Hide Project from search engines Fee', 'ProjectTheme').'</td>';
		echo '<td>'.ProjectTheme_get_show_price($projectTheme_hide_project_fee,2).'</td>';
		echo '<tr>';

	//endif;



	echo '<tr>';
	echo '<td>&nbsp;</td>';
	echo '<td></td>';
	echo '<tr>';


	echo '<tr>';
	echo '<td><strong>'.__('Total to Pay','ProjectTheme').'</strong></td>';
	echo '<td><strong>'.ProjectTheme_get_show_price($total,2).'</strong></td>';
	echo '<tr>';




	echo '<tr>';
	echo '<td><strong>'.__('Your Total Credits','ProjectTheme').'</strong></td>';
	echo '<td><strong>'.ProjectTheme_get_show_price(ProjectTheme_get_credits($uid),2).'</strong></td>';
	echo '<tr>';


	echo '<tr>';
	echo '<td>&nbsp;<br/>&nbsp;</td>';
	echo '<td></td>';
	echo '<tr>';

	}

	if($total == 0)
	{
		if(get_option('projectTheme_admin_approves_each_project') != 'yes'):

			echo '<tr>';
			echo '<td></td>';
			echo '<td><a href="'.get_permalink($pid).'" class="go_back_btn">'.__('See your project','ProjectTheme') .'</a></td>';
			echo '<tr>';
		else:

				echo '<tr>';
			echo '<td></td>';
			echo '<td><br/><a href="'.get_permalink(get_option('ProjectTheme_my_account_page_id')).'" class="go_back_btn">'.__('Go to your account','ProjectTheme') .'</a></td>';
			echo '</tr>';


		endif;
	}
	else
	{
		update_post_meta($pid,'unpaid','1');

		echo '<tr>';
		echo '<td colspan="2">';

						global $project_ID;
						$project_ID = $pid;

            $ProjectTheme_enable_credits_wallet = get_option('ProjectTheme_enable_credits_wallet');
						if($ProjectTheme_enable_credits_wallet != 'no'):
							echo '<a href="'.home_url().'/?p_action=credits_listing&pid='.$project_ID.'" class="btn btn-secondary">'.__('Pay by Credits','ProjectTheme').'</a> ';
						endif;

						//-------------------

						$ProjectTheme_paypal_enable 		= get_option('ProjectTheme_paypal_enable');
						$ProjectTheme_alertpay_enable 		= get_option('ProjectTheme_alertpay_enable');
						$ProjectTheme_moneybookers_enable 	= get_option('ProjectTheme_moneybookers_enable');

						if($ProjectTheme_paypal_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=paypal_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by PayPal','ProjectTheme').'</a> ';

						if($ProjectTheme_moneybookers_enable = "yes")
							echo '<a href="'.home_url().'/?p_action=mb_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by MoneyBookers/Skrill','ProjectTheme').'</a> ';

						if($ProjectTheme_alertpay_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=payza_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by Payza','ProjectTheme').'</a> ';

						do_action('ProjectTheme_add_payment_options_to_post_new_project');


		echo '</td></tr>';
	}





	echo '</table></div>'; ?>


                </div>
                </div>
                </div>
                </div>



</div></div> 
<?php get_footer(); ?>
