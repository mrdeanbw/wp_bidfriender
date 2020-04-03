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

function ProjectTheme_my_account_workspaces_function()
{
		global $current_user, $wpdb, $wp_query;
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;

		do_action('pt_for_demo_work_3_0');

			pt_account_main_menu_new();

?>
<div class="row"> <?php 	ProjectTheme_get_users_links(); ?>

    	<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">

				<?php




								global $wp_query;
								$query_vars = $wp_query->query_vars;
								$post_per_page = 5;


								$args = array(
									'paged' => get_query_var('paged'),
									'posts_per_page' => 5,
									'post_type'  => 'workspace',
									'meta_query' => array(
										'relation' => 'OR',
										array(
											'key'     => 'freelancer',
											'value'   => $uid,
											'compare' => '=',
										),
										array(
											'key'     => 'customer',
											'value'   => $uid,
											'compare' => '=',
										)

									)
								);

								query_posts($args);

								if(have_posts()) :
								while ( have_posts() ) : the_post();

									$project = get_post_meta(get_the_ID(),'project',true);
									$pst = get_post($project);


																		$owner 		= get_userdata($pst->post_author);

																		$projectTheme_get_winner_bid = projectTheme_get_winner_bid($project);
																		$bidder 	= get_userdata($projectTheme_get_winner_bid->uid);


									//----------------------------------

									?>
											<div class="card"> <div class="padd10">
											<div class="workspace_title_div p-2">	<?php echo sprintf(__('Workspace: %s','ProjectTheme'), $pst->post_title); ?> </div>
											<div class="project_title_div">


<div class="row p-3">

<?php

			$vvvv = projectTheme_get_unread_number_messages_workspaces_by_project($pst->ID, $uid);  //projectTheme_get_unread_number_messages_workspaces_by_project($pst->ID);



			if($vvvv > 0)
			{
					echo '<div class="col-12 col-sm-12 col-md-12 border-bottom mb-1 pb-1"';
					printf(__('Unread Messages:  %s','ProjectTheme'),  $vvvv);
					echo '</div>';
			}

 ?>

							<div class="col-12 col-sm-12 col-md-12 border-bottom mb-1 pb-1">	<?php printf(__('Project owner: <a href="%s">%s</a>','ProjectTheme'), ProjectTheme_get_user_profile_link($owner->ID) ,$owner->user_login); ?> </div>
		<div class="col-12 col-sm-12 col-md-12 border-bottom mb-1 pb-1">		 		<?php printf(__('Project bidder: <a href="%s">%s</a>','ProjectTheme'), ProjectTheme_get_user_profile_link($bidder->ID),  $bidder->user_login); ?> </div>
							<div class="col-12 col-sm-12 col-md-12 border-bottom mb-1 pb-1">						<?php printf(__('Winning Bid Amount: %s','ProjectTheme'), projecttheme_get_show_price($projectTheme_get_winner_bid->bid)); ?> </div>
							<div class="col-12 col-sm-12 col-md-12 border-bottom mb-1 pb-1">						<?php printf(__('Date work started: %s','ProjectTheme'), date_i18n('d-M-Y', get_post_meta($project,'closed_date',true) )); ?></div>

											 </div>


											 </div>

												<a href="<?php echo get_the_permalink($project) ?>" class="btn  btn-primary btn-sm"><i class="fas fa-book"></i> <?php _e('To the project page','ProjectTheme') ?></a>
												<a href="<?php echo home_url() ?>/?p_action=workspaces&pid=<?php the_ID() ?>" class="btn btn-primary btn-sm"><i class="far fa-envelope-open"></i> <?php _e('Read More or Send a Message','ProjectTheme') ?></a>
											</div>	</div>
									<?php
								endwhile;

								if(function_exists('wp_pagenavi')):
								wp_pagenavi(); endif;

								 else:

								echo '<div class="card border_bottom_0"> <div class="box_content">   ';
								_e("There are no workspaces yet.",'ProjectTheme');
								echo '</div>  </div> ';

								endif;

								wp_reset_query();



				?>







  		</div></div>
<?php


}

?>
