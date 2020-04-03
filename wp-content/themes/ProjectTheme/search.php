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
<?php 

		if(function_exists('bcn_display'))
		{
		    echo '<div class="my_box3_breadcrumb"><div class="padd10">';	
		    bcn_display();
			echo '</div></div><div class="clear10"></div>';
		}


	

?>	



<div class="clear10"></div>

<div id="content">	
			<div class="my_box3">
            	<div class="padd10">
            
            	<div class="box_title"><?php printf( __( 'Search Results for: %s', 'ProjectTheme' ), '<span>' . get_search_query() . '</span>' ); ?></div>
                <div class="box_content post-content"> 

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php ProjectTheme_get_post_blog(); ?>			
<?php endwhile; // end of the loop. ?>

    </div>
			</div>
			</div>
            </div>
        



<div id="right-sidebar">
    <ul class="xoxo">
        <?php dynamic_sidebar( 'other-page-area' ); ?>
    </ul>
</div>

<?php get_footer(); ?>