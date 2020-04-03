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

/**************************************************/ 
if ( ! isset( $content_width ) ) $content_width = 900;

?>

<?php projecttheme_search_box_thing() ?>

<!-- ########## -->

<div id="main_wrapper">
		<div id="main" class="wrapper"> 

<?php
	
		$ProjectTheme_adv_code_home_above_content = stripslashes(get_option('ProjectTheme_adv_code_home_above_content'));
		if(!empty($ProjectTheme_adv_code_home_above_content)):
		
			echo '<div class="full_width_a_div">';
			echo stripslashes($ProjectTheme_adv_code_home_above_content);
			echo '</div>';
		
		endif;
	
	?>
    
    <!-- ################## -->
     
        <?php
		
		$ProjectTheme_home_page_layout = get_option('ProjectTheme_home_page_layout');
		
		if($ProjectTheme_home_page_layout == "3" or $ProjectTheme_home_page_layout == "4" ):
			
			    echo '<div id="left-sidebar">';
					echo '<ul class="xoxo">';
				 		dynamic_sidebar( 'home-left-widget-area' ); 
					echo '</ul>';
				   echo '</div>';
		
		endif;
		
		?>
        
    <div id="content">


	<!-- ############################# -->

	<ul class="xoxo">
    <?php
	
		dynamic_sidebar( 'main-page-widget-area' );
		$show_latest_prj = true;
		$show_latest_prj = apply_filters('ProjectTheme_show_latest_projects_index', $show_latest_prj);
		
		
		if($show_latest_prj == true):
		
	?>

        <li class="widget-container latest-posted-jobs-big">
        
        <?php get_template_part('latest-projects' ); ?>
        
        </li>
        <?php endif; ?>
	</ul>

	<!-- ##### -->
	</div>

	<?php if($ProjectTheme_home_page_layout != "5" && $ProjectTheme_home_page_layout != "4"): ?>
	
    <div id="right-sidebar">
		<ul class="xoxo">
	 <?php dynamic_sidebar( 'home-right-widget-area' ); ?>
		</ul>
       </div>

	<?php endif; ?>
    
    
    <?php
	
		if($ProjectTheme_home_page_layout == "2" ):
			
			    echo '<div id="left-sidebar">';
					echo '<ul class="xoxo">';
				 		dynamic_sidebar( 'home-left-widget-area' ); 
					echo '</ul>';
				   echo '</div>';
		
		endif;
		
	
	?>
    
    </div>
    </div>
   
    
<?php

		get_footer();

?>