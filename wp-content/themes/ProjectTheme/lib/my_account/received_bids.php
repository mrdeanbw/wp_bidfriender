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

function project_theme_my_account_received_bids_fnc()
{
		global $current_user, $wpdb, $wp_query;
		$current_user=wp_get_current_user();
		$uid = $current_user->ID;
    ob_start();

		do_action('pt_for_demo_work_3_0');


		pt_account_main_menu_new();

		do_action('pt_at_account_dash_top');



?><div class="row">   <?php ProjectTheme_get_users_links(); ?>


    	<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">

                <?php

				global $wp_query, $wpdb;

				$pg = $_GET['pg'];
				if(empty($pg)) $pg = 1;

				$nrRes = 8;
				$offset = ($pg-1)*$nrRes;

				//---------------

				$wpdb->show_errors = true;

				$s = "SELECT SQL_CALC_FOUND_ROWS distinct posts.ID, bids.id FROM  ".$wpdb->prefix."posts as posts ,  ".$wpdb->prefix."project_bids as bids,  ".$wpdb->prefix."postmeta as pmeta
				where posts.post_author='$uid' and pmeta.meta_key='is_new_project' and pmeta.meta_value='new' and pmeta.post_id=posts.ID and bids.pid=posts.ID ORDER BY bids.date_made desc  LIMIT ".$offset.", " . $nrRes;


				$r = $wpdb->get_results($s);

				$found_rows = "SELECT FOUND_ROWS() as XROWS";
	      $res2 = $wpdb->get_results($found_rows);


	      $fnd_rows = $res2[0]->XROWS;



	    //  $wpdb->print_error();

				// Get the results
				$ttl = $fnd_rows;
				$nrPages = ceil($ttl / $nrRes);




				if(count($r) > 0) :
				foreach($r as $row):
					projectTheme_get_post_received_proposal($row);
				endforeach;

				//--------


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


				//--------

				 else:
				echo ' <div class="card p-3">   ';
				_e("You do not have any proposals yet for your projects.",'ProjectTheme');
				echo '</div>   ';
				endif;

				wp_reset_query();

				?>




  		</div>	</div>
<?php


    $page = ob_get_contents();
    ob_end_clean();

    return $page;

}

?>
