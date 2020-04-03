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


	global $current_user, $wp_query;
	$pid 	=  $wp_query->query_vars['pid'];

	function ProjectTheme_filter_ttl($title){return __("Edit Project",'ProjectTheme')." - ";}
	add_filter( 'wp_title', 'ProjectTheme_filter_ttl', 10, 3 );

	if(!is_user_logged_in()) { wp_redirect( home_url()."/wp-login.php"); exit; }


	$current_user=wp_get_current_user();

	$post = get_post($pid);

	$uid 	= $current_user->ID;
	$title 	= $post->post_title;
	$cid 	= $current_user->ID;

	if($uid != $post->post_author) { echo 'Not your post. Sorry!'; exit; }

	//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

			global $wpdb,$wp_rewrite,$wp_query;


		$post = get_post($pid);

		if(isset($_POST['save-project']))
		{
			$project_tags 			= trim($_POST['project_tags']);
			wp_set_post_tags( $pid, $project_tags);

			//--------------------------------

			if(is_array($_POST['custom_field_id']))
			for($i=0;$i<count($_POST['custom_field_id']);$i++)
			{
				$id = $_POST['custom_field_id'][$i];
				$valval = $_POST['custom_field_value_'.$id];

				if(is_array($valval))
				{
					delete_post_meta($pid, 'custom_field_ID_'.$id);

					for($k=0;$k<count($valval);$k++)
						add_post_meta($pid, 'custom_field_ID_'.$id, $valval[$k]);
				}
				else
				update_post_meta($pid, 'custom_field_ID_'.$id, $valval);
			}

			//------------------------------
			$end 					= trim($_POST['ending']);

			if(empty($end)) $ending = current_time('timestamp',0) + 30*3600*24;
			else $ending = strtotime($end, current_time('timestamp',0));

			$projectTheme_project_period = get_option('projectTheme_project_period');
			if(!empty($projectTheme_project_period))
			{
				$ending1 = current_time('timestamp',0) + $projectTheme_project_period*3600*24;
				if($ending > $ending1) $ending = $ending1;
				if($ending < current_time('timestamp',0)) $ending = $ending1;
			}

			if($ending < current_time('timestamp',0)) $ending = current_time('timestamp',0) + 30*3600*24;


			$finalised_posted = get_post_meta(get_the_ID(),'finalised_posted',true);
			if($finalised_posted != "1")
			update_post_meta($pid, "ending", 		$ending); // ending date for the project

			//------------------------------

			$project_title = trim($_POST['project_title']);
			$project_description = trim(nl2br(strip_tags($_POST['project_description'])));

			  $features_not_paid = array();
			  $ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);

			  if(!empty($_POST['project_location_addr']))
			  update_post_meta($pid, "Location", $_POST['project_location_addr']);


			 if(!empty($_POST['budgets']))
			 update_post_meta($pid, "budgets", $_POST['budgets']);

			 update_post_meta($pid, "price", 		ProjectTheme_get_budget_name_string_fromID($_POST['budgets'])); // set project price

			 $type = get_option('ProjectTheme_budget_option');
		 		if($type == "input_box")
		 		{
		 					update_post_meta($pid, "price", 		$_POST['budgets']); // set project price
		 		}

				//==========

			  $my_post = array();
			  $my_post['ID'] = $pid;
			  $my_post['post_content'] = $project_description;
			  $my_post['post_title']   = $project_title;

			  wp_update_post( $my_post );


			//***************************************************

			$project_location 			= trim($_POST['project_location_cat']);
			$term 						= get_term( $project_location, 'project_location' );
			$project_location 			= $term->slug;
			$arr_cats 					= array();
			$arr_cats[] 				= $project_location;

			if(!empty($_POST['subloc']))
			{
				$term = get_term( $_POST['subloc'], 'project_location' );
				$jb_category2 = $term->slug;
				$arr_cats[] = $jb_category2;

			}

			if(!empty($_POST['subloc2']))
			{
				$term = get_term( $_POST['subloc2'], 'project_location' );
				$jb_category2 = $term->slug;
				$arr_cats[] = $jb_category2;

			}

			wp_set_object_terms($pid, $arr_cats ,'project_location');

      //--- skills-----------------------


      $slg_arr = array();
      foreach($_POST['project_skill_cat_multi'] as $ct)
      {
        $term 			= get_term( $ct, 'project_skill' );
        $project_category 	= $term->slug;
        $slg_arr[] 		= $project_category;
      }


      wp_set_object_terms($pid, $slg_arr,'project_skill');


			//*****************************************
			// setting the categories
			$project_category = $_POST['project_cat_cat'];

				if(get_option('ProjectTheme_enable_multi_cats') == "yes")
				{
					$slg_arr = array();
					foreach($_POST['project_cat_cat_multi'] as $ct)
					{
						$term 			= get_term( $ct, 'project_cat' );
						$project_category 	= $term->slug;
						$slg_arr[] 		= $project_category;
					}


					wp_set_object_terms($pid, $slg_arr,'project_cat');
				}
				else
				{

					$term 						= get_term( $project_category, 'project_cat' );
					$project_category 			= $term->slug;
					$arr_cats 					= array();
					$arr_cats[] 				= $project_category;


					if(!empty($_POST['subcat']))
					{
						$term = get_term( $_POST['subcat'], 'project_cat' );
						$jb_category2 = $term->slug;
						$arr_cats[] = $jb_category2;

					}


					wp_set_object_terms($pid, $arr_cats ,'project_cat');

				}



			$not_OK_to_just_publish = 2;

			//-----------------------------------
			// see if the project was featured

			if(isset($_POST['featured'])) update_post_meta($pid, "featured", "1");
			else update_post_meta($pid, "featured", "0");

			//-----------------------------------
			// mark the project for private bids if selected

			if(isset($_POST['private_bids'])) update_post_meta($pid, "private_bids", "1");
			else update_post_meta($pid, "private_bids", "0");


			// mark the project hidden from search engines or people not logged in

			if(isset($_POST['hide_project'])) update_post_meta($pid, "hide_project", "1");
			else update_post_meta($pid, "hide_project", "0");

			$features_not_paid = array();


			//-------------------------------------------------------------

			$base_fee_paid 	= get_post_meta($pid, 'base_fee_paid', true);
			$base_fee 		= get_option('projectTheme_base_fee');

			//--------------------------------------------

			$catid = ProjectTheme_get_project_primary_cat($pid);

			$custom_set = get_option('projectTheme_enable_custom_posting');
			if($custom_set == 'yes')
			{
				$base_fee = get_option('projectTheme_theme_custom_cat_'.$catid);
				if(empty($base_fee)) $base_fee = 0;
			}

			//--------------------------------------------
			$payment_arr = array();

			if($base_fee_paid != "1" && $base_fee > 0)
			{
				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost for base fee','ProjectTheme');
				$new_feature_arr[1] = $base_fee;
				array_push($features_not_paid, $new_feature_arr);

				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'base_fee';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $base_fee;
				$my_small_arr['description'] 	= __('Base Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}

			if($ProjectTheme_get_images_cost_extra > 0)
			{
				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'extra_img';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $ProjectTheme_get_images_cost_extra;
				$my_small_arr['description'] 	= __('Extra Images Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}

			//-------- Featured Project Check --------------------------

			$featured 		= get_post_meta($pid, 'featured', true);
			$featured_paid 	= get_post_meta($pid, 'featured_paid', true);
			$feat_charge 	= get_option('projectTheme_featured_fee');



			if($featured == "1" && $featured_paid != "1" && $feat_charge > 0)
			{
				$not_OK_to_just_publish = 1;

				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost to make project featured','ProjectTheme');
				$new_feature_arr[1] = $feat_charge;
				array_push($features_not_paid, $new_feature_arr);

				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'feat_fee';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $feat_charge;
				$my_small_arr['description'] 	= __('Featured Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}

			//---------- Private Bids Check -----------------------------

			$private_bids 		= get_post_meta($pid, 'private_bids', true);
			$private_bids_paid 	= get_post_meta($pid, 'private_bids_paid', true);

			$projectTheme_sealed_bidding_fee = get_option('projectTheme_sealed_bidding_fee');
			if(!empty($projectTheme_sealed_bidding_fee))
			{
				$opt = get_post_meta($pid,'private_bids',true);
				if($opt == "0") $projectTheme_sealed_bidding_fee = 0;
			}


			if(($private_bids == "1" or $private_bids == "yes") && $private_bids_paid != "1" && $projectTheme_sealed_bidding_fee > 0)
			{
				$not_OK_to_just_publish = 1;

				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost to add sealed bidding','ProjectTheme');
				$new_feature_arr[1] = $projectTheme_sealed_bidding_fee;
				array_push($features_not_paid, $new_feature_arr);

				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'sealed_project';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $projectTheme_sealed_bidding_fee;
				$my_small_arr['description'] 	= __('Sealed Bidding Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}


			//---------- Hide Project Check -----------------------------

			$hide_project 		= get_post_meta($pid, 'hide_project', true);
			$hide_project_paid 	= get_post_meta($pid, 'hide_project_paid', true);

			$projectTheme_hide_project_fee = get_option('projectTheme_hide_project_fee');
			if(!empty($projectTheme_hide_project_fee))
			{
				$opt = get_post_meta($pid,'hide_project',true);
				if($opt == "0") $projectTheme_hide_project_fee = 0;
			}


			if(($hide_project == "1" or $hide_project == "yes") && $hide_project_paid != "1" && $projectTheme_hide_project_fee > 0)
			{
				$not_OK_to_just_publish = 1;

				$new_feature_arr = array();
				$new_feature_arr[0] = __('Cost to hide project from search engines','ProjectTheme');
				$new_feature_arr[1] = $projectTheme_hide_project_fee;
				array_push($features_not_paid, $new_feature_arr);

				$my_small_arr = array();
				$my_small_arr['fee_code'] 		= 'hide_project';
				$my_small_arr['show_me'] 		= true;
				$my_small_arr['amount'] 		= $projectTheme_hide_project_fee;
				$my_small_arr['description'] 	= __('Hide Project From Search Engines Fee','ProjectTheme');
				array_push($payment_arr, $my_small_arr);
			}

			$ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);


			if($ProjectTheme_get_images_cost_extra > 0)
			{
				$not_OK_to_just_publish = 1;

				$new_feature_arr = array();
				$new_feature_arr[0] = __('Extra images cost','ProjectTheme');
				$new_feature_arr[1] = $ProjectTheme_get_images_cost_extra;
				array_push($features_not_paid, $new_feature_arr);
			}

			$payment_arr = apply_filters('ProjectTheme_filter_payment_array', $payment_arr, $pid);

			$my_total = 0;
			if(count($payment_arr) > 0)
			foreach($payment_arr as $payment_item):
				if($payment_item['amount'] > 0):
					$my_total += $payment_item['amount'];
				endif;
			endforeach;



			$my_total = apply_filters('ProjectTheme_filter_payment_total', $my_total, $pid);

			//---------------------

			$projectTheme_admin_approves_each_project = get_option('projectTheme_admin_approves_each_project');
			if($my_total > 0) $not_OK_to_just_publish = 1;

			if($not_OK_to_just_publish == 1 or $projectTheme_admin_approves_each_project == "yes")
			{

				$my_post = array();
				$my_post['ID'] = $pid;
				$my_post['post_status'] = 'draft';

				wp_update_post( $my_post );

			}
			else
			{

				$my_post = array();
				$my_post['ID'] = $pid;
				$my_post['post_status'] = 'publish';

				wp_update_post( $my_post );

			}
		}





		$cid = $uid;


//-------------------------------------

	get_header();
	do_action('ProjectTheme_happen_here_on_edit_proj');

?>



								  <div class="page_heading_me_project pt_template_page_1 " id="pt_template_page_1">
								                            <div class="page_heading_me_inner page_heading_me_inner_project container" > <div class="row">
								                            <div class="main-pg-title col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
								                                <div class="mm_inn mm_inn21"><?php printf(__("Edit Project - %s", 'ProjectTheme'), $post->post_title); ?> </div>
								                  </div></div></div></div>


<!-- ########## -->

<div class="container pt-4">

<?php 			do_action('pt_for_demo_work_3_0'); ?>

  <?php pt_account_main_menu_new(); ?>

<div class="row">



	<?php ProjectTheme_get_users_links(); ?>

<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">




                 <!-- ########################################### -->
                <?php

				$projectTheme_admin_approves_each_project = get_option('projectTheme_admin_approves_each_project');

				if($not_OK_to_just_publish == 2) //ok published
				{
					$finalised_posted = get_post_meta($pid,'finalised_posted',true);
					if($finalised_posted == "1") $sk_step = 3; else $sk_step = "1";

               		$finalised_posted = apply_filters('ProjectTheme_edit_prj_finalised_posted', $finalised_posted);

						if($projectTheme_admin_approves_each_project == "yes"):

							if($finalised_posted != 1)
							{
								echo '<div class="alert alert-success"><div class="padd10">';
								echo sprintf(__('Your project has been updated but is not live. To make your project live you must <b><a href="%s">publish</a></b> it first.','ProjectTheme'),
								 ProjectTheme_post_new_with_pid_stuff_thg($pid,1));
								echo '</div></div>';
							}
							else
							{
								echo '<div class="alert alert-success"><div class="padd10">';
								echo sprintf(__('Your project has been updated and but is not live. The admin must approve it before it goes live.','ProjectTheme'));
								echo '</div></div>';
							}

						else:
							if($finalised_posted != 1)
							{
								echo '<div class="alert alert-success"><div class="padd10">';
								echo sprintf(__('Your project has been updated but is not live. To make your project live you must <b><a href="%s">publish</a></b> it first.','ProjectTheme'),
								 ProjectTheme_post_new_with_pid_stuff_thg($pid,1));
								echo '</div></div>';

							}
							else
							{

								echo '<div class="alert alert-success"><div class="padd10">';
								echo sprintf(__('Your project has been updated and is live now. <a href="%s"><strong>Click here</strong></a> to see your project.','ProjectTheme'), get_permalink($pid));
								echo '</div></div>';

							}

						endif;

				}

				elseif($not_OK_to_just_publish == 2) //ok published
				{
					echo '<div class="alert alert-success"><div class="padd10">';
					echo sprintf(__('Your project has been updated and is live now. <a href="%s"><strong>Click here</strong></a> to see your project.','ProjectTheme'), get_permalink($pid));
					echo '</div></div>';
				}

				elseif($not_OK_to_just_publish == 1)
				{
						$finalised_posted = get_post_meta($pid,'finalised_posted',true);
						if($finalised_posted == "1") $sk_step = 3; else $sk_step = "1";
						//echo $finalised_posted;

						$finalised_posted = apply_filters('ProjectTheme_edit_prj_finalised_posted_2', $finalised_posted, $my_total);

						if($finalised_posted != 1)
						{

							echo '<div class="alert alert-success"><div class="padd10">';
								echo sprintf(__('Your project has been updated but is not live. To make your project live you must <b><a href="%s">publish</a></b> it first.','ProjectTheme'),
								 ProjectTheme_post_new_with_pid_stuff_thg($pid,1));
								echo '</div></div>';

						}
						else
						{

						echo '<div class="alert alert-success"><div class="padd10">';
						echo __('You have added extra options to your project. In order to publish your project you need to pay for the options.','ProjectTheme');
						echo '<br/><br/><table width="100%">';

						$ttl = 0;

						foreach($payment_arr as $payment_item):

							$feature_cost 			= $payment_item['amount'];
							$feature_description 	= $payment_item['description'];


							echo '<tr>';
							echo '<td width="320">'.$feature_description.'</td>';
							echo '<td>'.projectTheme_get_show_price($feature_cost,2).'</td>';
							echo '</tr>';

						endforeach;

							echo '<tr>';
							echo '<td width="320"><b>'.__('Total','ProjectTheme').'</b></td>';
							echo '<td>'.projectTheme_get_show_price($my_total,2).'</td>';
							echo '</tr>';


							echo '<tr>';
							echo '<td><strong>'.__('Your Total Credits','ProjectTheme').'</strong></td>';
							echo '<td><strong>'.ProjectTheme_get_show_price(ProjectTheme_get_credits($uid),2).'</strong></td>';
							echo '</tr>';

						echo '</table><br/><br/>';

						$ProjectTheme_enable_credits_wallet = get_option('ProjectTheme_enable_credits_wallet');
						if($ProjectTheme_enable_credits_wallet != 'no'):
							echo '<a href="'.home_url().'/?p_action=credits_listing&pid='.$pid.'" class="btn btn-primary">'.__('Pay by eWallet','ProjectTheme').'</a> ';
						endif;

						global $project_ID;
						$project_ID = $pid;

						//-------------------

						$ProjectTheme_paypal_enable 		= get_option('ProjectTheme_paypal_enable');
						$ProjectTheme_alertpay_enable 		= get_option('ProjectTheme_alertpay_enable');
						$ProjectTheme_moneybookers_enable 	= get_option('ProjectTheme_moneybookers_enable');

						if($ProjectTheme_paypal_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=paypal_listing&pid='.$pid.'" class="btn btn-primary">'.__('Pay by PayPal','ProjectTheme').'</a> ';

						if($ProjectTheme_moneybookers_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=mb_listing&pid='.$pid.'" class="btn btn-primary">'.__('Pay by MoneyBookers/Skrill','ProjectTheme').'</a> ';

						if($ProjectTheme_alertpay_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=payza_listing&pid='.$pid.'" class="btn btn-primary">'.__('Pay by Payza','ProjectTheme').'</a> ';

						do_action('ProjectTheme_add_payment_options_to_edit_project', $pid);

						echo '</div></div>';

						}
				}




				?>
				<div class="card">



						<div class="box_content">

                 	<form method="post">
                    <?php

	$post 		 	= get_post($pid);
	$location 		= wp_get_object_terms($pid, 'project_location', array('order' => 'ASC', 'orderby' => 'term_id' ));
	$cat 			= wp_get_object_terms($pid, 'project_cat', array('order' => 'ASC', 'orderby' => 'term_id' ));

	$bids_number  = projectTheme_number_of_bid($pid);

					?>

    <ul class="post-new">
            <li>
        	<h2><?php echo __('Your project title','ProjectTheme'); ?>:</h2>
        	<p><input type="text" size="50" class="form-control full_wdth_me" name="project_title"
            value="<?php echo (empty($_POST['project_title']) ?
			($post->post_title == "draft project" ? "" : $post->post_title) : $_POST['project_title']); ?>" /></p>
        </li>

             <script>

									function display_subcat(vals)
									{
										jQuery.post("<?php echo esc_url( home_url() ) ; ?>/?get_subcats_for_me=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {

												$('#sub_cats').html(data);

											}
										});

									}

									function display_subcat2(vals)
									{
										jQuery.post("<?php echo esc_url( home_url() )  ?>/?get_locscats_for_me=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {

												jQuery('#sub_locs').html(data);
												jQuery('#sub_locs2').html("&nbsp;");

											}
											else
											{
												jQuery('#sub_locs').html("&nbsp;");
												jQuery('#sub_locs2').html("&nbsp;");
											}
										});

									}

									function display_subcat3(vals)
									{
										jQuery.post("<?php echo esc_url( home_url() )  ?>/?get_locscats_for_me2=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {

												jQuery('#sub_locs2').html(data);

											}
										});

									}


									</script>

                  <li>
                  	<h2><?php echo __('Category','ProjectTheme'); ?>:</h2>
                  	<p class="strom_100">



                      <?php if(get_option('ProjectTheme_enable_multi_cats') == "yes"): ?>
          			<div class="multi_cat_placeholder_thing">

                      	<?php

          					$selected_arr = ProjectTheme_build_my_cat_arr($pid);
          					echo projectTheme_get_categories_multiple('project_cat', $selected_arr);

          				?>

                      </div>

                      <?php else: ?>

          			<?php

          			 	echo projectTheme_get_categories_clck("project_cat",
                                          !isset($_POST['project_cat_cat']) ? (is_array($cat) ? $cat[0]->term_id : "") : htmlspecialchars($_POST['project_cat_cat'])
                                          , __('Select Category','ProjectTheme'), "form-control", 'onchange="display_subcat(this.value)"' );


          								echo '<br/><span id="sub_cats">';


          											if(!empty($cat[1]->term_id))
          											{
          												$args2 = "orderby=name&order=ASC&hide_empty=0&parent=".$cat[0]->term_id;
          												$sub_terms2 = get_terms( 'project_cat', $args2 );

          												$ret = '<select class="form-control" name="subcat">';
          												$ret .= '<option value="">'.__('Select Subcategory','ProjectTheme'). '</option>';
          												$selected1 = $cat[1]->term_id;

          												foreach ( $sub_terms2 as $sub_term2 )
          												{
          													$sub_id2 = $sub_term2->term_id;
          													$ret .= '<option '.($selected1 == $sub_id2 ? "selected='selected'" : " " ).' value="'.$sub_id2.'">'.$sub_term2->name.'</option>';

          												}
          												$ret .= "</select>";
          												echo $ret;


          											}

          										echo '</span>';

          			 ?>
                      <?php endif; ?>


                      </p>
                  </li>



                  <!-- <li>
                  	<h2><?php echo __('Skills','ProjectTheme'); ?>:</h2>
                  	<p class="strom_100">
          			<div class="multi_cat_placeholder_thing">
                      	<?php

          					$selected_arr = ProjectTheme_build_my_cat_arr_skill($pid);
          					echo projectTheme_get_categories_multiple('project_skill', $selected_arr);

          				?>
                      </div>
                      </p>
                  </li> -->

        <?php

			$finalised_posted = get_post_meta($pid,'finalised_posted',true);
			if($finalised_posted != "1"):
		?>


         <li>
        <h2>



		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>



        <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ui_thing.css" />
		<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/timepicker.js"></script>

		<?php

	   $dt = get_post_meta($pid,'ending',true);

	   if(!empty($dt))
	   $dt = date_i18n('d-m-Y H:i',$dt);

	   ?>

       <?php _e("Project Ending On",'ProjectTheme'); ?>:</h2>
       <p><input type="text" name="ending" id="ending" class="form-control full_wdth_me" value="<?php echo $dt; ?>"  /></p>
       </li>

 		<script>
		<?php

			$dd = get_option('projectTheme_project_period');
			if(empty($dd)) $dd = 7;

		?>

			var myDate=new Date();
			myDate.setDate(myDate.getDate()+<?php echo $dd; ?>);

			$(document).ready(function() {
				 $('#ending').datetimepicker({
				showSecond: false,
				timeFormat: 'hh:mm:ss',

					currentText: '<?php _e('Now','ProjectTheme'); ?>',
					closeText: '<?php _e('Done','ProjectTheme'); ?>',
					ampm: false,
					timeFormat: 'hh:mm tt',
					timeSuffix: '',
					maxDateTime: myDate,
					timeOnlyTitle: '<?php _e('Choose Time','ProjectTheme'); ?>',
					timeText: '<?php _e('Time','ProjectTheme'); ?>',
					hourText: '<?php _e('Hour','ProjectTheme'); ?>',
					minuteText: '<?php _e('Minute','ProjectTheme'); ?>',
					secondText: '<?php _e('Second','ProjectTheme'); ?>',
					timezoneText: '<?php _e('Time Zone','ProjectTheme'); ?>'

			});});

 		</script>


        <?php  endif;

	$cid = $current_user->ID;


?>


    <!-- <li>
        	<h3><?php _e('Attach Images','ProjectTheme'); ?></h3>
        </li>

         <li>
        <div class="cross_cross">






    <script>


	jQuery(function() {

Dropzone.autoDiscover = false;
var myDropzoneOptions = {
  maxFilesize: 15,
    addRemoveLinks: true,
	acceptedFiles:'image/*',
    clickable: true,
	url: "<?php echo esc_url( home_url() ) ?>/?my_upload_of_project_files2=1",
};

var myDropzone = new Dropzone('div#myDropzoneElement2', myDropzoneOptions);

myDropzone.on("sending", function(file, xhr, formData) {
  formData.append("author", "<?php echo $cid; ?>"); // Will send the filesize along with the file as POST data.
  formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
});


    <?php

		$args = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'post_status'    => null,
	'post_mime_type' => 'image',
	'numberposts'    => -1,
	);
	$attachments = get_posts($args);

	if($pid > 0)
	if ($attachments)
	{
	    foreach ($attachments as $attachment)
		{
			$url = $attachment->guid;
			$imggg = $attachment->post_mime_type;
			$url = wp_get_attachment_url($attachment->ID);

				?>
						var mockFile = { name: "<?php echo $attachment->post_title ?>", size: 12345, serverId: '<?php echo $attachment->ID ?>' };
						myDropzone.options.addedfile.call(myDropzone, mockFile);
						myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo projectTheme_generate_thumb($attachment->ID, 100, 100) ?>");

				<?php
	 	}
	}

	?>

	myDropzone.on("success", function(file, response) {
    /* Maybe display some more file information on your page */
	 file.serverId = response;
	 file.thumbnail = "<?php echo get_template_directory_uri() ?>/images/file_icon.png";


  });


myDropzone.on("removedfile", function(file, response) {
    /* Maybe display some more file information on your page */
	  delete_this2(file.serverId);

  });

	});

	</script>



	<?php _e('Click the grey area below to add project images. Other files are not accepted. Use the form below.','ProjectTheme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement2" ></div>


	</div>
        </li> -->

        <li>
        	<h3><?php _e('Attach Files','ProjectTheme'); ?></h3>
        </li>


        <li>
        <div class="cross_cross">



	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dropzone.js"></script>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/dropzone.css" type="text/css" />




    <script>


	jQuery(function() {

Dropzone.autoDiscover = false;
var myDropzoneOptions = {
  maxFilesize: 15,
    addRemoveLinks: true,
	acceptedFiles:'.zip,.pdf,.rar,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.psd,.ai',
    clickable: true,
	url: "<?php echo esc_url( home_url() )  ?>/?my_upload_of_project_files_proj=1",
};

var myDropzone = new Dropzone('div#myDropzoneElement', myDropzoneOptions);

myDropzone.on("sending", function(file, xhr, formData) {
  formData.append("author", "<?php echo $cid; ?>"); // Will send the filesize along with the file as POST data.
  formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
});


    <?php

		$args = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'attachment',
	'meta_key' 		=> 'is_prj_file',
	'meta_value' 	=> '1',
	'post_parent'    => $pid,
	'post_status'    => null,
	'numberposts'    => -1,
	);
	$attachments = get_posts($args);

	if($pid > 0)
	if ($attachments) {
	    foreach ($attachments as $attachment) {
		$url = $attachment->guid;
		$imggg = $attachment->post_mime_type;

		if('image/png' != $imggg && 'image/jpeg' != $imggg)
		{
		$url = wp_get_attachment_url($attachment->ID);


			?>

					var mockFile = { name: "<?php echo $attachment->post_title ?>", size: 12345, serverId: '<?php echo $attachment->ID ?>' };
					myDropzone.options.addedfile.call(myDropzone, mockFile);
					myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo  get_template_directory_uri() ?>/images/file_icon.png");


			<?php


	}
	}}


	?>



myDropzone.on("success", function(file, response) {
    /* Maybe display some more file information on your page */
	 file.serverId = response;
	 file.thumbnail = "<?php echo  get_template_directory_uri() ?>/images/file_icon.png";


  });


myDropzone.on("removedfile", function(file, response) {
    /* Maybe display some more file information on your page */
	  delete_this2(file.serverId);

  });

	});

	</script>

    <script type="text/javascript">

	function delete_this2(id)
	{
		 jQuery.ajax({
						method: 'get',
						url : '<?php echo home_url();?>/index.php/?_ad_delete_pid='+id,
						dataType : 'text',
						success: function (text) {   jQuery('#image_ss'+id).remove();  }
					 });
		  //alert("a");

	}





	</script>

	<?php _e('Click the grey area below to add project files. Images are not accepted.','ProjectTheme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement" ></div>


	</div>
        </li>


        <?php if($bids_number == 0): ?>

        <li>
        	<h2><?php echo __('Price Range','ProjectTheme'); ?>:</h2>
        <p>
					<?php

 	 			$type = get_option('ProjectTheme_budget_option');

 	 			if($type == "input_box")
 	 			{
 	 					$sel = get_post_meta($pid, 'budgets', true);
 	 					?>

 	 					<input type="number" required size="50" class="form-control" name="budgets" placeholder="<?php echo ProjectTheme_get_currency() ?>" value="<?php echo $sel; ?>" />

 	 					<?php
 	 			}
 	 			else {



 	 				  $sel = get_post_meta($pid, 'budgets', true);
 	 				  echo ProjecTheme_get_budgets_dropdown($sel, 'form-control');


 	 				}

 	 	  ?>
        </p>
        </li>


        <?php endif; ?>

        <?php

			$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
			if($ProjectTheme_enable_project_location == "yes"):

		?>

        <!-- <li>
        	<h2><?php echo __('Location','ProjectTheme'); ?>:</h2>
           <p class="strom_100">



        <?php

			 	echo projectTheme_get_categories_clck("project_location",
                                !isset($_POST['project_location_cat']) ? (is_array($location) ? $location[0]->term_id : "") : htmlspecialchars($_POST['project_location_cat'])
                                , __('Select Location','ProjectTheme'), "form-control", 'onchange="display_subcat2(this.value)"' );


								echo '<br/><span id="sub_locs">';


											if(!empty($location[1]->term_id))
											{
												$args2 = "orderby=name&order=ASC&hide_empty=0&parent=".$location[0]->term_id;
												$sub_terms2 = get_terms( 'project_location', $args2 );

												$ret = '<select class="form-control" name="subloc">';
												$ret .= '<option value="">'.__('Select SubLocation','ProjectTheme'). '</option>';
												$selected1 = $location[1]->term_id;

												foreach ( $sub_terms2 as $sub_term2 )
												{
													$sub_id2 = $sub_term2->term_id;
													$ret .= '<option '.($selected1 == $sub_id2 ? "selected='selected'" : " " ).' value="'.$sub_id2.'">'.$sub_term2->name.'</option>';

												}
												$ret .= "</select>";
												echo $ret;


											}

										echo '</span>';


										echo '<br/><span id="sub_locs2">';


											if(!empty($location[2]->term_id))
											{
												$args2 = "orderby=name&order=ASC&hide_empty=0&parent=".$location[1]->term_id;
												$sub_terms2 = get_terms( 'project_location', $args2 );

												$ret = '<select class="form-control" name="subloc2">';
												$ret .= '<option value="">'.__('Select SubLocation','ProjectTheme'). '</option>';
												$selected1 = $location[2]->term_id;

												foreach ( $sub_terms2 as $sub_term2 )
												{
													$sub_id2 = $sub_term2->term_id;
													$ret .= '<option '.($selected1 == $sub_id2 ? "selected='selected'" : " " ).' value="'.$sub_id2.'">'.$sub_term2->name.'</option>';

												}
												$ret .= "</select>";
												echo $ret;


											}

										echo '</span>';

			 ?>







        </p>
        </li> -->

        <!-- <li>
        	<h2><?php echo __('Address','ProjectTheme'); ?>:</h2>
        <p><input type="text" size="50" class="form-control full_wdth_me"  name="project_location_addr" value="<?php echo !isset($_POST['project_location_addr']) ?
		get_post_meta($pid, 'Location', true) : $_POST['project_location_addr']; ?>" /> </p>
        </li>

        <?php endif; ?>

        <?php

						   	$ProjectTheme_enable_featured_option = get_option('ProjectTheme_enable_featured_option');
						   	if($ProjectTheme_enable_featured_option != "no"):

						   ?>

        <li> -->
        <h2><?php _e("Feature project?",'ProjectTheme'); ?>:</h2>
        <p><input type="checkbox" class="do_inputv" name="featured" value="1"
		<?php $feature = get_post_meta($pid, 'featured', true); echo ($feature == "1" ? "checked='checked'" : ""); ?> />
        <?php _e("By clicking this checkbox you mark your project as featured. Extra fee is applied.", 'ProjectTheme'); ?></p>
        </li>
        <?php endif; ?>


        <?php

						   	$ProjectTheme_enable_sealed_option = get_option('ProjectTheme_enable_sealed_option');
						   	if($ProjectTheme_enable_sealed_option != "no"):

						   ?>
        <li>
        <h2><?php _e("Sealed Bidding?",'ProjectTheme'); ?>:</h2>
        <p><input type="checkbox" class="do_inputv" name="private_bids" value="1"
        <?php $private_bids = get_post_meta($pid, 'private_bids', true); echo ($private_bids == "1" ? "checked='checked'" : ""); ?> />
        <?php _e("By clicking this checkbox you hide your project's bids. Extra fee is applied.", 'ProjectTheme'); ?></p>
        </li>
        <?php endif; ?>


        <?php

						   	$ProjectTheme_enable_hide_option = get_option('ProjectTheme_enable_hide_option');
						   	if($ProjectTheme_enable_hide_option != "no"):

						   ?>
        <li>
        <h2><?php _e("Hide from search engines",'ProjectTheme'); ?>:</h2>
        <p><input type="checkbox" class="do_inputv" name="hide_project" value="1"
        <?php $hide_project = get_post_meta($pid, 'hide_project', true); echo ($hide_project == "1" ? "checked='checked'" : ""); ?>/>
        <?php _e("By clicking this checkbox you hide your project from search engines. Extra fee is applied.", 'ProjectTheme'); ?></p>
        </li>
        <?php endif; ?>






        <!-- <li>
        	<h2><?php echo __('Description','ProjectTheme'); ?>:</h2>
        <p><textarea rows="6" cols="60" class="form-control full_wdth_me description_edit"  name="project_description"><?php
		echo empty($_POST['project_description']) ? str_replace("<br />", "", $post->post_content) : $_POST['project_description']; ?></textarea></p>
        </li>


	<?php
		$cat 		  	= wp_get_object_terms($pid, 'project_cat');
		$catidarr 		= $cat[0]->term_id;


		$arr 	= ProjectTheme_get_project_category_fields($catidarr, $pid);

		if(is_array($arr))
		for($i=0;$i<count($arr);$i++)
		{

			        echo '<li>';
					echo '<h2>'.$arr[$i]['field_name'].$arr[$i]['id'].':</h2>';
					echo '<p>'.$arr[$i]['value'];
					do_action('ProjectTheme_step3_after_custom_field_'.$arr[$i]['id'].'_field');
					echo '</p>';
					echo '</li>';


		}

	?>


         <?php do_action('ProjectTheme_step1_before_tags');
		$project_tags = '';
		$t = wp_get_post_tags($post->ID);
		foreach($t as $tags)
		{
			$project_tags .= $tags->name . ", ";
		}


		?>
		<li> -->
        	<h2><?php echo __('Tags', 'ProjectTheme'); ?>:</h2>
        <p><input type="text" size="50" class="form-control full_wdth_me"  name="project_tags" value="<?php echo $project_tags; ?>" /> </p>
        </li>

        <li>
        <h2>&nbsp;</h2>
        <p><input type="submit" name="save-project" value="<?php _e("Save Project",'ProjectTheme'); ?>" class="btn btn-primary" /></p>
        </li>



		</ul>
          </form>

                </div>
                </div>
                </div>




 </div> </div>

<?php get_footer(); ?>
