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


function ProjectTheme_my_account_area_main_function()
{


				global $current_user, $wp_query;
				$current_user=wp_get_current_user();

				$uid = $current_user->ID;


					do_action('pt_for_demo_work_3_0');


					pt_account_main_menu_new();

					do_action('pt_at_account_dash_top');

?>

<div class="row">
<div class="col-sm-12">

<?php

if(isset($_GET['payment_ok']))
{
			?>

						<div class="alert alert-success"><?php _e('Your payment was successful. You will receive an email shortly.','ProjectTheme') ?></div>

			<?php

}


if(isset($_GET['payment_ok_not']))
{
			?>

						<div class="alert alert-danger"><?php _e('There was an unknown error.','ProjectTheme') ?></div>

			<?php

}

 ?>


<div class="page-header">
              <h1 class="page-title">
                <?php echo sprintf(__('Welcome, %s','ProjectTheme'), project_theme_get_name_of_user($uid) ) ?>
              </h1>
            </div></div></div>

	<?php
	  	if(isset($_POST['instagram_submit'])) { 
			$username =  $_POST['instagram_username'];
			// echo $username;
			$password =  $_POST['instagram_password'];
			$curl = curl_init();
			curl_setopt_array($curl, array(
					CURLOPT_URL => "http://localhost:5000/v1/iguser",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS =>"{\n\t\"username\" : \"$username\",\n\t\"password\" : \"$password\"\n}",
					CURLOPT_HTTPHEADER => array(
						"Accept: application/json",
						"Content-Type: application/json",
					),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			$responseJson = json_decode($response, true);
			if ($responseJson['success']){
				$GLOBALS['instagram_username'] = $instagram_username = $username;
				$GLOBALS['instagram_post'] = $instagram_post = $responseJson['data']['posts'];
				$GLOBALS['instagram_followers'] = $instagram_followers = $responseJson['data']['followers'];
				$GLOBALS['instagram_following'] = $instagram_following = $responseJson['data']['following'];
			}
			else{
				$GLOBALS['instagram_form_err'] = true;
				$GLOBALS['instagram_err_message'] = $responseJson['message'];
			}
	  	} 
  	?> 
	<?php
		if ($GLOBALS['instagram_form_err'])
			echo
			'<div class="alert alert-danger" id="instagram_alert" style="display: block;">'.$GLOBALS['instagram_err_message'].'</div>'
	?>

	<form method="post" autocomplete="off" id="instagram_form">  
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					<label class="form-label" for="instagram_username" >Instagram Username</label>
					<input placeholder="Instagram User Name" type="text" size="35" id="instagram_username" name="instagram_username" value class="form-control">
				</div>
			</div>
			<div class="col-md-5">
				<div class="form-group">
					<label class="form-label" for="instagram_password" >Instagram Password</label>
					<input type="password" placeholder="Instagram User Password" type="text" size="35" id="instagram_password" value name="instagram_password" class="form-control">
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
				<label class="form-label">&nbsp&nbsp&nbsp</label>
					<!-- <a id="instagram_submit" name="instagram_submit" value="instagram_submit" style="display:block;color: white;" class="btn btn-primary">Submit</a> -->
					     
					<input type="submit" name="instagram_submit" style="display:block;color: white;" class="btn btn-primary"
                		value="Submit"/> 
					<!-- onclick="onSubmit()"  -->
				</div>
			</div>
		</div>
	</form> 
	<!-- Leon added -->


						<div class="row row-cards">

							<?php

							if(ProjectTheme_is_user_provider($uid)){

										do_action('stripe_connect_thing_notification');

							}

							 ?>


						              <div class="col-6 col-sm-4 col-lg-3">
						                <div class="card">
						                  <div class="card-body p-3 text-center">
																<div class="text-right text-green">
						                       &nbsp;
						                    </div>
						                    <div class="h1 m-0 text-success"><?php echo projectTheme_get_show_price(ProjectTheme_get_credits(get_current_user_id()), 0) ?></div>
						                    <div class="text-muted mb-4"><?php echo __('Your Balance','ProjectTheme') ?></div>
																<div class=""><a href="<?php echo get_permalink( get_option('ProjectTheme_my_account_payments_id') ); ?>" class="btn btn-secondary btn-sm"><?php echo __('Finances','ProjectTheme') ?></a></div>
						                  </div>
						                </div>
						              </div>
						              <div class="col-6 col-sm-4 col-lg-3">
						                <div class="card">
						                  <div class="card-body p-3 text-center">
																<div class="text-right text-green">
						                       &nbsp;
						                    </div>
						                    <div class="h1 m-0"><?php echo ProjectTheme_get_total_nr_of_open_projects_of_uid(get_current_user_id()) ?></div>
						                    <div class="text-muted mb-4"><?php echo __('All Open Projects','ProjectTheme') ?></div>
																<div class=""><a href="<?php echo get_permalink( get_option('') ); ?>" class="btn btn-secondary btn-sm"><?php echo __('My Projects','ProjectTheme') ?></a></div>
						                  </div>
						                </div>
						              </div>
						              <div class="col-6 col-sm-4 col-lg-3">
						                <div class="card">
						                  <div class="card-body p-3 text-center">
																<div class="text-right text-green">
						                       &nbsp;
						                    </div>
						                    <div class="h1 m-0"><?php echo projectTheme_get_unread_number_messages(get_current_user_id()) ?></div>
						                    <div class="text-muted mb-4"><?php echo __('Unread Messages','ProjectTheme') ?></div>
																<div class=""><a href="<?php echo get_permalink( get_option('ProjectTheme_my_account_private_messages_id') ); ?>" class="btn btn-secondary btn-sm"><?php echo __('Messages','ProjectTheme') ?></a></div>
						                  </div>
						                </div>
						              </div>
						              <div class="col-6 col-sm-4 col-lg-3">
						                <div class="card">
						                  <div class="card-body p-3 text-center">
						                    <div class="text-right text-green">
						                       &nbsp;
						                    </div>
						                    <div class="h1 m-0"><?php echo pt_show_unawarded_reviews(get_current_user_id()) ?></div>
						                    <div class="text-muted mb-4"><?php echo __('Reviews to award','ProjectTheme') ?></div>
																<div class=""><a href="<?php echo get_permalink( get_option('ProjectTheme_my_account_feedback_id') ); ?>" class="btn btn-secondary btn-sm"><?php echo __('Reviews','ProjectTheme') ?></a></div>
						                  </div>
						                </div>
						              </div>





						            </div>






<div class="row">

      <?php ProjectTheme_get_users_links();
					?>

    	<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">
<?php





if(ProjectTheme_is_user_business($uid)){


?>


<h3 class="my-account-headline-1"><?php echo __('My Latest Posted Projects','ProjectTheme'); ?></h3>






														<?php


																	 global $wp_query, $custom_post_project_type_name;
																	 $query_vars = $wp_query->query_vars;
																	 $post_per_page = 3;


																	 $closed = array(
																			 'key' => 'closed',
																			 'value' => "0",
																			 'compare' => '='
																		 );

																	/* $paid = array(
																			 'key' => 'paid',
																			 'value' => "1",
																			 'compare' => '='
																		 ); */

																	 $args = array('post_type' => $custom_post_project_type_name, 'author' => $uid, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
																	 'paged' => 1, 'meta_query' => array($paid, $closed), 'post_status' =>array('publish') );

																	 query_posts($args);



																	 if(have_posts()) :
																		 ?>



																		 <?php

																	 while ( have_posts() ) : the_post();

																		 projectTheme_get_post_acc();
																	 endwhile;

																	 $has_posted_yes = 1;

																	 ?>




																	 <?php

																		else:

																			echo '<div class="card section-vbox"><div class="padd10">';
																	 _e("There are no projects yet.",'ProjectTheme');
																	 echo '</div></div>';

																	 endif;

																	 wp_reset_query();


																	 ?>






												<?php
															if(!empty($has_posted_yes)) {  ?>

																<div class="row"><div class="col-sm-12 mb-5">
																		<a href="<?php echo get_permalink(get_option('ProjectTheme_my_account_active_projects_id')) ?>" class="btn btn-outline-secondary btn-sm"><?php _e("See all posted projects",'ProjectTheme'); ?></a>
															 </div></div>

																 <?php }
												 ?>



													<h3 class="my-account-headline-1"><?php echo __('My Unpublished &amp; Unpaid Projects','ProjectTheme'); ?></h3>





																			<?php

																			global $custom_post_project_type_name;

																			query_posts( "post_status=draft&meta_key=paid&meta_value=0&post_type=$custom_post_project_type_name&order=DESC&orderby=id&author=".$uid."&posts_per_page=3" );

																			if(have_posts()) :

																				?>


																												<?php


																			while ( have_posts() ) : the_post();
																				projectTheme_get_post_acc(array('unpaid'));
																			endwhile;

																				$has_unposted_yes = 1;

																			?>
																																			 </tbody></table>


																		 	<?php

																			else:

																				echo '			<div class="card section-vbox">
																								<div class="box_content">';
																			_e("There are no projects yet.",'ProjectTheme');

																			echo '</div></div>';

																			endif;

																			wp_reset_query();

																			?>





												 <?php
 															if(!empty($has_unposted_yes)) {  ?>

 																<div class="row"><div class="col-sm-12 mb-5">
 																		<a href="<?php echo get_permalink(get_option('ProjectTheme_my_account_unpublished_projects_id')) ?>" class="btn btn-outline-secondary btn-sm"><?php _e("See all unpublished projects",'ProjectTheme'); ?></a>
 															 </div></div>

 																 <?php }
 												 ?>




												 <h3 class="my-account-headline-1"><?php echo __('My Latest Closed Projects','ProjectTheme'); ?></h3>




												 				<?php

												 				query_posts( "meta_key=closed&meta_value=1&post_type=$custom_post_project_type_name&order=DESC&orderby=id&author=".$uid."&posts_per_page=3" );

												 				if(have_posts()) : ?>




																<?php


												 				while ( have_posts() ) : the_post();
												 					projectTheme_get_post_acc();
												 				endwhile;

																$has_closed_yes = 1;

												 				?>		 	<?php

												 				else:

																	echo '<div class="card section-vbox">
				 													 <div class="box_content">';
												 				_e("There are no projects yet.",'ProjectTheme');
																echo '</div></div>';

												 				endif;
												 				wp_reset_query();

												 				?>



													 <?php
	 															if(!empty($has_closed_yes)) {  ?>

	 																<div class="row"><div class="col-sm-12 mb-5">
	 																		<a href="<?php echo get_permalink(get_option('ProjectTheme_my_account_closed_projects_id')) ?>" class="btn btn-outline-secondary btn-sm"><?php _e("See all unpublished projects",'ProjectTheme'); ?></a>
	 															 </div></div>

	 																 <?php }	 ?>



											<?php } // end buyer side ?>



											<?php if(ProjectTheme_is_user_provider($uid)){ ?>


<?php

/*********************************************************************************************************************************
*
*			SECTion
*
*********************************************************************************************************************************/

?>

													<h3 class="my-account-headline-1"><?php echo __('Outstanding Projects','ProjectTheme'); ?></h3>





													<?php

													global $wp_query;
													$query_vars = $wp_query->query_vars;
													$post_per_page = 3;


													$outstanding = array(
															'key' => 'outstanding',
															'value' => "1",
															'compare' => '='
														);

													$winner = array(
															'key' => 'winner',
															'value' => $uid,
															'compare' => '='
														);

													$args = array('post_type' => $custom_post_project_type_name, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
													'paged' => 1, 'meta_query' => array($outstanding, $winner));


													query_posts( $args  );

													if(have_posts()) : ?>



																		 <?php

													while ( have_posts() ) : the_post();
														projectTheme_get_post_outstanding_project_function();
													endwhile; ?>


													<?php $has_outst_yes = 1;

													else:

														echo '<div class="card section-vbox"><div class="p-3">';
													_e("There are no projects yet.",'ProjectTheme');
													echo '</div></div>';


													endif;
													wp_reset_query();

													?>





												  <?php
															if(!empty($has_outst_yes)) {  ?>

																<div class="row"><div class="col-sm-12 mb-5">
																		<a href="<?php echo get_permalink(get_option('ProjectTheme_my_account_outstanding_projects_id')) ?>" class="btn btn-outline-secondary btn-sm"><?php _e("See all unpublished projects",'ProjectTheme'); ?></a>
															 </div></div>

														 <?php } else { echo '<div class="row clear10"></div>'; }	 ?>

<?php

/*********************************************************************************************************************************
*
*			SECTion
*
*********************************************************************************************************************************/

?>

			<h3 class="my-account-headline-1"><?php echo __('My Latest Posted Proposals','ProjectTheme'); ?></h3>



			<?php

			query_posts( "meta_key=bid&meta_value=".$uid."&post_type=$custom_post_project_type_name&order=DESC&orderby=id&posts_per_page=3" );

			if(have_posts()) : ?>


								 <?php


							while ( have_posts() ) : the_post();
								projectTheme_get_post_my_proposal();
							endwhile;  $has_won_yes = 1;

							else:

								echo '		<div class="card section-vbox"> <div class="p-3">';
							_e("There are no projects yet.",'ProjectTheme');
							echo '</div> </div> ';

							endif;
							wp_reset_query();

							?>



			<?php
					if(!empty($has_won_yes)) {  ?>

						<div class="row"><div class="col-sm-12 mb-5">
								<a href="<?php echo get_permalink(get_option('ProjectTheme_my_account_bid_projects_id')) ?>" class="btn btn-outline-secondary btn-sm"><?php _e("See all unpublished projects",'ProjectTheme'); ?></a>
					 </div></div>

				 <?php } else { echo '<div class="row clear10"></div>'; }	 ?>

<?php

/*********************************************************************************************************************************
*
*			SECTion
*
*********************************************************************************************************************************/

?>


	<h3 class="my-account-headline-1"><?php echo __('My Latest Won Projects','ProjectTheme'); ?></h3>




					<?php

					query_posts( "meta_key=winner&meta_value=".$uid."&post_type=$custom_post_project_type_name&order=DESC&orderby=id&posts_per_page=3" );

					if(have_posts()) : ?>



<?php

					while ( have_posts() ) : the_post();
						projectTheme_get_post_my_winning_bid();
					endwhile; ?> </tbody></table>  <?php $has_vn_yes = 1;

					else:

						echo '<div class="card section-vbox"> <div class="p-3">';
					_e("There are no projects yet.",'ProjectTheme');
					echo '</div> </div> ';

					endif;
					wp_reset_query();

					?>


					<?php
							if(!empty($has_vn_yes)) {  ?>

								<div class="row"><div class="col-sm-12 mb-5">
										<a href="<?php echo get_permalink(get_option('ProjectTheme_my_account_won_projects_id')) ?>" class="btn btn-outline-secondary btn-sm"><?php _e("See all won projects",'ProjectTheme'); ?></a>
							 </div></div>

						 <?php } else { echo '<div class="row clear10"></div>'; }	 ?>

<?php

/*********************************************************************************************************************************
*
*			SECTion
*
*********************************************************************************************************************************/

?>


											<?php } // end freelancer side ?>
        <?php




	if(isset($_GET['payment_done']))
	{


						?>
						<div class="saved_thing">
						<?php echo sprintf(__('Your payment was received.','ProjectTheme')  ); ?>
						</div>

						<?php

				}

			if(isset($_GET['prj_not_approved']))
			{

				$psts = get_post($_GET['prj_not_approved']);
		?>

        <div class="saved_thing">
        <?php echo sprintf(__('Your payment was received for the item: <b>%s</b> but your project needs to be approved.
		You will be notified when your project will be approved and live on our website','ProjectTheme'), $psts->post_title ); ?>
        </div>

        	<?php
			}



			?>










        </div></div> <!-- end dif content -->





<?php
}


?>
