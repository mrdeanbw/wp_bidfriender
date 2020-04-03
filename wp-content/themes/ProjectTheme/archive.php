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
<div class="page_heading_me">
	<div class="page_heading_me_inner">
    <div class="main-pg-title">
    	<div class="mm_inn"> <?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Blog Archives: %s', 'ProjectTheme' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Blog Archives: %s', 'ProjectTheme' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ProjectTheme' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Blog Archives: %s', 'ProjectTheme' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'ProjectTheme' ) ) . '</span>' ); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'ProjectTheme' ); ?>
						<?php endif; ?>
                     </div>
                    
        
<?php 

		if(function_exists('bcn_display'))
		{
		    echo '<div class="my_box3_breadcrumb breadcrumb-wrap">';	
		    bcn_display();
			echo '</div>';
		}

?>	</div>


		<?php projectTheme_get_the_search_box() ?>            
                    
    </div>
</div>





<div id="main_wrapper">
		<div id="main" class="wrapper"> 

 
<div id="content">
            
            
                <div class="box_content post-content"> 
<?php if ( have_posts() ) { while ( have_posts() ) : the_post(); ?>

<?php ProjectTheme_get_post_blog(); ?>	
		
<?php endwhile; // end of the loop. 


}
else
{ 
	_e('No blog posts for this tag.','ProjectTheme');

}?>

    </div>
			</div>
		 
          
        



<div id="right-sidebar">
    <ul class="xoxo">
        <?php dynamic_sidebar( 'other-page-area' ); ?>
    </ul>
</div>


</div></div>

<?php get_footer(); ?>