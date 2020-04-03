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
if(!function_exists('ProjectTheme_display_provider_search_page_disp'))
{
function ProjectTheme_display_provider_search_page_disp()
{
    global $wpdb;
?>

<script>

 jQuery(document).ready(function() {
   jQuery("#filters-button-show-hide").click(function(){
     jQuery("#filter-optns").slideToggle();
   });
});



</script>

    	<div  class='row' >


        <div id="right-sidebar" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <ul class="sidebar-ul" id="search-page-ulz">

<li class="" id="filters-things">
<h3 class="widget-title"><?php _e('Filter Options','ProjectTheme'); ?></h3>

<a href="#" id="filters-button-show-hide"><i class="fas fa-filter"></i></a>

<form method="get" id="filter-optns">

  <div class="my_row_m1">
        <div class="full_width_m1"><?php _e('Username like:','ProjectTheme'); ?></div>
        <div class="full_width_m1"><input type="text"  class="do_input_search_provider form-control" value="<?php echo $_GET['username']; ?>" name="username" /></div>
  </div>


  <div class="my_row_m1">
        <div class="full_width_m1"><?php _e('Hourly rate:','ProjectTheme'); ?></div>
        <div class="full_width_m1">

            <select name="hourly" class="do_input_search_provider form-control" >
                <option value=""><?php _e('Select option','ProjectTheme'); ?></option>
                <option value="0_10" <?php echo $_GET['hourly'] == "0_10" ? "selected='selected'" : "" ?> >< <?php echo projecttheme_get_show_price("10") ?></a>
                <option value="10_40" <?php echo $_GET['hourly'] == "10_40" ? "selected='selected'" : "" ?> ><?php echo projecttheme_get_show_price("10") ?> - <?php echo projecttheme_get_show_price("40") ?></a>
                <option value="40_70" <?php echo $_GET['hourly'] == "40_70" ? "selected='selected'" : "" ?> ><?php echo projecttheme_get_show_price("40") ?> - <?php echo projecttheme_get_show_price("70") ?></a>
                <option value="70_100" <?php echo $_GET['hourly'] == "70_100" ? "selected='selected'" : "" ?> ><?php echo projecttheme_get_show_price("70") ?> - <?php echo projecttheme_get_show_price("100") ?></a>
                <option value="100_9999" <?php echo $_GET['hourly'] == "100_9999" ? "selected='selected'" : "" ?> ><?php echo projecttheme_get_show_price("100") ?> > </a>

            </select>

        </div>
  </div>



  <div class="my_row_m1">
        <div class="full_width_m1"><?php _e('Skills:','ProjectTheme'); ?></div>
        <div class="full_width_m1">

          <div class="multi_cat_placeholder_thing_search_provider">

                <?php
            //$selected_arr = projectTheme_build_my_cat_arr2($pid);
            $selected_arr = $_GET['project_skill_cat_multi'];
            echo projectTheme_get_categories_multiple2('project_skill', $selected_arr);

          ?>

          </div>
        </div>
  </div>



  <div class="my_row_m1">
        <div class="full_width_m1"><?php _e('Categories:','ProjectTheme'); ?></div>
        <div class="full_width_m1">

          <div class="multi_cat_placeholder_thing_search_provider">

                <?php
            //$selected_arr = projectTheme_build_my_cat_arr2($pid);
            $selected_arr = $_GET['project_cat_cat_multi'];
            echo projectTheme_get_categories_multiple2('project_cat', $selected_arr);

          ?>

          </div>
        </div>
  </div>



  <div class="my_row_m1">
        <div class="full_width_m1"><?php _e('Locations:','ProjectTheme'); ?></div>
        <div class="full_width_m1">

          <div class="multi_cat_placeholder_thing_search_provider">

                <?php
            $selected_arr = $_GET['project_location_cat_multi']; //projectTheme_build_my_cat_arr2($pid);
            echo projectTheme_get_categories_multiple2('project_location', $selected_arr);

          ?>

          </div>
        </div>
  </div>


  <div class="my_row_m1">
        <div class="full_width_m1"><?php _e('Online status?','ProjectTheme'); ?></div>
        <div class="full_width_m1"><input type="checkbox" value="1" name="online" <?php echo $_GET['online'] == "1" ? "checked='checked'" : "" ?>   /></div>
  </div>



                      <div class="my_row_m1"><div class="full_width_m1">
                        <input type="submit"  value="<?php _e('Search','ProjectTheme'); ?>" class="btn btn-primary"   name="search_provider" />
                      </div></div>



</form>

</li>

<?php dynamic_sidebar( 'other-page-area' ); ?>
</ul>
</div>

<!--############################## -->

    	<div   class='col-xs-12 col-sm-12 col-md-8 col-lg-8' >




                <div class="box_content " style="padding:0">
<?php

			$ProjectTheme_enable_2_user_tp = get_option('ProjectTheme_enable_2_user_tp');


			$pg = $_GET['pg'];
			if(empty($pg)) $pg = 1;

			$nrRes = 8;

			//------------------

			$offset = ($pg-1)*$nrRes;

			//------------------

						if(isset($_GET['username']))
				$args['search'] = "*".trim($_GET['username'])."*";


			// prepare arguments
			$args['orderby']  = 'display_name';
			$arr_aray = array();

      $inner = '';
      $where = '';

      if(!empty($_GET['hourly']))
			{
          $hr = explode("_", $_GET['hourly']);
          $min = $hr[0];
          $max = $hr[1];

          $inner .= ' INNER JOIN '.$wpdb->prefix.'usermeta ON ( '.$wpdb->prefix.'users.ID = '.$wpdb->prefix.'usermeta.user_id ) ';
          $where .= " AND   " .$wpdb->prefix."usermeta.meta_key = 'per_hour' AND " .$wpdb->prefix."usermeta.meta_value > $min AND " .$wpdb->prefix."usermeta.meta_value < $max ";

      }



			$rf_demo = true;
			$rf_demo = apply_filters("ProjectTheme_rf_demo", $rf_demo);

			if($ProjectTheme_enable_2_user_tp == "yes" and $rf_demo)
			{
				$arr_sbg = 	array(
						// uses compare like WP_Query
						'key' => 'user_tp',
						'value' => 'service_provider',
						'compare' => '='
						);

				array_push(	$arr_aray, 	$arr_sbg);

			}


			//-----------------------------------------------
      global $wpdb;
      $wpdb->show_errors = true;

      if(!empty($_GET['username']))
      {
        $us     = addslashes($_GET['username']);
        $inner .= ' INNER JOIN '.$wpdb->prefix.'usermeta AS mt2 ON ( '.$wpdb->prefix.'users.ID = mt2.user_id ) INNER JOIN '.$wpdb->prefix.'usermeta AS mt3 ON ( '.$wpdb->prefix.'users.ID = mt3.user_id ) ';
        $addition = " AND ( user_login like '%".$us."%' or (mt2.meta_key = 'first_name' AND mt2.meta_value LIKE '%".$us."%')
                or (mt3.meta_key = 'last_name' AND mt3.meta_value LIKE '%".$us."%')  ) ";

      }

      // skills here

      if(is_array($_GET['project_skill_cat_multi']))
      {
          if(count($_GET['project_skill_cat_multi']))
          {
                $inner .= ' INNER JOIN '.$wpdb->prefix.'project_freelancer_skills  AS mtskill ON ( '.$wpdb->prefix.'users.ID = mtskill.uid )  ';

                foreach($_GET['project_skill_cat_multi'] as $ux_cat)
                $where .= " AND    mtskill.catid = '$ux_cat' ";

          }

      }


      // categories here

      if(is_array($_GET['project_cat_cat_multi']))
      {
          if(count($_GET['project_cat_cat_multi']))
          {
                $inner .= ' INNER JOIN '.$wpdb->prefix.'project_email_alerts  AS mtcatt ON ( '.$wpdb->prefix.'users.ID = mtcatt.uid )  ';

                foreach($_GET['project_cat_cat_multi'] as $ux_cat)
                $where .= " AND    mtcatt.catid = '$ux_cat' ";

          }

      }


      // locations here

      if(is_array($_GET['project_location_cat_multi']))
      {
          if(count($_GET['project_location_cat_multi']))
          {
                $inner .= ' INNER JOIN '.$wpdb->prefix.'project_email_alerts_locs  AS mtlocss ON ( '.$wpdb->prefix.'users.ID = mtlocss.uid )  ';

                foreach($_GET['project_location_cat_multi'] as $ux_cat)
                $where .= " AND    mtlocss.catid = '$ux_cat' ";

          }

      }

      //---- main query here ----------


      $main_query = "SELECT SQL_CALC_FOUND_ROWS distinct ".$wpdb->prefix."users.* FROM ".$wpdb->prefix."users
      ".$inner."
      INNER JOIN ".$wpdb->prefix."usermeta AS mt1 ON ( ".$wpdb->prefix."users.ID = mt1.user_id )

      WHERE 1=1

      ".$where."
      AND    mt1.meta_key = '".$wpdb->prefix."capabilities' AND mt1.meta_value LIKE '%service\_provider%' ".$addition."  ORDER BY display_name ASC LIMIT ".$offset.", " . $nrRes;



      $res = $wpdb->get_results($main_query);
      $found_rows = "SELECT FOUND_ROWS() as XROWS";
      $res2 = $wpdb->get_results($found_rows);


      $fnd_rows = $res2[0]->XROWS;



    //  $wpdb->print_error();

			// Get the results
			$ttl = $fnd_rows;
			$nrPages = ceil($ttl / $nrRes);



			// Check for results
			if (count($res) > 0)
			{


				foreach ($res as $author)
				{

					// get all the user's data
          echo '<div class="card p-3 pt-4 pb-4">';
					ProjectTheme_get_user_table_row($author->ID);
          echo '</div>';
				}


				echo '<div class="div_class_div">';

				$totalPages = $nrPages;
				$my_page = $pg;
				$page = $pg;

				$batch = 10;
				$nrpostsPage = $nrRes;
				$end = $batch * $nrpostsPage;

				if ($end > $pagess) {
					$end = $pagess;
				}
				$start = $end - $nrpostsPage + 1;

				if($start < 1) $start = 1;

				$links = '';

				$raport = ceil($my_page/$batch) - 1; if ($raport < 0) $raport = 0;

				$start 		= $raport * $batch + 1;
				$end		= $start + $batch - 1;
				$end_me 	= $end + 1;
				$start_me 	= $start - 1;

				if($end > $totalPages) $end = $totalPages;
				if($end_me > $totalPages) $end_me = $totalPages;

				if($start_me <= 0) $start_me = 1;


				$previous_pg = $page - 1;
				if($previous_pg <= 0) $previous_pg = 1;

				$next_pg = $page + 1;
				if($next_pg > $totalPages) $next_pg = 1;




				if($my_page > 1)
				{
					echo '<a href="'.projectTheme_provider_search_link() .'pg='.$previous_pg.'" class="bighi"><< '.__('Previous','ProjectTheme').'</a>';
					echo '<a href="'.projectTheme_provider_search_link() .'pg='.$start_me.'" class="bighi"><<</a>';
				}

					for($i=$start;$i<=$end;$i++)
					{
						if($i == $pg)
						echo '<a href="#" class="bighi" id="activees">'.$i.'</a>';
						else
						echo '<a href="'.projectTheme_provider_search_link() .'pg='.$i.'" class="bighi">'.$i.'</a>';
					}

				if($totalPages > $my_page)
				echo '<a href="'.projectTheme_provider_search_link() .'pg='.$end_me.'" class="bighi"><i class="fas fa-chevron-right"></i></a>';

				if($page < $totalPages)
				echo '<a href="'.projectTheme_provider_search_link() .'pg='.$next_pg.'" class="bighi">'.__('Next','ProjectTheme').' <i class="fas fa-chevron-right"></i></a>';


				echo '</div>';

			} else {
        echo '<div class="my_box4">';
				echo __('No service providers found for this query.', 'ProjectTheme' );
        echo '</div>';
			}



?>



                </div>
                </div>

                <!-- ############## -->



</div>



   <?php
}}

?>
