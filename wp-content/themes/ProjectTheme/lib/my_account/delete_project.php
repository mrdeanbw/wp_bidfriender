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

	function ProjectTheme_filter_ttl($title){return __("Delete Project",'ProjectTheme')." - ";}
	add_filter( 'wp_title', 'ProjectTheme_filter_ttl', 10, 3 );

	if(!is_user_logged_in()) { wp_redirect(  esc_url( home_url() ) ."/wp-login.php"); exit; }


	$current_user=wp_get_current_user();

	$post = get_post($pid);

	$uid 	= $current_user->ID;
	$title 	= $post->post_title;
	$cid 	= $current_user->ID;

	$winner = get_post_meta($pid, 'winner', true);

	if(!empty($winner)) { echo 'Project has a winner, cant be deleted. Sorry!'; exit; }
	if($uid != $post->post_author) { echo 'Not your post. Sorry!'; exit; }

//-------------------------------------

	get_header();
?>





  <div class="page_heading_me_project pt_template_page_1 " id="pt_template_page_1">
                            <div class="page_heading_me_inner page_heading_me_inner_project container" > <div class="row">
                            <div class="main-pg-title col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
                                <div class="mm_inn mm_inn21"><?php printf(__("Delete Project - %s", "ProjectTheme"), $post->post_title); ?> </div>
                  </div></div></div></div>

<!-- ########## -->

<div class="container pt-4">

<?php 			do_action('pt_for_demo_work_3_0'); ?>

  <?php pt_account_main_menu_new(); ?>

<div class="row">



	<?php ProjectTheme_get_users_links(); ?>

	<div class="account-main-area-1 col-xs-12 col-sm-8 col-md-8 col-lg-8">
            <div class="card">
            	<div class="padd10">


                <div class="box_content">


                <?php

				if(isset($_POST['are_you_sure']))
				{
					wp_delete_post($pid);
					echo sprintf(__("The project has been deleted. <a href='%s'>Return to your account</a>.",'ProjectTheme'), get_permalink(get_option('ProjectTheme_my_account_page_id')));

				}
				else
				{
				?>

                    <form method="post" enctype="application/x-www-form-urlencoded">
                    <?php _e("Are you sure you want to delete this project?",'ProjectTheme'); ?><br/><br/>
                    <input class="btn btn-primary" type="submit" name="are_you_sure" value="<?php _e("Confirm Deletion",'ProjectTheme'); ?>"  />
                    </form>

                 <?php } ?>


                </div>
                </div>
                </div>
                </div>




</div></div>

<?php get_footer(); ?>
