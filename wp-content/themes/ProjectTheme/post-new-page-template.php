<?php
/*
Template Name: PT Post New
*/
?>

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


	get_header();
	global   $wp_query;

	$gg = $wp_query->posts[0]->ID;
	$post = get_post($gg);

?>
<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
    	<div class="mm_inn post-newtitle"><?php _e('Describe what you need done','ProjectTheme') ?>
                     </div>
 	</div>



    </div>
</div>



<!-- ########## -->

<div class="container mt-4"  id="post-new-container">
		<div id="main" class="wrapper">



<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; // end of the loop. ?>


</div>
</div>
<?php get_footer(); ?>
