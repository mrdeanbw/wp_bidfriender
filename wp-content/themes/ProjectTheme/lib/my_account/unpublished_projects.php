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

function ProjectTheme_my_account_unpublished_projects_area_function()
{
		global $current_user, $wpdb, $wp_query;
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;


					do_action('pt_for_demo_work_3_0');
						pt_account_main_menu_new();

?>
<div class="row">  <?php 	ProjectTheme_get_users_links(); ?>

<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">


                <?php


				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 10;


				$paids = array(
						'key' => 'paid',
						'value' => "0",
						'compare' => '='
					);


				$args = array('post_type' => 'project', 'order' => 'DESC', 'orderby' => 'date', 'post_status' => 'draft', 'author' => $uid, 'posts_per_page' => $post_per_page,
				'paged' => $query_vars['paged'], 'meta_query' => array($paids));

				query_posts($args);


				//query_posts( "post_status=draft&meta_key=paid&meta_value=0&post_type=project&order=DESC&orderby=id&author=".$uid.
				//"&posts_per_page=".$post_per_page."&paged=".$query_vars['paged'] );

				if(have_posts()) :
				while ( have_posts() ) : the_post();
					projectTheme_get_post(array('unpaid'));
				endwhile;

				if(function_exists('wp_pagenavi')):
				wp_pagenavi(); endif;

				 else:

				echo ' <div class="card p-3">   ';
				_e("There are no projects yet.",'ProjectTheme');
				echo '</div>   ';


				endif;

				wp_reset_query();

				?>






  		</div>
  		</div>
<?php
	 

}

?>
