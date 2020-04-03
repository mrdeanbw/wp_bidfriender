<?php
/*
Template Name: PT Page Template 1
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
    	<div class="mm_inn"><?php

							echo $post->post_title

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




    </div>
</div>



<!-- ########## -->

<div class="container mt-4">
		<div id="main" class="wrapper">



<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; // end of the loop. ?>


</div>
</div>
<?php get_footer(); ?>
