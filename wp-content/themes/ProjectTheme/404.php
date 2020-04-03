<?php
/********************************************************************
*
*	ProjectTheme for WordPress - sitemile.com
*	http://sitemile.com/p/project
*	Copyright (c) 2012 sitemile.com
*	Coder: Saioc Dragos Andrei
*	Email: andreisaioc@gmail.com
*
*********************************************************************/



	get_header();

?>


<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
    	<div class="mm_inn">

						  <?php _e('Page not found','ProjectTheme') ?>


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






<div class="container mt-4">
		<div id="main" class="wrapper">


<div class="card p-4">

	<div class="padd10">
<?php _e('The requested page cannot be found. Maybe your project or page has not been approved yet.','ProjectTheme'); ?>

    </div>
    </div>


	</div>
	</div>
	<?php get_footer(); ?>
