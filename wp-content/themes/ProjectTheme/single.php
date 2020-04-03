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


?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>





<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
    	<div class="mm_inn"><?php

							  the_title();

						?>
                     </div></div>


<?php

		if(function_exists('bcn_display'))
		{
		    echo '<div class="my_box3_breadcrumb breadcrumb-wrap">';
		    bcn_display();
			echo '</div>';
		}

?>


		<?php

		$ProjectTheme_template_header_show_search_1 = get_option('ProjectTheme_template_header_show_search_1');
		if($ProjectTheme_template_header_show_search_1 != "no") projectTheme_get_the_search_box()

		?>

    </div>
</div>



<!-- ########## -->
<div class="container mt-3">
<div class="row">


<?php


	$ProjectTheme_adv_code_single_page_above_content = stripslashes(get_option('ProjectTheme_adv_code_single_page_above_content'));
		if(!empty($ProjectTheme_adv_code_single_page_above_content)):

			echo '<div class="full_width_a_div">';
			echo $ProjectTheme_adv_code_single_page_above_content;
			echo '</div>';

		endif;
?>




<div id="content" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="card p-3">



<?php the_content(); ?>



			</div>
            </div>



<div id="right-sidebar" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <ul class="sidebar-ul">
        <?php dynamic_sidebar( 'single-widget-area' ); ?>
    </ul>
</div>



</div></div>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
