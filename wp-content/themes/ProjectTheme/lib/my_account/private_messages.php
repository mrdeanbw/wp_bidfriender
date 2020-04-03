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


function ProjectTheme_my_account_private_messages_area_function()
{
		global $current_user, $wpdb, $wp_query;

		$current_user = wp_get_current_user();
		$uid = $current_user->ID;


		$myuid = $uid;


?>

       <?php
            global $wpdb,$wp_rewrite,$wp_query;
		$third_page = $wp_query->query_vars['pg'];

		if(empty($third_page)) $third_page = 'home';



							do_action('pt_for_demo_work_3_0');


							pt_account_main_menu_new();

							do_action('pt_at_account_dash_top');


		?>

	<div class="row">   <?php ProjectTheme_get_users_links(); ?>
<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">




        <?php

			if($third_page == 'home') {


			$myuid = $current_user->ID;

		?>

		<!-- page content here -->


<h3 class="my-account-headline-1"><?php echo __('Your Latest Messages','ProjectTheme'); ?></h3>







                <?php
				global $wpdb;
				$uidsss = $current_user->ID;
				//$s = "select * from ".$wpdb->prefix."project_pm_threads where admin_approved = '1' and ((user1='$uidsss' and show_to_user1='1') or (user2='$uidsss' and show_to_user2='1')) order by lastupdate desc";
				$s = "select * from ".$wpdb->prefix."project_pm_threads where ((user1='$uidsss' and show_to_user1='1') or (user2='$uidsss' and show_to_user2='1')) order by lastupdate desc";


				$r = $wpdb->get_results($s);

				if(count($r) > 0)
				{

					?>


					        <div class="panel rounded shadow panel-teal">


					            <div class="panel-body no-padding">

					                <div class="table-responsive">
					                    <table class="table table-hover table-email">
					                        <tbody>



					<?php

					$j = 0;

					foreach($r as $row)
					{
						$unread = projectTheme_count_unread_messages($row->id, $current_user->ID);


						if($unread > 0) $bold = 'style="font-weight:bold"';
						else $bold = '';



						if($row->user1 == $current_user->ID) $user_nv = get_userdata($row->user2);
						else $user_nv = get_userdata($row->user1);


						$post_mm 	= get_post($row->pid);
						$last_mess 	= projectTheme_get_the_latest_message_thing($row->id);
						$post_mm_ttl = $post_mm->post_title;


						if($row->pid == 0)
						{
							$s1 = "select * from ".$wpdb->prefix."project_pm where threadid='".$row->id."' and parent='0'";
							$r1 = $wpdb->get_results($s1);
							$row1 = $r1[0];
							$post_mm_ttl = $row1->subject;
						}

						$j++;

						if($j%2)
						{
									$see = "selected";
						}
						else $see = " ";

						?>



						<tr class="<?php echo $see; ?>">
								<td>
										<div class="ckbox ckbox-theme">
												<input id="checkbox1" type="checkbox" checked="checked" class="mail-checkbox">
												<label for="checkbox1"></label>
										</div>
								</td>

								<td>
										<div class="media">
												<a href="#" class="pull-left">
														<img alt="..." src="<?php $av = ProjectTheme_get_avatar($user_nv->ID,	35, 35); echo $av; ?>" width="35" class="media-object">
												</a>
												<div class="media-body">
														<h4 class="text-secondary"><?php echo $user_nv->user_login ?></h4>
														<p class="email-summary"><a href="<?php echo ProjectTheme_get_priv_mess_page_url('read-message', $row->id) ?>"><?php echo $post_mm_ttl ?> (<?php echo projectTheme_get_total_message_thread($row->id) ?>)
															<br/><sub><?php echo substr($last_mess,0,45) ?></sub><a/></p>
														<span class="media-meta"><?php echo date_i18n('d-M-Y H:i:s',$row->datemade) ?></span>
												</div>
										</div>
								</td>
						</tr>




						<?php

/*
						echo '<div class=" message-row " '.$bold.' >';
						echo '<div class="message-row-user"><a href="'.home_url().'/?p_action=user_profile&post_author='.$user_nv->ID.'">'.$user_nv->user_login.'</a> ('.projectTheme_get_total_message_thread($row->id).')</div>';
						echo '<div class="message-row-title"><a href="'.ProjectTheme_get_priv_mess_page_url('read-message', $row->id).'" >'.$post_mm->post_title.'</a><br/><span class="clava-em">'.substr($last_mess,0,45).'</span></div>';
						echo '<div class="message-row-date">'.date_i18n('d-M-Y H:i:s',$row->datemade).'</div>';
						echo '<div class="message-row-reply"><a href="'.ProjectTheme_get_priv_mess_page_url('read-message', $row->id).'" class="btn btn-outline-secondary btn-sm" role="button">'.__('Reply','ProjectTheme').'</a>
						<a href="'.ProjectTheme_get_priv_mess_page_url('delete-message', $row->id).'" class="btn btn-outline-secondary btn-sm" role="button ">'.__('Delete','ProjectTheme').'</a></div>';




						echo '</div> '; */

					}
					?>


										                        </tbody>
										                    </table>
										                </div><!-- /.table-responsive -->

										            </div><!-- /.panel-body -->
										        </div><!-- /.panel -->

					<?php


				} else { echo '<div class="card p-3">'; _e('No messages here.','ProjectTheme'); echo '</div>'; }

				?>




            <!--#######-->



		<!-- page content here -->

        <?php }


			elseif($third_page == 'inbox') {


			$myuid = $current_user->ID;
			//echo $myuid;
		?>

		<!-- page content here -->


            	<div class="card">


            	<div class="box_title"><?php _e("Private Messages: Inbox","ProjectTheme"); ?></div>
                <div class="box_content">
                <?php

				global $wpdb;
				$page_rows = 20;
				$page_rows = apply_filters('ProjectTheme_nr_of_messages_priv_pagination', $page_rows);

				$pagenum 	= isset($_GET['pagenum']) ? $_GET['pagenum'] : 1;
				$max 		= ' limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;

				$s 		= "select count(id) tots from ".$wpdb->prefix."project_pm where (initiator='$myuid' or user='$myuid') and parent='0' AND show_to_destination='1' and approved='1'";
				$r 		= $wpdb->get_results($s);
				$total 	= $r[0]->tots;

				$last = ceil($total/$page_rows);

				//-------------------------

				$s = "select * from ".$wpdb->prefix."project_pm where (initiator='$myuid' or user='$myuid') AND show_to_destination='1' and parent='0' and approved='1' order by id desc ". $max;
				$r = $wpdb->get_results($s);



				if(count($r) > 0)
				{
					?>

                    <script>

					$(document).ready(function() {
						//set initial state.


						$('#select_all_stuff').change(function() {
							if($(this).is(":checked")) {

								$('.message_select_bx').attr("checked", true);
							}
							else
							{
								$('.message_select_bx').attr("checked", false);
							}
						});
					});


					</script>

                    <?php

					echo '<form method="post" action="'.ProjectTheme_get_priv_mess_page_url('delete-message','','&return=inbox').'">';
					echo '<table class="da_table_done" width="100%">';

					echo '<tr>';
						echo '<td><input type="checkbox" name="" id="select_all_stuff" value="1" /> '.__('Select All','ProjectTheme').' </td>';
						echo '<td>'.__('From User','ProjectTheme').'</td>';
						echo '<td>'.__('Subject','ProjectTheme').'</td>';
						echo '<td>'.__('Date','ProjectTheme').'</td>';
						echo '<td>'.__('Options','ProjectTheme').'</td>';
						echo '</tr>';



					foreach($r as $row)
					{
						//if($row->rd == 0) $cls = 'bold_stuff';
						//else $cls = '';

						$user = get_userdata($row->initiator);

						$s2 = "select * from ".$wpdb->prefix."project_pm where rd='0' and parent='{$row->id}' and user='$uidsss' ";
						$r2 = $wpdb->get_results($s2);

						if(count($r2) > 0 or $row->rd == 0) $bold = 'style="font-weight:bold"';
						else $bold = '';

						if($row->initiator == $current_user->ID) $user_nv = get_userdata($row->user);
						else $user_nv = get_userdata($row->initiator);

						echo '<tr '.$bold.'>';
						echo '<td><input type="checkbox" class="message_select_bx" name="message_ids[]" value="'.$row->id.'" /></td>';
						echo '<td class="'.$cls.'"><a href="'.home_url().'/?p_action=user_profile&post_author='.$user_nv->ID.'">'.$user_nv->user_login.'</a></td>';
						echo '<td class="'.$cls.'"><a href="'.ProjectTheme_get_priv_mess_page_url('read-message', $row->id).'">'.substr($row->subject,0,30).'</a></td>';
						echo '<td class="'.$cls.'">'.date_i18n('d-M-Y H:i:s',$row->datemade).'</td>';
						echo '<td><a href="'.ProjectTheme_get_priv_mess_page_url('read-message', $row->id).'" class="green_btn3">'.__('Reply','ProjectTheme').'</a>
						<a href="'.ProjectTheme_get_priv_mess_page_url('delete-message', $row->id).'" class="green_btn3">'.__('Delete','ProjectTheme').'</a></td>';
						echo '</tr>';

					}

					echo '<tr><td colspan="5"><input type="submit" value="'.__('Delete Selected','ProjectTheme').'" name="delete_sel" /></td></tr>';
					echo '<tr><td colspan="5">  ';

						 echo ProjectTheme_get_my_pagination_main(home_url(). "/?page_id=".get_option('ProjectTheme_my_account_private_messages_id'),
						 $pagenum, 'pagenum', $last, '&pg=inbox');

					echo ' </td></tr>';



					echo '</table></form>';
				} else _e('No messages here.','ProjectTheme');

				?>


                </div>
                </div>


		<!-- page content here -->

        <?php }

		elseif($third_page == 'sent-items') {


			$myuid = $current_user->ID;




		?>
        		<script>

					$(document).ready(function() {
						//set initial state.


						$('#select_all_stuff').change(function() {
							if($(this).is(":checked")) {

								$('.message_select_bx').attr("checked", true);
							}
							else
							{
								$('.message_select_bx').attr("checked", false);
							}
						});
					});


					</script>
		<!-- page content here -->


            	<div class="card">


            	<div class="box_title"><?php _e("Private Messages: Sent Items","ProjectTheme"); ?></div>
                <div class="box_content">
                <?php
				global $wpdb;

				$page_rows = 20;
				$page_rows = apply_filters('ProjectTheme_nr_of_messages_priv_pagination', $page_rows);

				$pagenum 	= isset($_GET['pagenum']) ? $_GET['pagenum'] : 1;
				$max 		= ' limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;

				//---------------------------------

				$s 		= "select count(id) tots from ".$wpdb->prefix."project_pm where (initiator='$myuid' or user='$myuid') AND show_to_source='1' and parent='0' and approved='1'";
				$r 		= $wpdb->get_results($s);
				$total 	= $r[0]->tots;

				$last = ceil($total/$page_rows);

				//---------------------------------

				$s = "select * from ".$wpdb->prefix."project_pm where (initiator='$myuid' or user='$myuid') AND show_to_source='1' and approved='1' and parent='0' order by id desc ".$max;
				$r = $wpdb->get_results($s);

				if(count($r) > 0)
				{

					echo '<form method="post" action="'.ProjectTheme_get_priv_mess_page_url('delete-message','','&return=outbox').'">';
					echo '<table class="da_table_done" width="100%">';

					echo '<tr>';
						echo '<td><input type="checkbox" name="" id="select_all_stuff" value="1" /> '.__('Select All','ProjectTheme').' </td>';
						echo '<td>'.__('To User','ProjectTheme').'</td>';
						echo '<td>'.__('Subject','ProjectTheme').'</td>';
						echo '<td>'.__('Date','ProjectTheme').'</td>';
						echo '<td>'.__('Options','ProjectTheme').'</td>';
						echo '</tr>';



					foreach($r as $row)
					{
						//if($row->rd == 0) $cls = 'bold_stuff';
						//else
						$cls = '';

						$user = get_userdata($row->user);

						if($row->initiator != $current_user->ID) $user_nv = get_userdata($row->initiator);
						else $user_nv = get_userdata($row->user);

						echo '<tr>';
						echo '<td><input type="checkbox" class="message_select_bx" name="message_ids[]" value="'.$row->id.'" /></td>';
						echo '<td class="'.$cls.'"><a href="'.ProjectTheme_get_user_profile_link($user_nv->user).'">'.$user_nv->user_login.'</a></td>';
						echo '<td class="'.$cls.'"><a href="'.ProjectTheme_get_priv_mess_page_url('read-message', $row->id).'">'.substr($row->subject,0,30).'</a></td>';
						echo '<td class="'.$cls.'">'.date_i18n('d-M-Y H:i:s',$row->datemade).'</td>';
						echo '<td><a  class="green_btn3" href="'.ProjectTheme_get_priv_mess_page_url('read-message', $row->id).'">'.__('Reply','ProjectTheme').'</a>
						<a href="'.ProjectTheme_get_priv_mess_page_url('delete-message', $row->id).'"  class="green_btn3">'.__('Delete','ProjectTheme').'</a></td>';
						echo '</tr>';

					}

					echo '<tr><td colspan="5"><input type="submit" value="'.__('Delete Selected','ProjectTheme').'" name="delete_sel" /></td></tr>';
					echo '<tr><td colspan="5">  ';

						echo ProjectTheme_get_my_pagination_main(home_url(). "/?page_id=".get_option('ProjectTheme_my_account_private_messages_id'),
						 $pagenum, 'pagenum', $last, '&pg=sent-items');


					echo ' </td></tr>';

					echo '</table></form>';
				}
				else _e('No messages here.','ProjectTheme');
				?>

                </div>
                </div>



		<!-- page content here -->

        <?php }


		elseif($third_page == 'delete-message') {


			$id = $_GET['id'];
			$s = "select * from ".$wpdb->prefix."project_pm_threads where id='$id' AND ((user1='$myuid' and show_to_user1='1') or (user2='$uid' and show_to_user2='1'))";
			$r = $wpdb->get_results($s);
			$row = $r[0];


			$myuid = $current_user->ID;


			if($myuid == $row->initiator) $owner = true; else $owner = false;

			//if(!$owner)
			//$wpdb->query("update_i18n ".$wpdb->prefix."auction_pm set rd='1' where id='{$row->id}'");


		?>

		<!-- page content here -->


            	<div class="card">
            	<div class="padd10">

            	<div class="box_title"><?php

				if(isset($_POST['delete_sel']))
				{
					_e("Delete Multiple Messages: ","ProjectTheme");

				}
				else
				{
					printf(__("Are you sure you want to delete this message: %s","ProjectTheme"),htmlentities($row->message_title));
				}

				 ?></div>
                <div class="box_content">

                <?php
					if(isset($_POST['message_ids']))
					{
						$message_ids2 = $_POST['message_ids'];
						foreach($message_ids2 as $message_id)
						{
							$ss1 = "select * from ".$wpdb->prefix."project_pm where id='$message_id'";
							$rr1 = $wpdb->get_results($ss1);
							$rrow1 = $rr1[0];
							echo '#'.$rrow1->id." ".$rrow1->subject.'<br/>';

						} echo '<br/>';
					}
				?>

                <?php //echo $row->content; ?>
      <br/> <br/>

      <?php if(1): //$owner == false):

	  	if(isset($_POST['delete_sel'])):

			$message_ids = $_POST['message_ids'];
			if(count($message_ids) == 0)
			{
				_e("No messsages selected.","ProjectTheme");
			}
			else
			{
				$attash = '';
				foreach($message_ids as $message_id)
				{
					$attash .= '&message_id[]='.$message_id;
				}

				?>

                   <a href="<?php echo ($_GET['rdr']); ?>" class="green_btn3"><?php _e("Cancel",'ProjectTheme'); ?></a>

                    <a href="<?php echo ProjectTheme_get_priv_mess_page_url('delete-message', '', '&confirm_message_deletion=yes&return='.urlencode($_GET['rdr'])).$attash; ?>"
       				class="green_btn3"><?php _e("Confirm Deletion",'ProjectTheme'); ?></a>

                <?php
			}

		else:

	  ?>

      <a href="<?php echo (htmlentities($_GET['rdr'])); ?>" class="green_btn3"><?php _e("Cancel",'ProjectTheme'); ?></a>

       <a href="<?php echo ProjectTheme_get_priv_mess_page_url('delete-message', $row->id, '&confirm_message_deletion=yes&return='.urlencode($_GET['rdr'])); ?>"
       class="green_btn3"><?php _e("Confirm Deletion",'ProjectTheme'); ?></a> <?php endif; endif; ?>
                </div>
                </div>
                </div>


		<!-- page content here -->

        <?php }


		elseif($third_page == 'read-message') {

			global $current_user, $wpdb;
			$current_user = wp_get_current_user(); //get_currentuserinfo();
			$myuid = $current_user->ID;

			$id = projecttheme_sanitize_string($_GET['id']);

			if(empty($id))
			{
					echo 'error: select id';
					exit;
			}

			$s = "select * from ".$wpdb->prefix."project_pm_threads where id='$id'  AND (user1='$myuid' OR user2='$myuid')";
			$r = $wpdb->get_results($s);


			if(count($r) == 0)
			{
					echo 'error: select id';
					exit;
			}

			$row = $r[0];



			if($myuid == $row->initiator) $owner = true; else $owner = false;

			if(!$owner)
			$wpdb->query("update ".$wpdb->prefix."project_pm set rd='1' where id='{$row->id}'");


			$send_to_to = $row->user1;
			if($myuid == $send_to_to) $send_to_to = $row->user2;


			$s1 = "select * from ".$wpdb->prefix."project_pm where threadid='".$row->id."' and parent='0'";
			$r1 = $wpdb->get_results($s1);
			$row1 = $r1[0];
			$post_mm_ttl = $row1->subject;


		?>

		<!-- page content here -->

<h3 class="my-account-headline-1"><?php echo sprintf(__("Read Message: %s","ProjectTheme"), htmlentities($post_mm_ttl));  ?></h3>
            	<div class="card p-3">






							<?php

																	if(isset($_POST['send_a']))
																	{

																		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
																		require_once(ABSPATH . "wp-admin" . '/includes/image.php');



																		if(!empty($_FILES['file_instant']['name'])):

																			$pids = 0;
																			$upload_overrides 	= array( 'test_form' => false );
																			$uploaded_file 		= wp_handle_upload($_FILES['file_instant'], $upload_overrides);

																			$file_name_and_location = $uploaded_file['file'];
																			$file_title_for_media_library = $_FILES['file_instant']['name'];

																			$arr_file_type 		= wp_check_filetype(basename($_FILES['file_instant']['name']));
																			$uploaded_file_type = $arr_file_type['type'];



																			if($uploaded_file_type == "application/zip" or $uploaded_file_type == "application/pdf" or $uploaded_file_type == "application/msword" or $uploaded_file_type == "application/msexcel" or
																			$uploaded_file_type == "application/doc" or $uploaded_file_type == "application/docx" or
																			$uploaded_file_type == "application/xls" or $uploaded_file_type == "application/xlsx" or $uploaded_file_type == "application/csv" or $uploaded_file_type == "application/ppt" or
																			$uploaded_file_type == "application/pptx" or $uploaded_file_type == "application/vnd.ms-excel"
																			or $uploaded_file_type == "application/vnd.ms-powerpoint" or $uploaded_file_type == "application/vnd.openxmlformats-officedocument.presentationml.presentation"

																			or $uploaded_file_type == "application/octet-stream"
																			or $uploaded_file_type == "image/png"
																			or $uploaded_file_type == "image/jpg"  or $uploaded_file_type == "image/jpeg"

																				or $uploaded_file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
																				or $uploaded_file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"  )
																			{



																				$attachment = array(
																								'post_mime_type' => $uploaded_file_type,
																								'post_title' => addslashes($file_title_for_media_library),
																								'post_content' => '',
																								'post_status' => 'inherit',
																								'post_parent' =>  0,

																								'post_author' => $uid,
																							);

																				$attach_id 		= wp_insert_attachment( $attachment, $file_name_and_location, $pids );
																				$attach_data 	= wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
																				wp_update_attachment_metadata($attach_id,  $attach_data);




																			} else $error_mm = '1';

																		endif;



																		$message 	= projecttheme_sanitize_string($_POST['message_a']);
																		$uids 		=  $send_to_to; //($_POST['send_to']);

																		if(strlen($message) < 2) $error_mm = 1;


																		if($error_mm != "1"):

																		//echo $message;
																		//*********************************************

																		$ProjectTheme_moderate_private_messages = get_option('ProjectTheme_moderate_private_messages');
																		if($ProjectTheme_moderate_private_messages == "yes") $ProjectTheme_moderate_private_messages = true;
																		else $ProjectTheme_moderate_private_messages = false;

																		//--------------------------

																		if($ProjectTheme_moderate_private_messages == true)
																		{
																			$approved = '0';
																			$show_to_destination = '0';
																		}
																		else
																		{
																			$approved = '1';
																			$show_to_destination = '1';
																		}

																		//*********************************************

																		$current_user = wp_get_current_user();

																		global $wpdb;
																		$tm = projecttheme_sanitize_string($_POST['tm']); //current_time('timestamp',0);
																		$myuid = $current_user->ID;

																		$sr = "select * from ".$wpdb->prefix."project_pm where initiator='$myuid' and user='$uids' and datemade='$tm'";
																		$rr = $wpdb->get_results($sr);


																		if(count($rr) == 0)
																		{

																			if(empty($pid)) $pid = 0;
																			$parent = $_POST['parent'];
																			$threadid = $row->id;

																			$s = "insert into ".$wpdb->prefix."project_pm
																			(approved, subject, content, datemade, pid, initiator, user, file_attached, show_to_destination, parent, threadid)
																			values('$approved','$subject','$message','$tm','$pid','$myuid','$uids', '$attach_id', '$show_to_destination','$parent', '$threadid')";

																			$wpdb->query($s);

																			//echo $s;


																			//------------------------------

																			if($ProjectTheme_moderate_private_messages == false)
																				ProjectTheme_send_email_on_priv_mess_received($myuid, $uids);
																			else
																			{
																				//send message to admin to moderate

																			}


																		}

																	//-----------------------
																		?>

																						<div class="alert alert-success">

																						 <?php

																		 if($ProjectTheme_moderate_private_messages == false)
																			_e('Your message has been sent.','ProjectTheme');
																		 else
																				_e('Your message has been sent but the receiver will receive it only after moderation.','ProjectTheme')

																			?>

																						</div>

																						<?php

																		else:

																			if($error_mm == "1") {

																				if(strlen($message) < 2) echo '<div class="alert alert-danger">'.__('You need to type in a message.','ProjectTheme') . '</div>';
																				else echo '<div class="alert alert-danger">'. sprintf(__('Wrong File format: %s','ProjectTheme'), $uploaded_file_type) . '</div>';

																			}

																		endif;


																	}

																	 ?>



							<?php


										$current_user = wp_get_current_user();

										$s = "select * from ".$wpdb->prefix."project_pm where threadid='{$row->id}' and approved='1' order by id asc";
										$r = $wpdb->get_results($s);

						 
										if(count($r) > 0)
										foreach($r as $row1)
										{
													if($row1->user == $current_user->ID)
													{
															$wpdb->query("update ".$wpdb->prefix."project_pm set rd='1' where id='{$row1->id}'");

													}



													if($row1->initiator == $current_user->ID)
													{
															?>

															<div class="  row p-4">



																<div class="messages-body-private col col-lg-9 this-is-me">
																<?php echo stripslashes($row1->content); ?>


															<?php

															if(!empty($row1->file_attached))
															echo '<br/>'.sprintf(__('File Attached: %s','ProjectTheme') , '<a href="'.wp_get_attachment_url($row1->file_attached).'">'.wp_get_attachment_url($row1->file_attached)."</a>") ;

																													echo '<span class="m1emm1">' . sprintf(__('Written on: %s','ProjectTheme'), date_i18n('d-M-Y H:i:s', $row1->datemade)) . '</span>';

															?>



																</div>


																<div class="col col-lg-3 align-center <?php echo $row1->initiator == $current_user->ID ? 'this-is-me-avatar' : '' ?>">
																		<img width="70" class="avatar_good_1" height="70" border="0" src="<?php echo ProjectTheme_get_avatar($row1->initiator,70,70); ?>" /> <br/>
																		<?php
																					//echo date_i18n('d-M-Y H:i:s', $row1->datemade). '<br/>';
																					$user_se = get_userdata($row1->initiator);
																					echo '<a href="'.ProjectTheme_get_user_profile_link($user_se->ID).'">' . $user_se->user_login.'</a>';
																		 ?>
																</div>


																</div>


															<?php
													}
													else {
															?>


															<div class="  row p-4">

																		<div class="col col-lg-3 align-center <?php echo $row1->initiator == $current_user->ID ? 'this-is-me-avatar' : '' ?>">
																				<img width="70" class="avatar_good_1" height="70" border="0" src="<?php echo ProjectTheme_get_avatar($row1->initiator,70,70); ?>" /> <br/>
																				<?php
																							//echo date_i18n('d-M-Y H:i:s', $row1->datemade). '<br/>';
																							$user_se = get_userdata($row1->initiator);
																							echo '<a href="'.ProjectTheme_get_user_profile_link($user_se->ID).'">' . $user_se->user_login.'</a>';
																				 ?>
																		</div>

																<div class="messages-body-private col col-lg-9 ">
																<?php echo stripslashes($row1->content); ?>


															<?php

															if(!empty($row1->file_attached))
															echo '<br/>'.sprintf(__('File Attached: %s','ProjectTheme') , '<a href="'.wp_get_attachment_url($row1->file_attached).'">'.wp_get_attachment_url($row1->file_attached)."</a>") ;

																													echo '<span class="m1emm1">' . sprintf(__('Written on: %s','ProjectTheme'), date_i18n('d-M-Y H:i:s', $row1->datemade)) . '</span>';

															?>



																</div>
																</div>


															<?php
													}

												?>




												<?php
										}


								 ?> </div>

								<div class="card">
	                <div class="box_content">


										<form method="post" enctype="multipart/form-data" action="<?php echo  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
											<input name="send_to" type="hidden" value="<?php echo $row->user; ?>" />
												<input name="parent" type="hidden" value="<?php echo $row->id; ?>" />

										<input type="hidden" name="tm" value="<?php echo current_time('timestamp',0); ?>" />


										<div class="form-group">
										<label for="exampleInputEmail1"><?php _e("Message", "ProjectTheme"); ?>:</label>
										 <textarea name="message_a" rows="6" cols="50" class="form-control"></textarea>
										</div>


										<div class="form-group">
										<label for="exampleInputEmail1"><?php _e("Attach File", "ProjectTheme"); ?>:</label>
										 <input type="file" name="file_instant" class="form-control" />
										 <small id="emailHelp" class="form-text text-muted"><?php _e('Only PDF, ZIP, Office files and Images.','ProjectTheme'); ?></small>
										</div>




										 <div class="form-group">

										 <input name="send_a" class="btn btn-primary" type="submit" value="<?php _e("Send Message",'ProjectTheme'); ?>" />
										</div>


								</form>

									</div></div>


		<!-- page content here -->

        <?php }
		 elseif($third_page == 'send') { ?>
        <?php

			$pid = projecttheme_sanitize_string($_GET['pid']);
			$uid = projecttheme_sanitize_string($_GET['uid']);

			$user = get_userdata($uid);

			if(!empty($pid))
			{
				$post = get_post($pid);
				$subject = $post->post_title;
			}

			if($uid == get_current_user_id())
			{
				echo '<div class="alert alert-danger">';
					echo __('You cannot contact yourself. Your message wont be sent.', 'ProjectTheme');
					echo '</div>';
			}
			else {
				// code...



			if(isset($_POST['send_a']))
			{

				require_once(ABSPATH . "wp-admin" . '/includes/file.php');
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');


				if(!empty($_FILES['file_instant']['name']))
				{

					$pids = 0;
					$upload_overrides 	= array( 'test_form' => false );
					$uploaded_file 		= wp_handle_upload($_FILES['file_instant'], $upload_overrides);

					$file_name_and_location = $uploaded_file['file'];
					$file_title_for_media_library = $_FILES['file_instant']['name'];

					$arr_file_type 		= wp_check_filetype(basename($_FILES['file_instant']['name']));
					$uploaded_file_type = $arr_file_type['type'];



					if($uploaded_file_type == "application/zip" or $uploaded_file_type == "application/pdf" or $uploaded_file_type == "application/msword" or $uploaded_file_type == "application/msexcel" or
					$uploaded_file_type == "application/doc" or $uploaded_file_type == "application/docx" or
					$uploaded_file_type == "application/xls" or $uploaded_file_type == "application/xlsx" or $uploaded_file_type == "application/csv" or $uploaded_file_type == "application/ppt" or
					$uploaded_file_type == "application/pptx" or $uploaded_file_type == "application/vnd.ms-excel"
					or $uploaded_file_type == "application/vnd.ms-powerpoint" or $uploaded_file_type == "application/vnd.openxmlformats-officedocument.presentationml.presentation"

					or $uploaded_file_type == "application/octet-stream"
					or $uploaded_file_type == "image/png"
					or $uploaded_file_type == "image/jpg"  or $uploaded_file_type == "image/jpeg"

					  or $uploaded_file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
					  or $uploaded_file_type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document"  )
					{



						$attachment = array(
										'post_mime_type' => $uploaded_file_type,
										'post_title' => addslashes($file_title_for_media_library),
										'post_content' => '',
										'post_status' => 'inherit',
										'post_parent' =>  0,

										'post_author' => $uid,
									);

						$attach_id 		= wp_insert_attachment( $attachment, $file_name_and_location, $pids );
						$attach_data 	= wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
						wp_update_attachment_metadata($attach_id,  $attach_data);




					} else $error_mm = '1';

				}



				$message 		= projecttheme_sanitize_string($_POST['message_a']);
				$uid_send 		= ($_POST['uid_send']);
				$pid_about 		= $_POST['pid_about'];
				$subject_ab 	= $_POST['subject_ab'];

				if(empty($uid_send) or !projecttheme_is_user_valid2($uid_send))
				{
					$do_not_send = 1;
					$reason_err[] = __('User is empty or not valid.','ProjectTheme');
				}


				if(strlen($message) < 10)
				{
					$do_not_send = 1;
					$reason_err[] = __('Please type in a few words at least.','ProjectTheme');
				}

				$myuid = $current_user->ID;


				//echo $message;
				//*********************************************

				$ProjectTheme_moderate_private_messages = get_option('ProjectTheme_moderate_private_messages');
				if($ProjectTheme_moderate_private_messages == "yes") $ProjectTheme_moderate_private_messages = true;
				else $ProjectTheme_moderate_private_messages = false;

				//--------------------------

				if($ProjectTheme_moderate_private_messages == true)
				{
					$admin_approved = 0;
					$approved = 0;
					$show_to_destination = 0;
				}
				else
				{
					$admin_approved = 1;
					$approved = 1;
					$show_to_destination = 1;
				}

				//*********************************************


				global $wpdb;
				$tm = projecttheme_sanitize_string($_POST['tm']); //current_time('timestamp',0);


				$sr = "select * from ".$wpdb->prefix."project_pm_threads where (user1='$myuid' and user2='$uid_send') or (user2='$myuid' and user1='$uid_send') and pid='$pid_about' ";
				$rr = $wpdb->get_results($sr);

				if(count($rr) == 0)
				{

					if(empty($pid)) $pid = 0;

					$s = "insert into ".$wpdb->prefix."project_pm_threads
					(user1, user2, datemade, lastupdate, pid, admin_approved, message_title)
					values('$myuid','$uid_send','$tm','$tm','$pid','$admin_approved', '$subject_ab' )";

					$wpdb->query($s);

					//------------------------------

					$sr = "select * from ".$wpdb->prefix."project_pm_threads where (user1='$myuid' and user2='$uid_send') or (user2='$myuid' and user1='$uid_send') and pid='$pid_about' ";
					$rr = $wpdb->get_results($sr);

					//if($ProjectTheme_moderate_private_messages == false)
						//ProjectTheme_send_email_on_priv_mess_received($myuid, $uids);

				}

				$thread_message_id = $rr[0]->id;

				$sr = "select * from ".$wpdb->prefix."project_pm where initiator='$myuid' and user='$uid_send' and datemade='$tm' and threadid='$thread_message_id'";
				$rr = $wpdb->get_results($sr);


				if(count($rr) == 0)
				{

					if(empty($subject))
					{
								$subject = stripslashes($_POST['subject_a']);
					}

					$s = "insert into ".$wpdb->prefix."project_pm
					(approved, subject, content, datemade, pid, initiator, user, file_attached, show_to_destination, threadid)
					values('$approved','$subject','$message','$tm','$pid','$myuid','$uid_send', '$attach_id', '$show_to_destination', '$thread_message_id')";

					$wpdb->query($s);


					//------------------------------

					if($ProjectTheme_moderate_private_messages == false)
						ProjectTheme_send_email_on_priv_mess_received($myuid, $uids);
					else
					{
						//send message to admin to moderate

					}

				}

				$sent_msg = 1;


			//-----------------------

				if($do_not_send != 1)
				{

						?>

						<div class="card">
						<div class="padd10">
						 <?php

						 if($ProjectTheme_moderate_private_messages == false)
							echo sprintf(__('Your message has been sent. <a href="%s">Go to inbox</a>.','ProjectTheme'), get_permalink(get_option('ProjectTheme_my_account_private_messages_id')));
						 else
							_e('Your message has been sent but the receiver will receive it only after moderation.','ProjectTheme')

						  ?>
						</div>
						</div>

						<?php

				}







			}


					if($do_not_send == 1) {

					 if(count($reason_err) > 0)
					 {
						 echo '<div class="alert alert-danger"> ';
						 foreach($reason_err as $z1)
						 {
							 echo $z1 . '<br/>';
						 }
						 echo '</div>';
					 }

					}

				}

			if($sent_msg != 1)
			{

		?>

	<h5 class="my-account-headline-1"><?php _e("Send Private Message to: ","ProjectTheme"); ?> <?php echo $user->user_login; ?></h5>

        <div class="card">

     <div class="box_content">

			 <form  method="post" enctype="multipart/form-data">
				 <input type="hidden" name="tm" value="<?php echo current_time('timestamp',0); ?>" />
				 <input type="hidden" name="uid_send" value="<?php echo sanitize_text_field($_GET['uid']); ?>" />
 <input type="hidden" name="pid_about" value="<?php echo sanitize_text_field($_GET['pid']); ?>" />

 <?php
			if(!empty($subject))
			{
  ?>
 						<input type="hidden" name="subject_ab" value="<?php echo  ($subject); ?>" />
<?php } ?>


			   <div class="form-group">
			     <label for="exampleInputEmail1"><?php _e("Subject:", "ProjectTheme"); ?></label>
					  <input size="50" class="form-control" <?php if(!empty($subject)) { ?> disabled <?php } else { ?> required <?php } ?> name="subject_a" type="text" value="<?php echo $subject; ?>" />
			   </div>


				 <div class="form-group">
			     <label for="exampleInputPassword1"><?php _e("Message:", "ProjectTheme"); ?></label>
					 <textarea name="message_a" class="form-control"  rows="6" cols="50"></textarea>
			   </div>



				 <div class="form-group">
					<label for="exampleInputPassword1"><?php _e("Attach File:", "ProjectTheme"); ?></label>
					<input type="file" name="file_instant" class="form-control"  />
				</div>




				 <input name="send_a" class="btn btn-primary" type="submit" value="<?php _e("Send Message",'ProjectTheme'); ?>" />
			 </form>



                </div>
                </div>


			<?php   }} ?>


		</div>  </div> <!-- end dif content -->





<?php
}


?>
