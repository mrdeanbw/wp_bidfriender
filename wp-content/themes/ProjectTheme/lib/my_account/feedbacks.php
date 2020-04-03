<?php

function ProjectTheme_my_account_feedbacks_area_function()
{

		global $current_user, $wpdb, $wp_query;
		$current_user=wp_get_current_user();
		$uid = $current_user->ID;
		do_action('pt_for_demo_work_3_0');


						pt_account_main_menu_new();
?>


<div class="row">

<?php 		ProjectTheme_get_users_links(); ?>

 <div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">


	 <h3 class="my-account-headline-1"> <?php echo __('Reviews I need to award','ProjectTheme'); ?></h3>

	 <div class="card">



                <div class="table-responsive">

              	<?php

					global $wpdb;
					$query = "select * from ".$wpdb->prefix."project_ratings where fromuser='$uid' AND awarded='0'";
					$r = $wpdb->get_results($query);

					if(count($r) > 0)
					{
						echo '<table class="table table-hover table-outline table-vcenter   card-table">';
							echo '<thead><tr>';

								echo '<th>'.__('Project Title','ProjectTheme').'</th>';
								echo '<th>'.__('To User','ProjectTheme').'</th>';
								echo '<th>'.__('Aquired on','ProjectTheme').'</th>';
								echo '<th>'.__('Price','ProjectTheme').'</th>';
								echo '<th>'.__('Options','ProjectTheme').'</th>';

							echo '</tr></thead><tbody>';


						foreach($r as $row)
						{
							$post 	= $row->pid;
							$post 	= get_post($post);
							$bid 	= projectTheme_get_winner_bid($row->pid);
							$user 	= get_userdata($row->touser);

							$dmt2 = get_post_meta($row->pid,'closed_date',true);

							if(!empty($dmt2))
							$dmt = date_i18n('d-M-Y H:i', $dmt2);

							echo '<tr>';


								echo '<td><a href="'.get_permalink($row->pid).'">'.$post->post_title.'</a></td>';
								echo '<td><a href="'.ProjectTheme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></td>';
								echo '<td>'.$dmt.'</td>';
								echo '<td>'.projectTheme_get_show_price($bid->bid).'</td>';
								echo '<td><a class="btn btn-outline-primary btn-sm" href="'.home_url().'/?p_action=rate_user&rid='.$row->id.'">'.__('Rate User','ProjectTheme').'</a></td>';

							echo '</tr>';

						}

						echo '</tbody></table>';
					}
					else
					{
						echo '<div class="p-3">'; _e("There are no reviews to be awarded.","ProjectTheme"); echo '</div>';
					}
				?>


           </div>
           </div>

           <!-- ##### -->




					 <h3 class="my-account-headline-1">  <?php echo __('Reviews I am waiting','ProjectTheme'); ?></h3>
           <div class="card">



                <div class="table-responsive">

              	<?php

					global $wpdb;
					$query = "select * from ".$wpdb->prefix."project_ratings where touser='$uid' AND awarded='0'";
					$r = $wpdb->get_results($query);

					if(count($r) > 0)
					{
						echo '<table class="table table-hover table-outline table-vcenter   card-table">';
							echo '<thead><tr>';

								echo '<th>'.__('Project Title','ProjectTheme').'</th>';
								echo '<th>'.__('From User','ProjectTheme').'</th>';
								echo '<th>'.__('Aquired on','ProjectTheme').'</th>';
								echo '<th>'.__('Price','ProjectTheme').'</th>';


							echo '</tr></thead><tbody>';


						foreach($r as $row)
						{
							$post 	= $row->pid;
							$post 	= get_post($post);
							$bid 	= projectTheme_get_winner_bid($row->pid);
							$user 	= get_userdata($row->fromuser);

							$dmt2 = get_post_meta($row->pid,'closed_date',true);

							if(!empty($dmt2))
							$dmt = date_i18n('d-M-Y H:i', $dmt2);

							echo '<tr>';


								echo '<td><a href="'.get_permalink($row->pid).'">'.$post->post_title.'</a></td>';
								echo '<td><a href="'.ProjectTheme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></td>';
								echo '<td>'.$dmt.'</td>';
								echo '<td>'.projectTheme_get_show_price($bid->bid).'</td>';


							echo '</tr>';

						}

						echo '</tbody></table>';
					}
					else
					{
						echo '<div class="p-3">'; _e("There are no reviews to be awarded.","ProjectTheme"); echo '</div>';
					}
				?>


           </div>
           </div>




					 <h3 class="my-account-headline-1">  <?php echo __('Reviews I was awarded','ProjectTheme'); ?></h3>
           <div class="card">




                <div class="table-responsive">

              	<?php

					global $wpdb;
					$query = "select * from ".$wpdb->prefix."project_ratings where touser='$uid' AND awarded='1'";
					$r = $wpdb->get_results($query);

					if(count($r) > 0)
					{
						echo '<table class="table table-hover table-outline table-vcenter  card-table">';
							echo '<thead><tr>';

								echo '<th>'.__('Project Title','ProjectTheme').'</th>';
								echo '<th>'.__('From User','ProjectTheme').'</th>';
								echo '<th>'.__('Aquired on','ProjectTheme').'</th>';
								echo '<th>'.__('Price','ProjectTheme').'</th>';
								echo '<th>'.__('Rating','ProjectTheme').'</th>';


							echo '</tr></thead><tbody>';


						foreach($r as $row)
						{
							$post 	= $row->pid;
							$post 	= get_post($post);
							$bid 	= projectTheme_get_winner_bid($row->pid);
							$user 	= get_userdata($row->fromuser);

							$dmt2 =  get_post_meta($row->pid,'closed_date',true);

							if(!empty($dmt2))
							$dmt = date_i18n('d-M-Y H:i', $dmt2);

							echo '<tr>';

								echo '<td><a href="'.get_permalink($row->pid).'">'.$post->post_title.'</a></td>';
								echo '<td><a href="'.ProjectTheme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></td>';
								echo '<td>'.$dmt.'</td>';
								echo '<td>'.projectTheme_get_show_price($bid->bid).'</td>';
								echo '<td>'.floor($row->grade/2).'/5</td>';


							echo '</tr>';
							echo '<tr>';

							echo '<td colspan="5"><b>'.__('Comment','ProjectTheme').':</b> '.$row->comment.'</td>'	;
							echo '</tr>';



						}

						echo '</tbody></table>';
					}
					else
					{
						echo '<div class="p-3">'; _e("There are no reviews to be awarded.","ProjectTheme"); echo '</div>';
					}
				?>


           </div>
           </div>





		</div>		</div>

<?php



}

?>
