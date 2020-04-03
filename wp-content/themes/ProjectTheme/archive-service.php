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

global $query_string;

	function projectTheme_posts_join4($join) {
		global $wp_query, $wpdb;

		$join .= " LEFT JOIN (
				SELECT post_id, meta_value as featured_due
				FROM $wpdb->postmeta
				WHERE meta_key =  'featured' ) AS DD
				ON $wpdb->posts.ID = DD.post_id ";


		return $join;
	}

//------------------------------------------------------

	function projectTheme_posts_orderby4( $orderby )
	{
		global $wpdb;
		$orderby = " featured_due+0 desc, $wpdb->posts.post_date desc ";
		return $orderby;
	}


	add_filter('posts_join', 	'projectTheme_posts_join4');
	add_filter('posts_orderby', 'projectTheme_posts_orderby4' );

$closed = array(
		'key' => 'closed',
		'value' => "0",
		//'type' => 'numeric',
		'compare' => '='
);

$prs_string_qu = wp_parse_args($query_string);
$prs_string_qu['meta_query'] = array($closed);
$prs_string_qu['meta_key'] = 'featured';
$prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';

query_posts($prs_string_qu);

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_title = $term->name;

//======================================================

	get_header();
?>



<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
    	<div class="mm_inn"><?php
						if(empty($term_title)) echo __("All Posted Services",'ProjectTheme');
						else echo sprintf( __("Latest Posted Services in %s",'ProjectTheme'), $term_title);
					?>
                     </div>


<?php

		if(function_exists('bcn_display'))
		{
		    echo '<div class="my_box3_breadcrumb breadcrumb-wrap">';
		    bcn_display();
			echo '</div>';
		}

?>	</div>


		<?php

		$ProjectTheme_template_header_show_search_1 = get_option('ProjectTheme_template_header_show_search_1');
		if($ProjectTheme_template_header_show_search_1 != "no") projectTheme_get_the_search_box()

		?>

    </div>
</div>




<?php

	$ProjectTheme_adv_code_cat_page_above_content = stripslashes(get_option('ProjectTheme_adv_code_cat_page_above_content'));
		if(!empty($ProjectTheme_adv_code_cat_page_above_content)):

			echo '<div class="full_width_a_div">';
			echo $ProjectTheme_adv_code_cat_page_above_content;
			echo '</div>';

		endif;


?>



<div class="container mt-4">
		<div id="main" class="row">


<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">


<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

<?php projectTheme_get_service_acc(); ?>

<?php
 		endwhile;

		if(function_exists('wp_pagenavi')):
		wp_pagenavi(); endif;

     	else:

		echo __('No services posted.',"ProjectTheme");

		endif;
		// Reset Post Data
		wp_reset_postdata();

		?>


</div>



<div id="right-sidebar" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <ul class="sidebar-ul">
        <?php dynamic_sidebar( 'other-page-area' ); ?>
    </ul>
</div>


</div></div>

<?php

	get_footer();

?>
