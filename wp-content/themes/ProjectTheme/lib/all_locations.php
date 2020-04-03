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

function ProjectTheme_all_locations_area_main_function()
{


	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div class="card p-4">

								<script>
				jQuery(document).ready(function() {

		jQuery('.parent_taxe').click(function () {

			var rels = jQuery(this).attr('rel');
			jQuery("#" + rels).toggle();
			jQuery("#img_" + rels).attr("src","<?php echo get_template_directory_uri(); ?>/images/posted1.png");

			return false;
		});


});

				</script>
									 <?php

		$opt = get_option('ProjectTheme_show_subcats_enbl');

		if($opt == 'no')
		$smk_closed = "smk_closed_disp_none";
		else $smk_closed = '';

		//------------------------

		$arr = array();
				global $wpdb;

		$nr 		= 4;
		$terms 	= get_terms("project_location","parent=0&hide_empty=0");

		 $count = count($terms);
		 $t 		= 1;
		 $gather = '';

		 if ( $count > 0 ){

				 foreach ( $terms as $term ) {

				 if($t == 1)
				 {
						echo '<div class="row mb-4">';
				 }

				 $total_ads = ProjectTheme_get_custom_taxonomy_count2('project', $term->slug, 'project_location');


				 echo '<div class=" col-xs-12 col-md-5 col-lg-3 mb-4">';
						echo '<div class="category-box-thing">';

								echo '<h3 class="category-heading"><a class="category-main-link-list" href="'.get_term_link($term,"project_location").'">'.$term->name.' ('.$total_ads.')</a></h3>';

								$terms2 = get_terms("project_location","parent=".$term->term_id."&hide_empty=0");
								if($terms2)
								{

										echo '<ul class="subcats-here">';
										foreach ( $terms2 as $term2 )
										{
												$tt = ProjectTheme_get_custom_taxonomy_count2('project', $term2->slug, 'project_location');
												echo '<li class="item-element"><a href="'.get_term_link($term2,"project_location").'">'.$term2->name.' ('.$tt.')</a></li>';

										}

										echo '</ul>';
								}

						echo '</div>';
				 echo '</div>';


				 if($t == 4)
				 {
						echo '</div>



						';
						$t = 0;
				 }


				$t++;



				 }


		 }

				 //=======================================

				 if($t != 5 ) echo '</div>';


				 ?>



								</div>
								</div>




    <?php



}

?>
