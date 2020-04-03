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


	function projectTheme_posts_join3($join) {
		global $wp_query, $wpdb;

		$join .= " LEFT JOIN (
				SELECT post_id, meta_value as featured_due
				FROM $wpdb->postmeta
				WHERE meta_key =  'featured' ) AS DD
				ON $wpdb->posts.ID = DD.post_id ";


		return $join;
	}

//------------------------------------------------------

	function projectTheme_posts_orderby3( $orderby )
	{
		global $wpdb;
		$orderby = " featured_due+0 desc, $wpdb->posts.post_date desc ";
		return $orderby;
	}


	add_filter('posts_join', 	'projectTheme_posts_join3');
	add_filter('posts_orderby', 'projectTheme_posts_orderby3' );

global $query_string;

$closed = array(
		'key' => 'closed',
		'value' => "0",
		//'type' => 'numeric',
		'compare' => '='
);

if(!empty($_GET['ending']))
{
	$ends = array(
		'key' => 'ending',
		'value' => (current_time('timestamp', 0) + 3600*24*$_GET['ending']),
		//'type' => 'numeric',
		'compare' => '<');

}

if(!empty($_GET['budgets']))
{
	$budgets = array(
		'key' => 'budgets',
		'value' => $_GET['budgets'],
		//'type' => 'numeric',
		'compare' => '=');

}




$prs_string_qu = wp_parse_args($query_string);
$prs_string_qu['meta_query'] = array($closed, $ends, $budgets);
$prs_string_qu['meta_key'] = 'featured';
$prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';

if(!empty($_GET['keyword']))
$prs_string_qu['s'] = $_GET['keyword'];

query_posts($prs_string_qu);

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_title = $term->name;

//======================================================

	get_header();

	$ProjectTheme_adv_code_cat_page_above_content = stripslashes(get_option('ProjectTheme_adv_code_cat_page_above_content'));
		if(!empty($ProjectTheme_adv_code_cat_page_above_content)):

			echo '<div class="full_width_a_div">';
			echo $ProjectTheme_adv_code_cat_page_above_content;
			echo '</div>';

		endif;


?>


<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
    	<div class="mm_inn"><?php
						if(empty($term_title)) echo __("All Posted Projects",'ProjectTheme');
						else { echo sprintf( __("Latest Posted Projects in %s",'ProjectTheme'), $term_title);

						?>

                        <a href="<?php echo home_url(); ?>/?feed=rss&<?php echo get_query_var( 'taxonomy' ); ?>=<?php echo get_query_var( 'term' ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/rss_icon.png"
                    border="0" width="19" height="19" alt="rss icon" /></a>

                        <?php

						}
					?></div>


<?php

		if(function_exists('bcn_display'))
		{
		    echo '<div class="my_box3_breadcrumb breadcrumb-wrap">';
		    bcn_display();
			echo '</div>';
		}

?>

    </div>



    </div>
</div>



<?php projecttheme_search_box_thing() ?>

<!-- ########## -->

<div class="container mt-4">
		<div id="main" class="row">

<?php

	if(ProjectTheme_using_permalinks())
	{
		$lnk = get_term_link(get_query_var( 'term' ), get_query_var( 'taxonomy' ));
	}
	else
	{
		$lnk = get_home_url();
	}


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<form method="get" action="<?php echo $lnk ?>">
<div class="card">
	<div class="padd10">

        	<div class="search-keyword-bb">
				<div class="search-keyword-bb-left"><?php echo __('Keyword:','ProjectTheme') ?> </div>
				<div class="search-keyword-bb-right"><input type="text" placeholder="<?php _e('Type here...','ProjectTheme') ?>" value="<?php echo stripslashes($_GET['keyword']) ?>" name="keyword" size="30" class="do_input" /> </div>
			</div>


            <div class="search-keyword-bb">
				<div class="search-keyword-bb-left"><?php echo __('Project Budget:','ProjectTheme') ?> </div>
				<div class="search-keyword-bb-right"><?php echo ProjecTheme_get_budgets_dropdown($_GET['budgets'], 'do_input' , 1); ?> </div>
			</div>


            <div class="search-keyword-bb">
				<div class="search-keyword-bb-left"><?php echo __('Ending In:','ProjectTheme') ?> </div>
				<div class="search-keyword-bb-right"><select name="ending" class="do_input">
                <option value=""><?php _e('Select Period','ProjectTheme') ?></option>
                <option value="1" <?php echo ($_GET['ending'] == 1 ? 'selected="selected"' : '') ?>><?php _e('1 day','ProjectTheme') ?></option>
                <option value="7" <?php echo ($_GET['ending'] == 7 ? 'selected="selected"' : '') ?>><?php _e('7 days','ProjectTheme') ?></option>
                <option value="30" <?php echo ($_GET['ending'] == 30 ? 'selected="selected"' : '') ?>><?php _e('30 days','ProjectTheme') ?></option>
                <option value="180" <?php echo ($_GET['ending'] == 180 ? 'selected="selected"' : '') ?>><?php _e('6 Months','ProjectTheme') ?></option>

                </select> </div>
			</div>


             <div class="search-keyword-bb">
             	<div class="search-keyword-bb-left"></div>
				<div class="search-keyword-bb-right"><input type="submit" name="apply_filters" class="submit_bottom2" value="<?php _e('Apply Filters','ProjectTheme') ?>" /></div>
			</div>


	</div>
</div><!-- end filter-field-area -->
</form>


</div>


<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">





<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

<?php ProjectTheme_get_post(); ?>

<?php
 		endwhile;

		if(function_exists('wp_pagenavi')):
		wp_pagenavi(); endif;

     	else:

				echo '<div class="card p-3">';
		echo __('No projects posted.',"ProjectTheme");
		echo '</div>';

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




</div>
</div>


<?php

	get_footer();

?>
