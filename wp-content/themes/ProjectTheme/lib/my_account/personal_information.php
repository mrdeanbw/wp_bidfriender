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


function ProjectTheme_my_account_personal_info_function()
{

		global $current_user, $wpdb, $wp_query;
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;



			do_action('pt_for_demo_work_3_0');
				pt_account_main_menu_new();

?>
<div class="row">
	    <?php ProjectTheme_get_users_links(); ?>


    <div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">
           <?php

				if(isset($_POST['save-info']))
				{
					//if(file_exists('cimy_update_ExtraFields'))
					cimy_update_ExtraFields_new_me();


								  do_action('pt_do_action_at_save_of_user_settings');


					require_once(ABSPATH . "wp-admin" . '/includes/file.php');
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');

					if(!empty($_FILES['avatar']["name"]))
					{

						$upload_overrides 	= array( 'test_form' => false );
               			$uploaded_file 		= wp_handle_upload($_FILES['avatar'], $upload_overrides);

						$file_name_and_location = $uploaded_file['file'];
                		$file_title_for_media_library = $_FILES['avatar'  ]['name'];

						$file_name_and_location = $uploaded_file['file'];
						$file_title_for_media_library = $_FILES['avatar']['name'];

						$arr_file_type 		= wp_check_filetype(basename($_FILES['avatar']['name']));
						$uploaded_file_type = $arr_file_type['type'];
						$urls  = $uploaded_file['url'];



						if($uploaded_file_type == "image/png" or $uploaded_file_type == "image/jpg" or $uploaded_file_type == "image/jpeg" or $uploaded_file_type == "image/gif" )
						{

							$attachment = array(
											'post_mime_type' => $uploaded_file_type,
											'post_title' => 'User Avatar',
											'post_content' => '',
											'post_status' => 'inherit',
											'post_parent' =>  0,
											'post_author' => $uid,
										);



							$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, 0 );
							$attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
							wp_update_attachment_metadata($attach_id,  $attach_data);



							$_wp_attached_file = get_post_meta($attach_id,'_wp_attached_file',true);

							if(!empty($_wp_attached_file))
							update_user_meta($uid, 'avatar_project',  ($attach_id) );

						}

					}

					//------ cover_image

					if(!empty($_FILES['cover_image']["name"]))
					{

						$upload_overrides 	= array( 'test_form' => false );
               			$uploaded_file 		= wp_handle_upload($_FILES['cover_image'], $upload_overrides);

						$file_name_and_location = $uploaded_file['file'];
                		$file_title_for_media_library = $_FILES['cover_image'  ]['name'];

						$file_name_and_location = $uploaded_file['file'];
						$file_title_for_media_library = $_FILES['cover_image']['name'];

						$arr_file_type 		= wp_check_filetype(basename($_FILES['cover_image']['name']));
						$uploaded_file_type = $arr_file_type['type'];
						$urls  = $uploaded_file['url'];



						if($uploaded_file_type == "image/png" or $uploaded_file_type == "image/jpg" or $uploaded_file_type == "image/jpeg" or $uploaded_file_type == "image/gif" )
						{

							$attachment = array(
											'post_mime_type' => $uploaded_file_type,
											'post_title' => 'User Profile Cover',
											'post_content' => '',
											'post_status' => 'inherit',
											'post_parent' =>  0,
											'post_author' => $uid,
										);



							$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, 0 );
							$attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
							wp_update_attachment_metadata($attach_id,  $attach_data);



							$_wp_attached_file = get_post_meta($attach_id,'_wp_attached_file',true);

							if(!empty($_wp_attached_file))
							update_user_meta($uid, 'profile_cover',  ($attach_id) );

						}

					}

					//---------------------

					$wpdb->query("delete from ".$wpdb->prefix."project_email_alerts where uid='$uid' ");

					$email_cats = ($_POST['email_cats']);

					if(is_array($email_cats) )
					foreach($email_cats as $em)
					{
						$em = projecttheme_sanitize_string($em);
						$wpdb->query("insert into ".$wpdb->prefix."project_email_alerts (uid,catid) values('$uid','$em') ");
					}

					//-------

					$wpdb->query("delete from ".$wpdb->prefix."project_freelancer_skills where uid='$uid' ");



					 $skills_thing = str_replace('[', "", $_POST['skills_thing']);
					 $skills_thing = str_replace("]", "", $skills_thing);

 				 		$skills_thing = explode(",", $skills_thing);


					if(is_array($skills_thing) )
					foreach($skills_thing as $skl)
					{
						$skl = str_replace('\"', "", $skl);


						$term = get_term_by( 'name', $skl, 'project_skill');
						$em = $term->term_id;

						if($em > 0)
						$wpdb->query("insert into ".$wpdb->prefix."project_freelancer_skills (uid,catid) values('$uid','$em') ");
					}



					//---------------------


					$first_name = $_POST['first_name'];
					$last_name = $_POST['last_name'];
					$user_id = wp_update_user( array( 'ID' => $uid, 'first_name' => $first_name, 'last_name' => $last_name ) );

					//-------------------
					//email_locs
					//****************************************************************************************************
					$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
					if($ProjectTheme_enable_project_location != "no"):


						$wpdb->query("delete from ".$wpdb->prefix."project_email_alerts_locs where uid='$uid' ");

						$email_cats = $_POST['email_locs'];

						if(is_array($email_cats)  )
						foreach($email_cats as $em)
						{
							$em = projecttheme_sanitize_string($em);
							$wpdb->query("insert into ".$wpdb->prefix."project_email_alerts_locs (uid,catid) values('$uid','$em') ");
						}

					endif;

					//****************************************************************************************************
					//-------------------

					$user_description = trim($_POST['user_description']);
					update_user_meta($uid, 'user_description', $user_description);


					$per_hour = trim($_POST['per_hour']);
					update_user_meta($uid, 'per_hour', $per_hour);


					$user_location = trim($_POST['project_location_cat']);
					update_user_meta($uid, 'user_location', $user_location);

					$user_city = trim($_POST['user_city']);
					update_user_meta($uid, 'user_city', $user_city);

					$personal_info = trim($_POST['paypal_email']);
					update_user_meta($uid, 'paypal_email', $personal_info);

					$personal_info = trim($_POST['payza_email']);
					update_user_meta($uid, 'payza_email', $personal_info);

					$personal_info = trim($_POST['moneybookers_email']);
					update_user_meta($uid, 'moneybookers_email', $personal_info);

					$user_url = trim($_POST['user_url']);
					update_user_meta($uid, 'user_url', $user_url);

					do_action('ProjectTheme_pers_info_save_action');

					if(isset($_POST['password']) && !empty($_POST['password']) and isset($_POST['reppassword']) && !empty($_POST['reppassword']))
					{
						$p1 = trim($_POST['password']);
						$p2 = trim($_POST['reppassword']);

						if(!empty($p1) && !empty($p2))
						{

							if($p1 == $p2)
							{
								global $wpdb;
								$newp = md5($p1);
								$sq = "update ".$wpdb->users." set user_pass='$newp' where ID='$uid'" ;
								$wpdb->query($sq);

								$inc = 1;
							}
							else {
							echo '<div class="error">'.__("Password was not updated. Passwords do not match!","ProjectTheme").'</div>'; $xxp = 1; }
						}
						else
						{

							echo '<div class="error">'.__("Password was not updated. Passwords do not match!","ProjectTheme").'</div>';	 $xxp = 1;
						}
					}



					//---------------------------------------

					$arr = $_POST['custom_field_id'];
					if(is_array($arr))
					for($i=0;$i<count($arr);$i++)
					{
						$ids 	= $arr[$i];
						$value 	= $_POST['custom_field_value_'.$ids];

						if(is_array($value))
						{
							delete_user_meta($uid, "custom_field_ID_".$ids);

							for($j=0;$j<count($value);$j++) {
								add_user_meta($uid, "custom_field_ID_".$ids, $value[$j]);

							}
						}
						else
						update_user_meta($uid, "custom_field_ID_".$ids, $value);

					}

					//--------------------------------------------
					if($xxp != 1)
					{
						echo '<div class="alert alert-success">'.__('Info saved!','ProjectTheme');

						if($inc == 1)
						{

							echo '<br/>'.__('Your password was changed. Redirecting to login page...','ProjectTheme');
							echo '<meta http-equiv="refresh" content="2; url='.home_url().'/wp-login.php">';

						}

						echo '</div>';
					}
				}
				$user = get_userdata($uid);

				$user_location = get_user_meta($uid, 'user_location',true);

				?>


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



	<?php $user = get_userdata($uid); ?>

	</script>

             <form method="post"  enctype="multipart/form-data">


<h3 class="my-account-headline-1"><?php echo __('Account Settings','ProjectTheme'); ?></h3>

			<div class="card"><div class="card-body"> <div class="row">


				<?php do_action('pt_do_action_at_top_of_user_settings') ?>


				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('Username','ProjectTheme'); ?></label>
										<input type="text" size="35" value="<?php echo $user->user_login; ?>" disabled="disabled" class="form-control" />
					</div>
        </div>


				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('First name','ProjectTheme'); ?></label>
										<input type="text" size="35" name="first_name" value="<?php echo $user->first_name; ?>" class="form-control" />
					</div>
        </div>


				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('Last name','ProjectTheme'); ?></label>
										<input type="text" size="35" name="last_name" value="<?php echo $user->last_name; ?>" class="form-control" />
					</div>
        </div>

				<?php

					$opt = get_option('ProjectTheme_enable_project_location');
					if($opt != 'no'){

				?>

				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('Location','ProjectTheme'); ?></label>
										<?php	echo ProjectTheme_get_categories("project_location", $user_location , __("Select Location","ProjectTheme"), "form-control"); ?>
					</div>
        </div>


				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('City','ProjectTheme'); ?></label>
										<input type="text" size="35" name="user_city" value="<?php echo get_user_meta($uid, 'user_city', true); ?>" class="form-control" />
					</div>
        </div>



			<?php } ?>



			<div class="col-md-12">
				<div class="form-group">
									<label class="form-label"><?php echo __('Description','ProjectTheme'); ?></label>
									<textarea cols="40" rows="5"  name="user_description" class="tinymce-enabled form-control"><?php echo strip_tags(get_user_meta($uid,'user_description',true)); ?></textarea>
				</div>
			</div>



        <?php

        $opt = get_option('ProjectTheme_paypal_enable');
		if($opt == "yes"):

		?>



				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('PayPal Email','ProjectTheme'); ?></label>
										<input type="text" size="35" name="paypal_email" value="<?php echo get_user_meta($uid, 'paypal_email', true); ?>" class="form-control" />
					</div>
				</div>

        <?php
		endif;

        $opt = get_option('ProjectTheme_moneybookers_enable');
		if($opt == "yes"):

		?>

		<div class="col-md-12">
			<div class="form-group">
								<label class="form-label"><?php echo __('Skrill email','ProjectTheme'); ?></label>
								<input type="text" size="35" name="moneybookers_email" value="<?php echo get_user_meta($uid, 'moneybookers_email', true); ?>" class="form-control" />
			</div>
		</div>



        <?php
		endif;

 		?>


		<div class="col-md-12">
			<div class="form-group">
								<label class="form-label"><?php echo __('New Password','ProjectTheme'); ?></label>
								<input type="password" value="" class="form-control" name="password" size="35" />
			</div>
		</div>


		<div class="col-md-12">
			<div class="form-group">
								<label class="form-label"><?php echo __('Confirm Password','ProjectTheme'); ?></label>
								<input type="password" value="" class="form-control" name="reppassword" size="35"  />
			</div>
		</div>


		<?php


		if(ProjectTheme_is_user_provider($uid)):
		$k++;


				$per_hour = get_user_meta($uid,'per_hour',true);

	?>

	<div class="col-md-12">
		<div class="form-group">
				<label class="form-label"><?php echo __('Hourly Rate','ProjectTheme'); ?> </label>
				 <div class="input-group">
							 <span class="input-group-prepend">
								 <span class="input-group-text"><?php echo projectTheme_currency(); ?></span>
							 </span>
							 <input type="number" step="0.01"   class="form-control" value="<?php echo $per_hour ?>" name="per_hour" placeholder="<?php _e("Your hourly rate","ProjectTheme"); ?>" />


						 </div>


			 </div>
 		</div>
			<?php endif; ?>


			<script>

			jQuery(document).ready(function(){



            jQuery('#inputGroupFile02').on('change',function(){
                //get the file name
                var fileName = jQuery(this).val();
                //replace the "Choose a file" label
                jQuery(this).next('.custom-file-label').html(fileName);
            });

						});
        </script>

		<div class="col-md-12">
			<div class="form-group">
								<label class="form-label"><?php echo __('Profile Avatar','ProjectTheme'); ?></label>
								<div class="custom-file">
								<input type="file" name="avatar" class='custom-file-input' id="inputGroupFile02" />
								<label class="custom-file-label"><?php echo __('Choose file','ProjectTheme'); ?></label>
							</div>
						            <img width="50" height="50" border="0" src="<?php echo ProjectTheme_get_avatar($uid,50,50); ?>" />
			</div>
		</div>


		<div class="col-md-12">
			<div class="form-group">
								<label class="form-label"><?php echo __('Profile Cover Image','ProjectTheme'); ?></label>
								<div class="custom-file">
								<input type="file" name="cover_image" class='custom-file-input' />
								<label class="custom-file-label"><?php echo __('Choose file','ProjectTheme'); ?></label>
							</div>
						            <img width="150" height="50" border="0" src="<?php echo ProjectTheme_get_profile_cover($uid,50,50); ?>" />
			</div>
		</div>



        <?php do_action('ProjectTheme_pers_info_fields_1'); ?>
				<?php do_action('ProjectTheme_pers_info_fields_2'); ?>


				<?php


				 $uid = $current_user->ID;
				$cid = $uid;

						if(ProjectTheme_is_user_provider($uid)){

					?>

					<div class="col-md-12">
						<div class="form-group">
											<label class="form-label"><?php echo __('Your Skills','ProjectTheme'); ?></label>



											<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.plugin.arrow.css" type="text/css" />
												<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.core.js" type="text/javascript" charset="utf-8"></script>

		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.core.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.plugin.tags.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.plugin.autocomplete.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.plugin.focus.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.plugin.prompt.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/textdropdown/css/textext.plugin.arrow.css" type="text/css" />
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.core.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.tags.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.autocomplete.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.suggestions.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.filter.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.focus.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.prompt.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.ajax.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/textdropdown/js/textext.plugin.arrow.js" type="text/javascript" charset="utf-8"></script>



		<?php

		global $wpdb;
		$ss 		= "select * from ".$wpdb->prefix."project_freelancer_skills where uid='$uid'";
		$rr 		= $wpdb->get_results($ss);
		$arr1 	= '';



		 ?>

											<script type="text/javascript">
											jQuery(document).ready(function () {


													jQuery( "#skills_me" ).width( jQuery( "#x1cs" ).width() );

											    jQuery('#skills_me')
											        .textext({
											            plugins : 'tags prompt focus autocomplete ajax arrow',
																	tagsItems : [  <?php

																	 foreach($rr as $row)
																	 {
																				 $term = get_term_by( 'id', $row->catid, 'project_skill');
																				  echo "'" . $term->name . "' ,";
																	 }

																		?> ],

																	prompt : 'Add one...',
											            ajax : {
											                url : '<?php echo get_site_url() ?>/?p_action=josnskills',
											                dataType : 'json',
											                cacheResults : true
											            }
											        });





														});
											</script>



											<div style="width: 100%;" id="x1cs">
												<input type="text" style="width: 200px; height: 55px"  id="skills_me"   name="skills_thing" />

										</div>
					  </div></div>






				<div class="col-md-12">
					<div class="form-group">
										<label class="form-label"><?php echo __('Portfolio Pictures','ProjectTheme'); ?></label>


										<div class="cross_cross">



				 <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/dropzone.js"></script>
				 <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/dropzone.css" type="text/css" />




					 <script>


				 jQuery(function() {

			 Dropzone.autoDiscover = false;
			 var myDropzoneOptions = {
				 maxFilesize: 15,
					 addRemoveLinks: true,
				 acceptedFiles:'image/*',
					 clickable: true,
				 url: "<?php echo home_url() ?>/?my_upload_of_project_files8=1",
			 };

			 var myDropzone = new Dropzone('div#myDropzoneElement2', myDropzoneOptions);

			 myDropzone.on("sending", function(file, xhr, formData) {
				 formData.append("author_abs", "<?php echo $current_user->ID; ?>"); // Will send the filesize along with the file as POST data.
				 formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
			 });


					 <?php

					 $args = array(
					 'order'          => 'ASC',
					 'orderby'        => 'post_date',
					 'post_type'      => 'attachment',
					 'author'    => 		$current_user->ID,
					 'meta_key' 			=> 'is_portfolio',
					 'meta_value' 		=> '1',

					 'numberposts'    	=> -1,
					 );

				 $attachments = get_posts($args);


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



				 <?php _e('Click the grey area below to add project images.','ProjectTheme') ?>
					 <div class="dropzone dropzone-previews" id="myDropzoneElement2" ></div>


				 </div>

									</div>
								</div>



								<div class="col-md-12">
									<div class="form-group">
														<label class="form-label"><?php echo __('Email Alerts','ProjectTheme'); ?></label>
								<div style="border:1px solid #ccc;background:#f2f2f2; overflow:auto; width:100%; border-radius:5px; padding:20px; box-sizing: border-box; height:160px;">

								<?php

			global $wpdb;
			$ss = "select * from ".$wpdb->prefix."project_email_alerts where uid='$uid'";
			$rr = $wpdb->get_results($ss);

			$terms = get_terms( 'project_cat', 'parent=0&orderby=name&hide_empty=0' );

			foreach($terms as $term):

				$chk = (projectTheme_check_list_emails($term->term_id, $rr) == true ? "checked='checked'" : "");

				echo '<input type="checkbox" name="email_cats[]" '.$chk.' value="'.$term->term_id.'" /> '.$term->name."<br/>";

				$terms2 = get_terms( 'project_cat', 'parent='.$term->term_id.'&orderby=name&hide_empty=0' );
				foreach($terms2 as $term2):


					$chk = (projectTheme_check_list_emails($term2->term_id, $rr) == 1 ? "checked='checked'" : "");
					echo '&nbsp;&nbsp; &nbsp; <input type="checkbox" name="email_cats[]" '.$chk.' value="'.$term2->term_id.'" /> '.$term2->name."<br/>";

					$terms3 = get_terms( 'project_cat', 'parent='.$term2->term_id.'&orderby=name&hide_empty=0' );
					foreach($terms3 as $term3):

						$chk = (projectTheme_check_list_emails($term3->term_id, $rr) == 1 ? "checked='checked'" : "");
						echo '&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; <input type="checkbox" '.$chk.' name="email_cats[]"
						value="'.$term3->term_id.'" /> '.$term3->name."<br/>";
					endforeach;

				endforeach;

			endforeach;

		?>

								</div>
								<br/>
								*<?php _e('you will get an email notification when a project is posted in the selected categories','ProjectTheme'); ?></div></div>


								<?php

							$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
							if($ProjectTheme_enable_project_location != "no"){

							?>
								<div class="col-md-12">
									<div class="form-group">

								<div style="border:1px solid #ccc;background:#f2f2f2; overflow:auto; width:100%; border-radius:5px; padding:20px; box-sizing: border-box; height:160px;">

								<?php

			global $wpdb;
			$ss = "select * from ".$wpdb->prefix."project_email_alerts_locs where uid='$uid'";
			$rr = $wpdb->get_results($ss);

			$terms = get_terms( 'project_location', 'parent=0&orderby=name&hide_empty=0' );

			foreach($terms as $term):

				$chk = (projectTheme_check_list_emails($term->term_id, $rr) == true ? "checked='checked'" : "");

				echo '<input type="checkbox" name="email_locs[]" '.$chk.' value="'.$term->term_id.'" /> '.$term->name."<br/>";

				$terms2 = get_terms( 'project_location', 'parent='.$term->term_id.'&orderby=name&hide_empty=0' );
				foreach($terms2 as $term2):


					$chk = (projectTheme_check_list_emails($term2->term_id, $rr) == 1 ? "checked='checked'" : "");
					echo '&nbsp;&nbsp; &nbsp; <input type="checkbox" name="email_locs[]" '.$chk.' value="'.$term2->term_id.'" /> '.$term2->name."<br/>";

					$terms3 = get_terms( 'project_location', 'parent='.$term2->term_id.'&orderby=name&hide_empty=0' );
					foreach($terms3 as $term3):

						$chk = (projectTheme_check_list_emails($term3->term_id, $rr) == 1 ? "checked='checked'" : "");
						echo '&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; <input type="checkbox" '.$chk.' name="email_locs[]"
						value="'.$term3->term_id.'" /> '.$term3->name."<br/>";
					endforeach;

				endforeach;

			endforeach;

		?>

								</div>
								<br/>
								*<?php _e('you will get an email notification when a project is posted in the selected locations','ProjectTheme'); ?></div></div>



							<?php  } } ?>

				<?php


		$user_tp = pt_get_user_role($uid);


		if($user_tp == "service_provider")
			$catid = array('service_provider');


			if($user_tp == "business_owner")
				$catid = array('service_buyer','business_owner');





		$k = 0;
		$arr = ProjectTheme_get_users_category_fields($catid, $uid);
		$exf = '';

		for($i=0;$i<count($arr);$i++)
		{

							$exf .= '<div class="col-md-12"><div class="form-group">';
					$exf .= '<label class="form-label">'.$arr[$i]['field_name'].$arr[$i]['id'].':</label>';
					$exf .=  $arr[$i]['value'] ;
					$exf .= '</div></div>';

					$k++;

		}

		echo $exf; ?>




   <?php

   if(function_exists('cimy_extract_ExtraFields'))
   cimy_extract_ExtraFields();

   ?>




</div> </div>

				<div class="card-footer text-right">


                    <input type="submit" name="save-info" class="btn btn-success" value="<?php _e("Save Settings" ,'ProjectTheme'); ?>" />

                </div>

          </div>











		</form>


        </div>  </div> <!-- end dif content -->





<?php
}


?>
