<?php
/*
Template Name: Project_HOME_SPECIAL
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
 
 
?>
 
<div class="#main_wrapper">
<!-- ########## -->


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>			
<?php endwhile; // end of the loop. ?>

<!-- ################ -->

 
 
 </div>
<?php get_footer(); ?>