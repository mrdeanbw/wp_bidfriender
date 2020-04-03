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


if(!is_user_logged_in()) { wp_redirect( home_url()."/wp-login.php"); exit; }
//-----------

	global $current_user;
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;


	//----------

	global $wpdb,$wp_rewrite,$wp_query;
	$bid_id = $_GET['id'];

	$s1 = "select * from ".$wpdb->prefix."project_bids where id='$bid_id'";
	$r = $wpdb->get_results($s1);

	if(count($r) == 0) die('error_bid_one_retract');
	if($r[0]->uid != $uid)  die('not yours to retract');

	//---------------------------------

	$pp = get_post($r[0]->pid);




	if(isset($_POST['submit']))
	{
		$sv_sv = $_POST['sv_sv'];
		if($sv_sv == "no")
		{
			wp_redirect(get_permalink($r[0]->pid));
			exit;
		}


		if($sv_sv == "yes")
		{
			$s1 = "delete from ".$wpdb->prefix."project_bids where id='$bid_id'";
			$wpdb->query($s1);

			delete_post_meta($r[0]->pid,'bid', $uid);

			wp_redirect(get_permalink($r[0]->pid));

			exit;
		}



		exit;
	}


//==========================

get_header();

?>


<div class="page_heading_me_project pt_template_page_1 " id="pt_template_page_1">
													<div class="page_heading_me_inner page_heading_me_inner_project container" > <div class="row">
													<div class="main-pg-title col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
															<div class="mm_inn mm_inn21"><?php  printf(__("Retract your bid of %s to project %s",'ProjectTheme'), projecttheme_get_show_price($r[0]->bid),  $pp->post_title ); ?></div>
								</div></div></div></div>







<div class="container mt-4">
		<div  class="row">

			<div class="card p-3">
            	<div class=" ">


            	<div class="box_title"><?php  printf(__("Are you sure you want to retract your bid ?",'ProjectTheme')); ?></div>
                <div class="box_content">


                <div class="clear10"></div>

               <form method="post" >

               <input type="radio" name="sv_sv" id="user_tp" value="yes" checked="checked" /> <?php _e('Yes', 'ProjectTheme'); ?><br/>
               <input type="radio" name="sv_sv" id="user_tp" value="no" /> <?php _e('No, get back','ProjectTheme'); ?><br/>

                <br/>

                <input type="submit" class="btn btn-primary" value="<?php _e('Submit your answer','ProjectTheme'); ?>" name="submit" />
				 

               </form>
    </div>
			</div>
			</div>
        </div>  </div>


        <div class="clear100"></div>


<?php

get_footer();

?>
