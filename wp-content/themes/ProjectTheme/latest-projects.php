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

		echo '<h2 class="widget-title">'.__('Latest Projects','ProjectTheme'). '</h2>';
		$limit = 10;

		$limit = apply_filters('ProjectTheme_filter_limit_latest_projects', $limit);

		 global $wpdb, $custom_post_project_type_name;	
				 $querystr = "SELECT distinct wposts.*
					FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta, $wpdb->postmeta wpostmeta2
					WHERE wposts.ID = wpostmeta.post_id and wposts.ID = wpostmeta2.post_id
					AND wpostmeta.meta_key = 'closed'  AND wpostmeta2.meta_key = 'featured'
					AND wpostmeta.meta_value = '0'
					AND wposts.post_status = 'publish'
					AND wposts.post_type = '$custom_post_project_type_name'
					ORDER BY wpostmeta2.meta_value desc, wposts.post_date DESC LIMIT ".$limit;

				 $pageposts = $wpdb->get_results($querystr, OBJECT);

				 ?>

					 <?php $i = 0; if ($pageposts): ?>
					 <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>


                     <?php projectTheme_get_post(); ?>


                     <?php endforeach; ?>
                     <?php else : ?> <?php $no_p = 1; ?>
                       <div class="padd100"><p class="center"><?php _e("Sorry, there are no posted projects yet.",'ProjectTheme'); ?></p></div>

                     <?php endif; ?>
