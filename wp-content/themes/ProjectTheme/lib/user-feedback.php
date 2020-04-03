<?php

	global $wpdb,$wp_rewrite,$wp_query;
	$username = $wp_query->query_vars['post_author'];
	$uid = $username;
	$paged = $wp_query->query_vars['paged'];

	$user = get_userdata($uid);
	$username = $user->user_login;

	function sitemile_filter_ttl($title){return __("User Feedback",'ProjectTheme')." - ";}
	add_filter( 'wp_title', 'sitemile_filter_ttl', 10, 3 );

get_header();
?>

<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
                            <div class="mm_inn"><?php printf(__("User Feedback - %s", 'ProjectTheme'), $username); ?>     </div>


                        </div>  </div>

                    </div>


<!-- ########## -->

<div class="container mt-4">
		<div id="main" class="wrapper"><div  class="row">


			<div  class="account-sidebar col-xs-12 col-sm-4 col-md-4 col-lg-4">

				<div class="card card-profile">
						<div class="card-header" style="background-image: url('<?php echo ProjectTheme_get_profile_cover($uid,50,50) ?>');"></div>
							<div class="card-body text-center">


						<div class="avatar-user2"><img width="135" height="135" class="card-profile-img" border="0" src="<?php echo projecttheme_get_avatar($uid, 135, 135); ?>" id='single-project-avatar' /> </div>
						<h3 class="mb-3"><?php

							$current_user = get_userdata($uid);
							echo  (!empty($usr_nm) ? $usr_nm : $username) ;

								 //  echo ProjectTheme_show_badge_user2($uid);

						?></h3>


								<div class="py-2"><p><?php $info = get_user_meta($uid, 'user_description', true); if(empty($info)) echo __('There isnt any personal description defined.','ProjectTheme'); else echo substr($info,0,135); ?></p></div>


							<table class="table card-table" id='details-table'><tbody>


								<tr>
										<td class="font-weight-bold-new"><?php _e('<i class="fa fa-calendar"></i> Registered on','ProjectTheme'); ?></td>
										<td class="text-right"><?php

										 $registered = strtotime($current_user->user_registered);
										 echo date_i18n("j F, Y", $registered);

										?></td>
								</tr>


								<tr>
										<td class="font-weight-bold-new"><?php printf(__('<i class="far fa-list-alt"></i> All open projects','ProjectTheme')); ?></td>
										<td class="text-right"><?php echo ProjectTheme_get_total_nr_of_open_projects_of_uid($uid) ?></td>
								</tr>


								<tr>
										<td class="font-weight-bold-new"><?php printf(__('<i class="fas fa-cog"></i> Projects in progress','ProjectTheme')); ?></td>
										<td class="text-right"><?php echo ProjectTheme_get_total_nr_of_progress_projects_of_uid($uid) ?></td>
								</tr>







														<?php
								$arrms = ProjectTheme_get_user_fields_values($uid);

								if(count($arrms) > 0)
									for($i=0;$i<count($arrms);$i++)
									{

								?>
												<tr>
									<td class="font-weight-bold-new"><i class="far fa-list-alt"></i> <?php echo $arrms[$i]['field_name'];?>  </td>
													<td class="text-right"> <?php echo $arrms[$i]['field_value'];?></td>
												</tr>
								<?php }




			if(ProjectTheme_is_user_provider($uid)):

			$pr = get_user_meta($uid, 'per_hour', true);
			if(empty($pr)) $pr = __('not defined','ProjectTheme');
			else $pr = ProjectTheme_get_show_price($pr);

			?>
			<tr>
			<td class="font-weight-bold-new"><?php echo __('<i class="fas fa-money"></i> Hourly Rate:','ProjectTheme') ?>  </td>
			<td class="text-right"> <?php echo $pr;?></td>
			</tr>



			<?php endif; ?>

			</tbody></table>


				<?php				$current_user = wp_get_current_user();

								if($uid != $current_user->ID)
								{

						?>


			<?php

			if(function_exists('lv_pp_myplugin_activate'))
			{

			if(is_user_logged_in()) $link = projecttheme_get_pm_link_from_user(get_current_user_id(), $uid);
			else $link = projecttheme_get_pm_link_from_user(0, 0);

			?>

			<a class='btn btn-primary' href="<?php echo $link ?>"><?php echo __('Chat with User','ProjectTheme'); ?></a>


			<?php
			}
			else {




			?>
						<a class='btn btn-primary' href="<?php echo ProjectTheme_get_priv_mess_page_url('send', '', '&uid='.$uid); ?>"><?php echo __('Contact User','ProjectTheme'); ?></a>

						<?php }} ?>





					</div>

			</div>	 </div>


<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
    		<div class="card p-3">



               <!-- ####### -->


                <?php

					global $wpdb;
					$page_rows = 25;

					$pagenum 	= isset($_GET['pagenum']) ? $_GET['pagenum'] : 1;
					$max 		= ' limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;

					global $wpdb;
					$query = "select * from ".$wpdb->prefix."project_ratings where touser='$uid' AND awarded='1' order by id desc $max";
					$r = $wpdb->get_results($query);

					$query2 = "select count(id) tots from ".$wpdb->prefix."project_ratings where touser='$uid' AND awarded='1' order by id desc";
					$r2 = $wpdb->get_results($query2);
					$total 	= $r2[0]->tots;

					$last = ceil($total/$page_rows);

					if(count($r) > 0)
					{
						echo '<table width="100%">';
							echo '<tr>';
								echo '<th>&nbsp;</th>';
								echo '<th><b>'.__('Project Title','ProjectTheme').'</b></th>';
								echo '<th><b>'.__('From User','ProjectTheme').'</b></th>';
								echo '<th><b>'.__('Aquired on','ProjectTheme').'</b></th>';
								echo '<th><b>'.__('Price','ProjectTheme').'</b></th>';
								echo '<th><b>'.__('Rating','ProjectTheme').'</b></th>';


							echo '</tr>';


						foreach($r as $row)
						{
							$post = $row->pid;
							$post = get_post($post);
							$bid = projectTheme_get_winner_bid($row->pid);
							$user = get_userdata($row->fromuser);

							$dts = get_post_meta($row->pid,'closed_date',true);
							if(empty($dts)) $dts = current_time('timestamp',0);

							echo '<tr>';

								echo '<th><img class="img_class g_image_g" src="'.ProjectTheme_get_first_post_image($row->pid, 42, 42).'"
                                alt="'.$post->post_title.'" width="42" /></th>';
								echo '<th><a href="'.get_permalink($row->pid).'">'.$post->post_title.'</a></th>';
								echo '<th><a href="'.ProjectTheme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></th>';
								echo '<th>'.date_i18n('d-M-Y H:i:s', $dts).'</th>';
								echo '<th>'.projectTheme_get_show_price($bid->bid).'</th>';
								echo '<th>'.ProjectTheme_get_project_stars(floor($row->grade/2)).' ('.floor($row->grade/2).'/5)</th>';


							echo '</tr>';
							echo '<tr>';
							echo '<th></th>';
							echo '<th colspan="5"><b>'.__('Comment','ProjectTheme').':</b> '.$row->comment.'</th>'	;
							echo '</tr>';

							echo '<tr><th colspan="6"><hr color="#eee" /></th></tr>';

						}
						echo '<tr>';
						echo '<th colspan="6">'. ProjectTheme_get_my_pagination_main( home_url() . "/?p_action=user_feedback&post_author=".$uid, $pagenum, 'pagenum', $last ) .'</th>';
						echo '</tr>';

						echo '</table>';
					}
					else
					{
						_e("This user has no reviews yet.","ProjectTheme");
					}
				?>


				<!-- ####### -->


            </div>



  </div>



</div></div></div>

<?php

	//sitemile_after_content();

	get_footer();

?>
