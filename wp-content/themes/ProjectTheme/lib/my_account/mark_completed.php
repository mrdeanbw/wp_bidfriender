<?php
if(!is_user_logged_in()) { wp_redirect(home_url()."/wp-login.php"); exit; }
//-----------

	add_filter('sitemile_before_footer', 'projectTheme_my_account_before_footer');
	function projectTheme_my_account_before_footer()
	{
		echo '<div class="clear10"></div>';
	}

	//----------

	global $wpdb,$wp_rewrite,$wp_query;
	$pid = $wp_query->query_vars['pid'];

	global $current_user;
	$current_user=wp_get_current_user();
	$uid = $current_user->ID;

	$post_pr = get_post($pid);

	//---------------------------

	if($uid != $post_pr->post_author) { wp_redirect(home_url()); exit; }

	//---------------------------

	if(isset($_POST['yes']))
	{
		$tm = current_time('timestamp',0);
		$mark_seller_accepted = get_post_meta($pid, 'mark_seller_accepted', true);

		if(empty($mark_seller_accepted))
		{

			update_post_meta($pid, 'mark_seller_accepted',		"1");
			update_post_meta($pid, 'mark_seller_accepted_date',		$tm);

			update_post_meta($pid, 'outstanding',	"0");
			update_post_meta($pid, 'delivered',		"1");

			//------------------------------------------------------------------------------
			$projectTheme_get_winner_bid = projectTheme_get_winner_bid($pid);

			ProjectTheme_send_email_on_completed_project_to_bidder($pid, $projectTheme_get_winner_bid->uid);
			ProjectTheme_send_email_on_completed_project_to_owner($pid);

		}

		wp_redirect(get_permalink(get_option('ProjectTheme_my_account_outstanding_payments_id')));
		exit;
	}

	if(isset($_POST['no']))
	{
		wp_redirect(get_permalink(get_option('ProjectTheme_my_account_awaiting_completion_id')));
		exit;
	}



	//---------------------------------

	get_header();

?>

																														<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
																															<div class="page_heading_me_inner">
																														    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
																														    	<div class="mm_inn review-font-force"><?php  printf(__("Mark the project as completed: %s",'ProjectTheme'), $post_pr->post_title); ?>
																														                     </div>
																										 	</div>

																														    </div>
																														</div>


<!-- ########## -->

<div class="container mt-4">
		<div id="main" class="wrapper">


<?php

do_action('pt_for_demo_work_3_0');
	pt_account_main_menu_new();


 ?>

<div class="row">

		    <?php ProjectTheme_get_users_links(); ?>

<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">

            <div class="card p-3">
               <?php

			   printf(__("You are about to mark this project as completed: %s",'ProjectTheme'), $post_pr->post_title); echo '<br/>';
			  _e("The service provider will be notified about this action. After this you can pay the project from your Outstanding Payments section.",'ProjectTheme') ;

			   ?>

                <div class="clear10"></div>

               <form method="post"  >

               <input type="submit" name="yes" value="<?php _e("Yes, Mark Completed!",'ProjectTheme'); ?>" />
               <input type="submit" name="no"  value="<?php _e("No",'ProjectTheme'); ?>" />

               </form>
    </div>
			</div>
			</div>





    </div></div> 

<?php

get_footer();

?>
