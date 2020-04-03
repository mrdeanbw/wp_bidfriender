<?php

function ProjectTheme_my_account_area_awaiting_completion_function()
{

		global $current_user, $wpdb, $wp_query;
		$current_user=wp_get_current_user();
		$uid = $current_user->ID;


					do_action('pt_for_demo_work_3_0');

					pt_account_main_menu_new();

?>
<div class="row">  <?php 	ProjectTheme_get_users_links(); ?>
    	<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">





                <?php

				global $current_user;
				$current_user = wp_get_current_user();
				$uid = $current_user->ID;


				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 10;




				$outstanding = array(
						'key' => 'outstanding',
						'value' => "1",
						'compare' => '='
					);

				$args = array('post_type' => 'project', 'author' => $uid, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
				'paged' => $query_vars['paged'], 'meta_query' => array($outstanding));

				query_posts( $args);

				if(have_posts()) :
				while ( have_posts() ) : the_post();
					projectTheme_get_post_awaiting_compl();
				endwhile;

				if(function_exists('wp_pagenavi')):
				wp_pagenavi(); endif;

				 else:
				echo '<div class="card p-3">     ';
				_e("There are no projects yet.",'ProjectTheme');
				echo '</div>    ';
				endif;

				wp_reset_query();

				?>



  		</div></div>
<?php


}

?>
