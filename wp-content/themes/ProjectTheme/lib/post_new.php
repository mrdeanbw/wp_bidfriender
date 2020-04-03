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


function ProjectTheme_post_new_area_function()
{

	global $wp_query, $projectOK, $current_user, $MYerror;
	$current_user = wp_get_current_user();

	$new_Project_step = $wp_query->query_vars['post_new_step'];
	if(empty($new_Project_step)) $new_Project_step = 1;

	$pid = $wp_query->query_vars['projectid']; if($pid == 0) $pid = 1;
	$uid = $current_user->ID;

?>
    	<div id="content" class="sonita">

            <div class="card" id="post-new-card">
                <div class="box_content padding25">

                <?php

				$is_it_allowed = true;
				$is_it_allowed = apply_filters('ProjectTheme_is_it_allowed_post_projects', $is_it_allowed);

				if($is_it_allowed != true):

					do_action('ProjectTheme_post_project_not_allowed_message');

				else:

				?>



				<div class="row bs-wizard" style="border-bottom:0;">

									                <div class="col-3 col-sm-3 bs-wizard-step <?php if($new_Project_step > 1) echo 'complete'; elseif($new_Project_step == 1) echo 'active'; else echo 'disabled'; ?>  ">
									                  <div class="text-center bs-wizard-stepnum"><?php echo __("Project Info", 'ProjectTheme') ?> </div>
									                  <div class="progress"><div class="progress-bar"></div></div>
									                  <a href="#" class="bs-wizard-dot"></a>

									                </div>

									                <div class="col-3 col-sm-3 bs-wizard-step  <?php if($new_Project_step > 2) echo 'complete'; elseif($new_Project_step == 2) echo 'active'; else echo 'disabled'; ?> "><!-- complete -->
									                  <div class="text-center bs-wizard-stepnum"><?php echo __("Options", 'ProjectTheme') ?></div>
									                  <div class="progress"><div class="progress-bar"></div></div>
									                  <a href="#" class="bs-wizard-dot"></a>

									                </div>

									                <div class="col-3 col-sm-3 bs-wizard-step <?php if($new_Project_step > 3) echo 'complete'; elseif($new_Project_step == 3) echo 'active'; else echo 'disabled'; ?>  "><!-- complete -->
									                  <div class="text-center bs-wizard-stepnum"><?php echo __("Preview", 'ProjectTheme') ?></div>
									                  <div class="progress"><div class="progress-bar"></div></div>
									                  <a href="#" class="bs-wizard-dot"></a>

									                </div>

									                <div class="col-3 col-sm-3 bs-wizard-step <?php if($new_Project_step > 4) echo 'complete'; elseif($new_Project_step == 4) echo 'active'; else echo 'disabled'; ?>  "><!-- active -->
									                  <div class="text-center bs-wizard-stepnum"><?php echo __("Finish", 'ProjectTheme') ?></div>
									                  <div class="progress"><div class="progress-bar"></div></div>
									                  <a href="#" class="bs-wizard-dot"></a>

									                </div>
									            </div>


    			<?php



//****************************************************************************************


if($new_Project_step == "1")
{
	//-----------------

	$location 	= wp_get_object_terms($pid, 'project_location', array('order' => 'ASC', 'orderby' => 'term_id' ));
	$cat 		= wp_get_object_terms($pid, 'project_cat', array('order' => 'ASC', 'orderby' => 'term_id' ));



	if(!empty($pid))
	$post 		= get_post($pid);


	if(is_array($MYerror) and count($MYerror) > 0)
	if($projectOK == 0)
	{
		echo '<div class="alert alert-danger">';

			echo __('Your form has errors. Please check below, correct the errors, then submit again.','ProjectTheme');

		echo '</div>';

	}

	?>
    <div class="sonita2">
 <form method="post" action="<?php echo ProjectTheme_post_new_with_pid_stuff_thg($pid, '1');?>">
    <ul class="post-new">
    <?php do_action('ProjectTheme_step1_before_title'); ?>



        <li class="<?php echo projecttheme_get_post_new_error_thing('project_title') ?>">
        <?php echo projecttheme_get_post_new_error_thing_display('project_title') ?>

        	<h2><?php echo __('Your project title', 'ProjectTheme'); ?></h2>
        	<p><input type="text" size="50" class="form-control" name="project_title" placeholder="<?php _e('eg: I need a website created very soon.','ProjectTheme') ?>" value="<?php echo (empty($_POST['project_title']) ?
			($post->post_title == "Auto Draft" ? "" : $post->post_title) : $_POST['project_title']); ?>" /></p>
        </li>

         <!-- <?php do_action('ProjectTheme_step1_before_description'); ?>
        <?php


			$pst = $post->post_content;
			$pst = str_replace("<br />","",$pst);

		?>
        <li class="<?php echo projecttheme_get_post_new_error_thing('project_description') ?>">
        <?php echo projecttheme_get_post_new_error_thing_display('project_description') ?>

        	<h2><?php echo __('Description', 'ProjectTheme'); ?></h2>
        <p><textarea rows="6" cols="60" class="form-control" placeholder="<?php _e('Describe here your project scope.','ProjectTheme') ?>"  name="project_description"><?php echo trim($pst); ?></textarea></p>
        </li>


				<li class="<?php echo projecttheme_get_post_new_error_thing('project_category') ?>">
				<?php echo projecttheme_get_post_new_error_thing_display('project_category') ?>
        	<h2><?php _e('Categories','ProjectTheme'); ?></h2> -->


     <?php do_action('ProjectTheme_step1_before_category'); ?>

            <script>

									function display_subcat(vals)
									{
										jQuery.post("<?php echo esc_url( home_url() ) ; ?>/?get_subcats_for_me=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {

												jQuery('#sub_cats').html(data);

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








            <?php if(get_option('ProjectTheme_enable_multi_cats') == "yes"): ?>
			<div class="multi_cat_placeholder_thing">

            	<?php

					$selected_arr = ProjectTheme_build_my_cat_arr($pid);
					echo projectTheme_get_categories_multiple('project_cat', $selected_arr);

				?>

            </div>

            <?php else: ?>

							<p class="strom_100">

			<?php

			 	echo projectTheme_get_categories_clck("project_cat",
                                !isset($_POST['project_cat_cat']) ? (is_array($cat) ? $cat[0]->term_id : "") : htmlspecialchars($_POST['project_cat_cat'])
                                , __('Select Category','ProjectTheme'), "do_input_new", 'onchange="display_subcat(this.value)"' );


								echo '<br/><span id="sub_cats">';


											if(!empty($cat[1]->term_id))
											{
												$args2 = "orderby=name&order=ASC&hide_empty=0&parent=".$cat[0]->term_id;
												$sub_terms2 = get_terms( 'project_cat', $args2 );

												$ret = '<select class="do_input_new" name="subcat">';
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



        <?php do_action('ProjectTheme_step1_before_tags');
		$project_tags = '';
		$t = wp_get_post_tags($post->ID);
		foreach($t as $tags)
		{
			$project_tags .= $tags->name . ", ";
		}


		?>
		<li>
        	<h2><?php echo __('Tags', 'ProjectTheme'); ?></h2>
        <p><input type="text" size="50" class="form-control"  name="project_tags" placeholder="<?php _e('eg: something, comma, separated.','ProjectTheme') ?>" value="<?php echo $project_tags; ?>" /> </p>
        </li>


        <?php do_action('ProjectTheme_step1_after_tags'); ?>

        <!-- <li>
        	<h3><?php _e('Skills','ProjectTheme'); ?></h3>
        </li> -->


        <li style="margin-bottom:25px;">

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

$selected_arr = projectTheme_build_my_cat_arr2($pid);


?>

					<script type="text/javascript">
					jQuery(document).ready(function () {


							jQuery( "#skills_me" ).width( jQuery( "#x1cs" ).width() );

							jQuery('#skills_me')
									.textext({
											plugins : 'tags prompt focus autocomplete ajax arrow',
											tagsItems : [  <?php

											 foreach($selected_arr as $row)
											 {
														 $term = get_term_by( 'id', $row, 'project_skill');
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


					<!-- <div style="width: 100%;" id="x1cs">
						<input type="text" style="width: 200px; height: 55px"  id="skills_me"   name="skills_thing" />

				</div> -->



        </li>




  <?php do_action('ProjectTheme_step1_before_price'); ?>

        <li class="images-files-li"><h2><?php echo __('Project Budget', 'ProjectTheme'); ?></h2>
        <p class="strom_100">

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

        <?php do_action('ProjectTheme_step1_before_ending'); ?>

        <li class="images-files-li">
        <h2>

        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>


        <link rel="stylesheet" media="all" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ui_thing.css" />
		<script type="text/javascript" language="javascript" src="<?php echo get_template_directory_uri(); ?>/js/timepicker.js"></script>


       <?php _e("Project Ending On",'ProjectTheme'); ?></h2>
       <?php

	   $dt = get_post_meta($pid,'ending',true);

	   if(!empty($dt))
	   $dt = date_i18n('d-m-Y',$dt);

	   ?>
       <p><input type="text" name="ending" id="ending" class="form-control" autocomplete="off" value="<?php echo $dt; ?>"  /></p>
       </li>

 		<script>
		<?php

			$dd = get_option('projectTheme_project_period');
			if(empty($dd)) $dd = 7;

		?>

			var myDate=new Date();
			var dateToday = new Date();
			myDate.setDate(myDate.getDate()+<?php echo $dd; ?>);

			jQuery(document).ready(function() {
				 jQuery('#ending').datepicker({ maxDate: myDate, prevText: "", nextText: "", minDate: dateToday

			});});

 		</script>






        <!-- <?php do_action('ProjectTheme_step1_before_location'); ?>
        <?php

			$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
			if($ProjectTheme_enable_project_location == "yes"):

		?>



        <li  class="<?php echo projecttheme_get_post_new_error_thing('project_location') ?>">
        <?php echo projecttheme_get_post_new_error_thing_display('project_location') ?>

        	<h2><?php echo __('Location', 'ProjectTheme'); ?></h2>
        <p class="strom_100">



        <?php

			 	echo projectTheme_get_categories_clck("project_location",
                                !isset($_POST['project_location_cat']) ? (is_array($location) ? $location[0]->term_id : "") : htmlspecialchars($_POST['project_location_cat'])
                                , __('Select Location','ProjectTheme'), "do_input_new", 'onchange="display_subcat2(this.value)"' );


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

<!-- 
       <?php do_action('ProjectTheme_step1_before_address'); ?>
       <?php

	   $show_address = true;
	   $show_address = apply_filters('ProjectTheme_show_address_filter', $show_address);

	   if($show_address == true):

	   ?>
        <li>
        	<h2><?php echo __('Address','ProjectTheme'); ?></h2>
        <p><input type="text" size="50" class="form-control" placeholder="<?php _e('eg: New York, 13221','ProjectTheme'); ?>"  name="project_location_addr" value="<?php echo !isset($_POST['project_location_addr']) ?
		get_post_meta($pid, 'Location', true) : $_POST['project_location_addr']; ?>" /> </p>
        </li>
        <?php endif; endif; ?> -->



         <!-- <li class="images-files-li"> <h2><?php _e('Attach Images','ProjectTheme'); ?></h2>
        <div class="cross_cross">






    <script>


	jQuery(function() {

Dropzone.autoDiscover = false;
var myDropzoneOptions = {
  maxFilesize: 15,
    addRemoveLinks: true,
	acceptedFiles:'image/*',
    clickable: true,
	url: "<?php echo esc_url( home_url() )  ?>/?my_upload_of_project_files2=1",
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



	<?php _e('Click the grey area below to add project images.','ProjectTheme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement2" ></div>


	</div>
        </li> -->




        <li class="images-files-li">
					<h2><?php _e('Attach Files','ProjectTheme'); ?></h2>
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
					myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo get_template_directory_uri() ?>/images/file_icon.png");


			<?php


	}
	}}


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

	<?php _e('Click the grey area below to add project files.','ProjectTheme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement" ></div>


	</div>
        </li>

        <li>
        <h2>&nbsp;</h2>
        <p>
        <input type="submit" name="project_submit1" value="<?php _e("Next Step", 'ProjectTheme'); ?> >>" class="btn btn-primary" role="button" /></p>
        </li>

        <?php do_action('ProjectTheme_step1_after_submit'); ?>

    </ul>
    </form>
    </div>
    <?php

}



/**************************************************************************************
*
*				step 2
*
**************************************************************************************/

if($new_Project_step == "2")
{
	global $MYerror, $projectOK;

	$cid 	= $current_user->ID;
	do_action('ProjectTheme_post_new_step2_before_images');


	if(is_array($MYerror) and count($MYerror) > 0)
	if($projectOK == 0)
	{
		echo '<div class="alert alert-danger">';

			echo __('Your form has errors. Please check below, correct the errors, then submit again.','ProjectTheme');

		echo '</div>';

	}

	?>




 	<ul class="post-new">




      <form method="post" >
      <?php do_action('ProjectTheme_step2_before_project_files'); ?>





      	<?php /*-------  custom fields  -------- */ ?>
        <?php

		$show_fields_in_step2 = true;
		$show_fields_in_step2 = apply_filters('ProjectTheme_show_fields_in_step2', $show_fields_in_step2);


		if($show_fields_in_step2 == true):

			$catid = ProjectTheme_get_project_primary_cat($pid);
			$arr = ProjectTheme_get_project_category_fields($catid, $pid);


				for($i=0;$i<count($arr);$i++)
				{




							echo '<li class="'.projecttheme_get_post_new_error_thing('custom_field_' . $arr[$i]['id'] ).'"  >';
							echo projecttheme_get_post_new_error_thing_display('custom_field_' . $arr[$i]['id']);
							echo '<h2>'.$arr[$i]['field_name']. '</h2>';
							echo '<p>'.$arr[$i]['value'].'</p>';
							echo '</li>';


				}

		endif;



						   	$ProjectTheme_enable_featured_option = get_option('ProjectTheme_enable_featured_option');
						   	if($ProjectTheme_enable_featured_option != "no"):

						   ?>




        <li>
        <h2><?php _e("Feature project?",'ProjectTheme'); ?></h2>
        <p><input type="checkbox" class="do_input_new1" name="featured" value="1"
		<?php $feature = get_post_meta($pid, 'featured', true); echo ($feature == "1" ? "checked='checked'" : ""); ?> />
        <?php


		$projectTheme_featured_fee = get_option('projectTheme_featured_fee');
		$sl = __('Extra fee is applied','ProjectTheme');
		if(empty($projectTheme_featured_fee) or $projectTheme_featured_fee <= 0) $sl = '';


		printf(__("By clicking this checkbox you mark your project as featured. %s", 'ProjectTheme'), $sl); ?></p>
        </li>

        <?php endif; ?>

        <?php do_action('ProjectTheme_step2_before_feature_project'); ?>


        <?php

						   	$ProjectTheme_enable_sealed_option = get_option('ProjectTheme_enable_sealed_option');
						   	if($ProjectTheme_enable_sealed_option != "no"):

						   ?>

        <li>
        <h2><?php _e("Sealed Bidding?",'ProjectTheme'); ?></h2>
        <p><input type="checkbox" class="do_input_new1" name="private_bids" value="1"
        <?php $private_bids = get_post_meta($pid, 'private_bids', true); echo ($private_bids == "1" ? "checked='checked'" : ""); ?> />
        <?php

		$projectTheme_sealed_bidding_fee = get_option('projectTheme_sealed_bidding_fee');
		$sl = __('Extra fee is applied','ProjectTheme');
		if(empty($projectTheme_sealed_bidding_fee) or $projectTheme_sealed_bidding_fee <= 0) $sl = '';


		printf(__("By clicking this checkbox you hide your project's bids. %s", 'ProjectTheme'), $sl); ?></p>
        </li>
        <?php endif; ?>

        <?php do_action('ProjectTheme_step2_before_sealed_bidding'); ?>

        <?php

						   	$ProjectTheme_enable_hide_option = get_option('ProjectTheme_enable_hide_option');
						   	if($ProjectTheme_enable_hide_option != "no"):

						   ?>

        <li>
        <h2><?php _e("Hide Project from search engines",'ProjectTheme'); ?></h2>
        <p><input type="checkbox" class="do_input_new1" name="hide_project" value="1"
        <?php $hide_project = get_post_meta($pid, 'hide_project', true); echo ($hide_project == "1" ? "checked='checked'" : ""); ?>/>
        <?php

		$projectTheme_hide_project_fee = get_option('projectTheme_hide_project_fee');
		$sl = __('Extra fee is applied','ProjectTheme');
		if(empty($projectTheme_hide_project_fee) or $projectTheme_hide_project_fee <= 0) $sl = '';

		echo sprintf(__("By clicking this checkbox you hide your project from search engines. %s", 'ProjectTheme'), $sl); ?></p>
        </li>
        <?php endif; ?>

		<?php do_action('ProjectTheme_step2_before_hide_project'); ?>




        <li>
        <h2>&nbsp;</h2>
        <?php

		$stp = 1;
		$stp = apply_filters('ProjectTheme_filter_go_back_stp2', $stp);

		?>
        <p><a href="<?php echo ProjectTheme_post_new_with_pid_stuff_thg($pid, $stp); ?>" class="btn btn-primary" role="button" ><?php _e('Go Back','ProjectTheme'); ?></a>
        <input type="submit" name="project_submit2" value="<?php _e("Next Step", 'ProjectTheme'); ?> >>" class="btn btn-primary" role="button" /></p>
        </li>


    </ul>
    </form>



    <?php
}


do_action('ProjectTheme_see_if_we_can_add_steps', $new_Project_step, $pid );

/**************************************************************************************
*
*				step 3
*
**************************************************************************************/

if($new_Project_step == "3")
{



?>

<div class="padd10">

<a href="<?php echo ProjectTheme_post_new_with_pid_stuff_thg($pid, 2); ?>" class="btn btn-primary" role="button" ><?php _e('Go Back','ProjectTheme'); ?></a>
<a href="<?php echo ProjectTheme_post_new_with_pid_stuff_thg($pid, 4); ?>" class="btn btn-primary" role="button" ><?php _e('Next Step','ProjectTheme'); ?> >></a>

</div>
<div class="clear10"></div>

<hr color="efefef" />


</div></div>


<div><div>


<?php


	$uid = $current_user->ID;
	global $wpdb;
	$post_AU = get_post($pid);
	$PID_PID = $pid;


?>


<link media="screen" rel="stylesheet" href="'.get_template_directory_uri().'/css/colorbox.css" />
<script src="'.get_template_directory_uri().'/js/jquery.colorbox.js"></script>
<script>


			jQuery(document).ready(function(){

				jQuery("a[rel='image_gal1']").colorbox();
				jQuery("a[rel='image_gal2']").colorbox();




				jQuery('.get_files').click( function () {

					var myRel = jQuery(this).attr('rel');
					myRel = myRel.split("_");

					jQuery.colorbox({href: "<?php echo esc_url( home_url() )  ?>/?get_files_panel=" + myRel[0] +"&uid=" + myRel[1] });
					return false;
				});


				jQuery("#report-this-link").click( function() {

					if(jQuery("#report-this").css('display') == 'none')
					jQuery("#report-this").show('slow');
					else
					jQuery("#report-this").hide('slow');

					return false;
				});


				jQuery("#contact_seller-link").click( function() {

					if(jQuery("#contact-seller").css('display') == 'none')
					jQuery("#contact-seller").show('slow');
					else
					jQuery("#contact-seller").hide('slow');

					return false;
				});

		});
</script>




  <?php


	$location   		= get_post_meta($PID_PID, "Location", true);
	$ending     		= get_post_meta($PID_PID, "ending", true);
	$featured     		= get_post_meta($PID_PID, "featured", true);
	$private_bids     	= get_post_meta($PID_PID, "private_bids", true);

	//---- increase views

	$views    	= get_post_meta($PID_PID, "views", true);
	$views 		= $views + 1;
	update_post_meta($PID_PID, "views", $views);



?>





<div class="row"> <div class="col col-sm-12 col-lg-8">





 			<div class="project-signle-content-main card">



                <?php

				$closed 	 = get_post_meta($PID_PID,'closed',true);

				?>

				<div class="project-page-details-holder">
                <?php
				if($closed == "0") :
				if($bid_posted == "0"): ?>

                        <div class="bid_panel_err">
                        <div class="padd10">
                        <?php _e("Your bid has not been posted. Please correct the errors and try again.",'ProjectTheme');
                                echo '<br/>';
                                foreach($errors as $err)
                                echo $err.'<br/>';
                         ?>
                        </div>
                        </div>

                <?php endif; ?>


                <?php if($_GET['bid_posted'] == 1): ?>

                        <div class="bid_panel_ok">
                        <div class="padd10">
                        <?php _e("Your bid has been posted.",'ProjectTheme');

                         ?>
                        </div>
                        </div>

                <?php endif; ?>

<?php


				$ending     		= get_post_meta($PID_PID, "ending", true);



 ?>

               	<div class="bid_panel_front">
                <div class="padd10">

                <div class="small_buttons_div_left p-3">

									<div class="container" id="project-details-id">


							<div class="row">
								<div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri() ?>/images/wallet_icon2.png" width="18" height="18" alt="budget" /> <?php echo __("Project Budget",'ProjectTheme'); ?> </div>
								<div class="col-md-9 column-details-2"><?php echo ProjectTheme_get_budget_name_string_fromID(get_post_meta($PID_PID, 'budgets', true)); ?></div>
							</div>


													<div class="row">
															<div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri() ?>/images/coins_icon.png" width="18" height="18" alt="coins" />	<?php echo __("Average Bid",'ProjectTheme'); ?> </div>
															<div class="col-md-9 column-details-2"><?php echo ProjectTheme_average_bid($PID_PID); ?></div>
													</div>




									<?php

						$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
						if($ProjectTheme_enable_project_location == "yes"):

						?>
										<div class="row">
								<div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri(); ?>/images/loc_icon.png" width="18" height="18" alt="location" />
							 <?php echo __("Location",'ProjectTheme'); ?> </div>
								<div class="col-md-9 column-details-2"><?php echo get_the_term_list( $PID_PID, 'project_location', '', ', ', '' ); ?></div>
							</div>

												<?php endif; ?>


										<div class="row">
					 <div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri(); ?>/images/cate_icon.png" width="18" height="18" alt="category" />
						<?php echo __("Category",'ProjectTheme'); ?></div>
					 <div class="col-md-9 column-details-2"><?php echo get_the_term_list( $PID_PID, 'project_cat', '', ', ', '' ); ?></div>
				 </div>


			<div class="row">
			<div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri(); ?>/images/cate_icon.png" width="18" height="18" alt="category" />
			<?php echo __("Skills",'ProjectTheme'); ?></div>
			<div class="col-md-9 column-details-2"><?php echo strip_tags(get_the_term_list( $PID_PID, 'project_skill', '', ', ', '' )); ?></div>
			</div>


						<div class="row">
								<div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri(); ?>/images/cal_icon.png" width="18" height="18" alt="calendar" />
								<?php echo __("Posted on",'ProjectTheme'); ?>  </div>
								<div class="col-md-9 column-details-2"><?php echo get_the_time("jS F Y g:i A", $PID_PID); ?></div>
							</div>

											<div class="row">
								<div class="col-md-3 column-details-1"><img src="<?php echo get_template_directory_uri(); ?>/images/clock_icon.png" width="18" height="18" alt="clock" />
								 <?php echo __("Time Left",'ProjectTheme'); ?></div>
								<div class="col-md-9 column-details-2"><p class="expiration_project_p"><?php echo ($closed == "0" ?  ($ending - current_time('timestamp',0))
								: __("Expired/Closed",'ProjectTheme')); ?></div>
							</div>


										<div class="row">
														<div class="col-md-3 column-details-1">	<img src="<?php echo get_template_directory_uri() ?>/images/prop_icon.png" width="18" height="18" alt="proposals" />
							 <?php echo __("Proposals",'ProjectTheme'); ?></div>
								<div class="col-md-9 column-details-2"><?php echo projectTheme_number_of_bid($PID_PID); ?></div>
							</div>

						</div>


                    </div>
                    <!-- ########### -->



                </div>
                </div>


                <?php  else:
				// project closed
				?>

                <div class="bid_panel">
                <div class="padd10">

                	<?php

					$pid 	= $PID_PID;
					$winner = get_post_meta($PID_PID, 'winner', true);

					if(!empty($winner))
					{

						global $wpdb;
						$q = "select bid from ".$wpdb->prefix."project_bids where pid='$pid' and winner='1'";
						$r = $wpdb->get_results($q);
						$r = $r[0];

						_e("Project closed for price: ",'ProjectTheme');
						echo ProjectTheme_get_show_price($r->bid);

					}

					?>

                </div>
                </div>

                <?php endif; ?>



					</div>


			</div>


			<!-- ####################### -->

			<h3 class="my-account-headline-1"><?php echo __('Project Description','ProjectTheme'); ?> </h3>

			<div class="card">

                <div class="box_content" id="project-single-page-content">
					<?php echo $post_AU->post_content;

					do_action('ProjectTheme_after_description_in_single_proj_page');

					 ?>
				</div>
			</div>





            <!-- ####################### -->
			<?php

			$private_bids = get_post_meta($PID_PID, 'private_bids', true);

			?>


			<h3 class="my-account-headline-1"><?php echo __('Proposals','ProjectTheme'); ?> <?php

			if($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1) _e('[project has private proposals]','ProjectTheme');

			 ?></h3>

			<div class="card">



                <div class="box_content">
				<?php
				$ProjectTheme_enable_project_files = get_option('ProjectTheme_enable_project_files');
				$winner = get_post_meta($PID_PID, 'winner', true);
				$post = get_post($PID_PID);
				global $wpdb;
				$pid = $PID_PID;

				$bids = "select * from ".$wpdb->prefix."project_bids where pid='$pid' order by id DESC";
				$res  = $wpdb->get_results($bids);

				if($post_AU->post_author == $uid) $owner = 1; else $owner = 0;

				if(count($res) > 0)
				{

					if($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1)
					{
						if ($owner == 1) $show_stuff = 1;
						else if(projectTheme_current_user_has_bid($uid, $res)) $show_stuff = 1;
						else $show_stuff = 0;
					}
					else $show_stuff = 1;

					//------------

					if($show_stuff == 1):

						echo '<table id="my_bids" width="100%">';
						echo '<thead><tr>';
							echo '<th>'.__('Username','ProjectTheme').'</th>';
							echo '<th>'.__('Bid','ProjectTheme').'</th>';
							echo '<th>'.__('Date Made','ProjectTheme').'</th>';
							echo '<th>'.__('Days to Complete','ProjectTheme').'</th>';
							if ($owner == 1):
								if(empty($winner))
									echo '<th>'.__('Choose Winner','ProjectTheme').'</th>';

								if($ProjectTheme_enable_project_files != "no")
								echo '<th>'.__('Bid Files','ProjectTheme').'</th>';
							echo '<th>'.__('Messaging','ProjectTheme').'</th>';
							endif;

							if($closed == "1") echo '<th>'.__('Winner','ProjectTheme').'</th>';

						echo '</tr></thead><tbody>';

					endif;

					//-------------

					foreach($res as $row)
					{

						if ($owner == 1) $show_this_around = 1;
						else
						{
							if($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1)
							{
								if($uid == $row->uid) 	$show_this_around = 1;
								else $show_this_around = 0;
							}
							else
							$show_this_around = 1;

						}

						if($show_this_around == 1):

						$user = get_userdata($row->uid);
						echo '<tr>';
						echo '<th><a href="'.ProjectTheme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></th>';
						echo '<th>'.ProjectTheme_get_show_price($row->bid).'</th>';
						echo '<th>'.date("d-M-Y H:i:s", $row->date_made).'</th>';
						echo '<th>'. $row->days_done .'</th>';
						if ($owner == 1 ) {

							$nr = 7;
							if(empty($winner)) // == 0)
								echo '<th><a href="'.home_url().'/?p_action=choose_winner&pid='.$PID_PID.'&bid='.$row->id.'">'.__('Select','ProjectTheme').'</a></th>';

							if($ProjectTheme_enable_project_files != "no")
							{
								echo '<th>';

								if(projecttheme_see_if_project_files_bid($PID_PID, $row->uid) == true)
								echo '<a href="#" class="get_files" rel="'.$PID_PID.'_'.$row->uid.'">'.__('Bid Files','ProjectTheme').'</a>';
								else
								_e('None','ProjectTheme');

								echo '</th>';

							}
							echo '<th><a href="'.ProjectTheme_get_priv_mess_page_url('send', '', '&uid='.$row->uid.'&pid='.$PID_PID).'">'.__('Send Message','ProjectTheme').'</a></th>';
						}
						else $nr = 4;

						if($closed == "1") { if($row->winner == 1) echo '<th>'.__('Yes','ProjectTheme').'</th>'; else echo '<th>&nbsp;</th>'; }

						echo '</tr>';

						echo '<tr>';
						echo '<th colspan="'.$nr.'" class="my_td_with_border">'.$row->description.'</th>';
						echo '</tr>';
						endif;
					}

					echo '</tbody></table>';
				}
				else _e("No proposals placed yet.",'ProjectTheme');
				?>
				</div>
			</div>


            <?php

				$ProjectTheme_enable_images_in_projects = get_option('ProjectTheme_enable_images_in_projects');
				$ProjectTheme_enable_images_in_projects = apply_filters('ProjectTheme_enable_images_in_projects_hk', $ProjectTheme_enable_images_in_projects);

				if($ProjectTheme_enable_images_in_projects == "yes"):

			?>


			<!-- ####################### -->

			<h3 class="my-account-headline-1"><?php echo __('Image Gallery','ProjectTheme'); ?> </h3>
			<div class="card">


                <div class="box_content">
				<?php

				$arr = ProjectTheme_get_post_images($PID_PID);
				$xx_w = 600;
				$projectTheme_width_of_project_images = get_option('projectTheme_width_of_project_images');

				if(!empty($projectTheme_width_of_project_images)) $xx_w = $projectTheme_width_of_project_images;
				if(!is_numeric($xx_w)) $xx_w = 600;

				if($arr)
				{


				echo '<ul class="image-gallery">';
				foreach($arr as $image)
				{
					echo '<li><a href="'.ProjectTheme_generate_thumb($image, 900,$xx_w).'" rel="image_gal2"><img src="'.ProjectTheme_generate_thumb($image, 100,80).'" width="100" class="img_class" /></a></li>';
				}
				echo '</ul>';

				}
				else { echo __('No images.','ProjectTheme') ;}

				?>


				</div>
			</div>
			<?php endif;


			echo '<link media="screen" rel="stylesheet" href="'.get_template_directory_uri().'/css/colorbox.css" />';
			echo '<script src="'.get_template_directory_uri().'/js/jquery.colorbox.js"></script>';


	?>

			<script>

			var $ = jQuery;

				jQuery(document).ready(function(){

					jQuery("a[rel='image_gal1']").colorbox({maxWidth:'95%', maxHeight:'95%'});
					jQuery("a[rel='image_gal2']").colorbox({maxWidth:'95%', maxHeight:'95%'});


			});
			</script>


			<div class="clear10"></div>

			<!-- ####################### -->
			<?php

			$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
			if($ProjectTheme_enable_project_location == "yes"):

		?>



					<h3 class="my-account-headline-1"><?php echo __('Map Location','ProjectTheme'); ?> </h3>
			<div class="card">


                <div class="box_content">

				<div id="map" style="width: 100%; height: 300px;border:2px solid #ccc;float:left"></div>

                <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&key=<?php echo get_option('ProjectTheme_radius_maps_api_key') ?>"></script>

            <script type="text/javascript"
            src="<?php echo get_template_directory_uri(); ?>/js/mk.js"></script>
                                                <script type="text/javascript">




	  var geocoder;
  var map;
  function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 13,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map"), myOptions);
  }

  function codeAddress(address) {

    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new MarkerWithLabel({

            position: results[0].geometry.location,
			map: map,
       labelContent: address,
       labelAnchor: new google.maps.Point(22, 0),
       labelClass: "labels", // the CSS class for the label
       labelStyle: {opacity: 1.0}

        });
      } else {
        //alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }

initialize();

codeAddress("<?php

	global $post;
	$pid = $post_AU->ID;

	$terms = wp_get_post_terms($pid,'project_location');
	foreach($terms as $term)
	{
		echo $term->name." ";
	}

	$location = get_post_meta($pid, "Location", true);
	echo $location;

 ?>");

    </script>


			</div>
			</div> <?php endif; ?>

			<!-- ####################### -->





</div>


<div class="col col-sm-12 col-lg-4">

<?php

	echo '<div id="right-sidebar" class="page-sidebar">';
	echo '<ul class="sidebar-ul">';

	//---------------------
	// build the exclude list
	//---------------------
	// build the exclude list
		$exclude = array();

	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_mime_type' => 'image',
	'post_parent'    => $pid,
	'numberposts'    => -1,
	'post_status'    => null,
	);

	$attachments = get_posts($args);

	foreach($attachments as $att) $exclude[] = $att->ID;

	//-0------------------



	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'meta_key' => 'is_bidding_file',
	'meta_value' => '1',
	'post_parent'    => $pid,
	'numberposts'    => -1,
	'post_status'    => null,
	);

	$attachments = get_posts($args);

	foreach($attachments as $att) $exclude[] = $att->ID;

	//------------------

	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'exclude'    => $exclude,
	'numberposts'    => -1,
	'post_status'    => null,
	);
	$attachments = get_posts($args);



	?>


	<li class="widget-container widget_text" id="ad-other-details">
	<h3 class="widget-title text-center"><?php _e("Project Posted By",'ProjectTheme'); ?></h3>

		<div class="row">

				<div class=" col-md-12 text-center mt-4 "><img width="150" height="150" border="0" class="project-single-avatar rounded-circle" src="<?php echo ProjectTheme_get_avatar($post_AU->post_author, 160, 160); ?>" /> </div>


					<div class=" col-md-12 text-center mt-4 mb-3"><a class="avatar-posted-by-username" href="<?php echo home_url(); ?>/?p_action=user_profile&post_author=<?php echo $post_AU->post_author; ?>"><h5><?php echo $current_user->user_login; ?></h5></a></div>
					<div class=" col-md-12 text-center"><?php echo ProjectTheme_project_get_star_rating2($post_AU->post_author); ?></div>
					<div class=" col-md-12 text-center"><a href="<?php echo ProjectTheme_get_user_feedback_link($post_AU->post_author); ?>"><?php _e('View User Feedback','ProjectTheme'); ?></a></div>



		</div>

		<p>


						<?php

			$has_created 	= projectTheme_get_total_number_of_created_Projects($post_AU->post_author);
			$has_closed 	= projectTheme_get_total_number_of_closed_Projects($post_AU->post_author);
			$has_rated 		= projectTheme_get_total_number_of_rated_Projects($post_AU->post_author);

		?>


		<div class="d-flex  mb-0">
					<div class="mr-auto p-2"><i class="fas fa-folder"></i> <?php _e("Has created:",'ProjectTheme');?></div>
					<div class="p-2 "><?php echo sprintf(__("%s project(s)",'ProjectTheme'), $has_created); ?></div>
		</div>


		<div class="d-flex  mb-0">
					<div class="mr-auto p-2"><i class="far fa-window-close"></i> <?php _e("Has closed:",'ProjectTheme');?></div>
					<div class="p-2 "><?php echo sprintf(__("%s project(s)",'ProjectTheme'), $has_closed); ?></div>
		</div>


		<div class="d-flex  mb-0">
					<div class="mr-auto p-2"><i class="fas fa-certificate"></i> <?php _e("Has rated:",'ProjectTheme');?></div>
					<div class="p-2 "><?php echo sprintf(__("%s provider(s)",'ProjectTheme'), $has_rated); ?></div>
		</div>





					<br/><br/>
					 <a href="<?php echo home_url(); ?>/?p_action=user_profile&post_author=<?php echo $post_AU->post_author; ?>" class="btn btn-secondary btn-sm btn-block"><?php _e('See More Projects by this user','ProjectTheme'); ?></a><br/>



	</p>
	</li>



       <?php

						   	$ProjectTheme_enable_project_files = get_option('ProjectTheme_enable_project_files');
						   	if($ProjectTheme_enable_project_files != "no"):

						   ?>

     	<li class="widget-container widget_text" id="ad-other-details">
		<h3 class="widget-title"><?php _e("Project Files",'ProjectTheme'); ?></h3>
		<p>

        <ul class="other-dets other-dets2">
				<?php

				if(count($attachments) == 0) echo __('No project files.','ProjectTheme');

				foreach($attachments as $at)
				{



				?>

                <li> <a href="<?php echo wp_get_attachment_url($at->ID); ?>"><?php echo $at->post_title; ?></a>
				</li>
			<?php }   ?>
			</ul>
   		</p>
   </li>
  <?php endif; ?>


	<li class="widget-container widget_text" id="ad-other-details">
		<h3 class="widget-title"><?php _e("Other Options",'ProjectTheme'); ?></h3>
		<p>

        <div class="add-this">
						<!-- AddThis Button BEGIN -->
							<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
							<a class="addthis_button_preferred_1"></a>
							<a class="addthis_button_preferred_2"></a>
							<a class="addthis_button_preferred_3"></a>
							<a class="addthis_button_preferred_4"></a>
							<a class="addthis_button_compact"></a>
							<a class="addthis_counter addthis_bubble_style"></a>
							</div>
							<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4df68b4a2795dcd9"></script>
							<!-- AddThis Button END -->
						</div>

   		</p>
   </li>


	<li class="widget-container widget_text" id="ad-other-details">
		<h3 class="widget-title"><?php _e("Other Details",'ProjectTheme'); ?></h3>
		<p>
			<ul class="other-dets other-dets2">


				<?php

			$ProjectTheme_enable_project_location = get_option('ProjectTheme_enable_project_location');
			if($ProjectTheme_enable_project_location == "yes"):

		?>
				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/images/location.png" width="15" height="15" />
					<h3><?php _e("Address",'ProjectTheme');?>:</h3>
					<p><?php echo $location; ?></p>
				</li>


        <?php endif; ?>


                <?php

				$rt = get_option('projectTheme_show_project_views');

				if($rt != 'no'):
				?>

				<li>
					<img src="<?php echo get_template_directory_uri(); ?>/images/viewed.png" width="15" height="15" />
					<h3><?php _e("Viewed",'ProjectTheme');?>:</h3>
					<p><?php echo $views; ?> <?php _e("times",'ProjectTheme');?></p>
				</li>
				<?php endif; ?>


                <?php

				$my_arrms = true;
				$my_arrms = apply_filters('ProjectTheme_show_fields_in_sidebar', $my_arrms);

				if($my_arrms == true):

				$arrms = ProjectTheme_get_project_fields_values($PID_PID);

				if(count($arrms) > 0)
					for($i=0;$i<count($arrms);$i++)
					{

				?>
                <li>
					<h3><?php echo $arrms[$i]['field_name'];?>:</h3>
               	 	<p><?php echo $arrms[$i]['field_value'];?></p>
                </li>
				<?php } endif; ?>



			</ul>

		</p>
	</li>


	<?php

						dynamic_sidebar( 'project-widget-area' );
	echo '</ul>';
	echo '</div>';


//===============================================================================================
?>

</div></div>



<?php
}


if($new_Project_step == "4")
{
	$catid = ProjectTheme_get_project_primary_cat($pid);
	$ProjectTheme_get_images_cost_extra = ProjectTheme_get_images_cost_extra($pid);



	//--------------------------------------------------
	// hide project from search engines fee calculation

	$projectTheme_hide_project_fee = get_option('projectTheme_hide_project_fee');
	if(!empty($projectTheme_hide_project_fee))
	{
		$opt = get_post_meta($pid,'hide_project',true);
		if($opt == "0") $projectTheme_hide_project_fee = 0;


	} else $projectTheme_hide_project_fee = 0;


	//---------------------

	$made_me_date 	= get_post_meta($pid,'made_me_date',true);
	$tms 			= current_time('timestamp',0);
	$projectTheme_project_period = get_option('projectTheme_project_period');
	if(empty($projectTheme_project_period)) $projectTheme_project_period = 30;


	if(empty($made_me_date))
	{
		$ee = $tms + 3600*24*$projectTheme_project_period;
		update_post_meta($pid,'ending',$ee);
	}
	else
	{
		$ee = get_post_meta($pid, 'ending', true) + $tms - $made_me_date;
		update_post_meta($pid,'ending',$ee);
	}


	//-------------------------------------------------------------------------------
	// sealed bidding fee calculation

	$projectTheme_sealed_bidding_fee = get_option('projectTheme_sealed_bidding_fee');
	if(!empty($projectTheme_sealed_bidding_fee))
	{
		$opt = get_post_meta($pid,'private_bids',true);
		if($opt == "0") { $projectTheme_sealed_bidding_fee = 0; }


	} else $projectTheme_sealed_bidding_fee = 0;


	//-------

	$featured	 = get_post_meta($pid, 'featured', true);
	$feat_charge = get_option('projectTheme_featured_fee');

	if($featured != "1" ) $feat_charge = 0;




	$custom_set = get_option('projectTheme_enable_custom_posting');
	if($custom_set == 'yes')
	{
		$posting_fee = get_option('projectTheme_theme_custom_cat_'.$catid);
		if(empty($posting_fee)) $posting_fee = 0;
	}
	else
	{
		$posting_fee = get_option('projectTheme_base_fee');
	}

	$projectTheme_sealed_bidding_fee = empty($feat_charge) ? 0 : $projectTheme_sealed_bidding_fee;
	$projectTheme_hide_project_fee = empty($projectTheme_hide_project_fee) ? 0 : $projectTheme_hide_project_fee;
	$posting_fee = empty($posting_fee) ? 0 : $posting_fee;
	$feat_charge = empty($feat_charge) ? 0 : $feat_charge;
	$ProjectTheme_get_images_cost_extra = empty($ProjectTheme_get_images_cost_extra) ? 0 : $ProjectTheme_get_images_cost_extra;

	$total = $feat_charge + $posting_fee + $projectTheme_sealed_bidding_fee + $projectTheme_hide_project_fee + $ProjectTheme_get_images_cost_extra;

	//-----------------------------------------------

		$payment_arr = array();

		$base_fee_paid 	= get_post_meta($pid, 'base_fee_paid', true);

		if($base_fee_paid != "1" and $posting_fee > 0)
		{
			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'base_fee';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $posting_fee;
			$my_small_arr['description'] 	= __('Base Fee','ProjectTheme');
			array_push($payment_arr, $my_small_arr);
		}
		//-----------------------


		$my_small_arr = array();
		$my_small_arr['fee_code'] 		= 'extra_img';
		$my_small_arr['show_me'] 		= true;
		$my_small_arr['amount'] 		= $ProjectTheme_get_images_cost_extra;
		$my_small_arr['description'] 	= __('Extra Images Fee','ProjectTheme');
		array_push($payment_arr, $my_small_arr);
		//------------------------

		$featured_paid  	= get_post_meta($pid,'featured_paid',true);
		$opt 				= get_post_meta($pid,'featured',true);


		if($feat_charge > 0 and $featured_paid != 1 and $opt == 1)
		{
			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'feat_fee';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $feat_charge;
			$my_small_arr['description'] 	= __('Featured Fee','ProjectTheme');
			array_push($payment_arr, $my_small_arr);
			//------------------------
		}

		$private_bids_paid  = get_post_meta($pid,'private_bids_paid',true);
		$opt 				= get_post_meta($pid,'private_bids',true);


		if($projectTheme_sealed_bidding_fee > 0 and $private_bids_paid != 1  and ($opt == 1 or $opt == "yes"))
		{

			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'sealed_project';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $projectTheme_sealed_bidding_fee;
			$my_small_arr['description'] 	= __('Sealed Bidding Fee','ProjectTheme');
			array_push($payment_arr, $my_small_arr);
		//------------------------
		}

		$hide_project_paid 	= get_post_meta($pid,'hide_project_paid',true);
		$opt 				= get_post_meta($pid,'hide_project',true);

		if($projectTheme_hide_project_fee > 0 and $hide_project_paid != "1" and ($opt == "1" or $opt == "yes"))
		{

			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'hide_project';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $projectTheme_hide_project_fee;
			$my_small_arr['description'] 	= __('Hide Project From Search Engines Fee','ProjectTheme');
			array_push($payment_arr, $my_small_arr);

		}

		$payment_arr 	= apply_filters('ProjectTheme_filter_payment_array', $payment_arr, $pid);
		$new_total 		= 0;

		foreach($payment_arr as $payment_item):
			if($payment_item['amount'] > 0):
				$new_total += $payment_item['amount'];
			endif;
		endforeach;

	//-----------------------------------------------

	$post 			= get_post($pid);
	$admin_email 	= get_option('admin_email');


	$total = apply_filters('ProjectTheme_filter_payment_total', $new_total, $pid);

	//----------------------------------------
	$finalize = isset($_GET['finalize']) ? true : false;
	update_post_meta($pid, 'finalised_posted', '1');

	//-----------

	if($total == 0)
	{
			echo '<div  class="p-3" >';
			echo __('Thank you for posting your project with us.','ProjectTheme');
			update_post_meta($pid, "paid", "1");



				if(get_option('projectTheme_admin_approves_each_project') == 'yes')
				{
					$my_post = array();
					$my_post['ID'] = $pid;
					$my_post['post_status'] = 'draft';

					wp_update_post( $my_post );

					if($finalize == true){
						ProjectTheme_send_email_posted_project_not_approved($pid);
						ProjectTheme_send_email_posted_project_not_approved_admin($pid);
					}

					echo '<br/>'.__('Your project isn`t live yet, the admin needs to approve it.', 'ProjectTheme');

				}
				else
				{
					$my_post = array();
					$my_post['ID'] = $pid;
					$my_post['post_status'] = 'publish';

					if($finalize == true){

						wp_update_post( $my_post );
						wp_publish_post( $pid );


						ProjectTheme_send_email_posted_project_approved($pid);
						ProjectTheme_send_email_posted_project_approved_admin($pid);

						ProjectTheme_send_email_subscription($pid);

					}
				}

			echo '</div>';


	}
	else
	{
			update_post_meta($pid, "paid", "0");

			echo '<div class="p-3" >';
			echo __('Thank you for posting your project with us. Below is the total price that you need to pay in order to put your project live.<br/>
			Click the pay button and you will be redirected...', 'ProjectTheme');
			echo '</div>';


	}

	//----------------------------------------

	echo '<div class="p-3"><table class="table ">';

	$show_payment_table = true;
	$show_payment_table = apply_filters('ProjectTheme_filter_payment_show_table', $show_payment_table, $pid);

	if($show_payment_table == true and $total > 0)
	{


		foreach($payment_arr as $payment_item):

			if($payment_item['amount'] > 0):

				echo '<tr>';
				echo '<td>'.$payment_item['description'].'&nbsp; &nbsp;</td>';
				echo '<td>'.ProjectTheme_get_show_price($payment_item['amount'],2).'</td>';
				echo '</tr>';

			endif;

		endforeach;




		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td></td>';
		echo '</tr>';


		echo '<tr>';
		echo '<td><strong>'.__('Total to Pay','ProjectTheme').'</strong></td>';
		echo '<td><strong>'.ProjectTheme_get_show_price($total,2).'</strong></td>';
		echo '</tr>';

		$ProjectTheme_enable_credits_wallet = get_option('ProjectTheme_enable_credits_wallet');
		if($ProjectTheme_enable_credits_wallet != 'no'):

			echo '<tr>';
			echo '<td><strong>'.__('Your Total Credits','ProjectTheme').'</strong></td>';
			echo '<td><strong>'.ProjectTheme_get_show_price(ProjectTheme_get_credits($uid),2).'</strong></td>';
			echo '</tr>';

		endif;

		echo '<tr>';
		echo '<td>&nbsp;<br/>&nbsp;</td>';
		echo '<td></td>';
		echo '</tr>';

	}//endif show this table

	if($total == 0 && $finalize == true)
	{
		if(get_option('projectTheme_admin_approves_each_project') != 'yes'):

			echo '<tr>';

			echo '<td  colspan="2"><div class="clear100"></div><a href="'.get_permalink($pid).'" class="btn btn-primary">'.__('See your project','ProjectTheme') .'</a></td>';
			echo '</tr>';

		else:

			echo '<tr>';

			echo '<td colspan="2"><a href="'.get_permalink(get_option('ProjectTheme_my_account_page_id')).'" class="btn btn-primary">'.__('Go to your account','ProjectTheme') .'</a></td>';
			echo '</tr>';

		endif;

		echo '</table></div>';
	}
	elseif($total > 0)
	{
			echo '</table></div>';
		update_post_meta($pid,'unpaid','1');


		echo '<div class="p-3">';


						$ProjectTheme_enable_credits_wallet = get_option('ProjectTheme_enable_credits_wallet');
						if($ProjectTheme_enable_credits_wallet != 'no'):
							echo '<a href="'.home_url().'/?p_action=credits_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by Credits','ProjectTheme').'</a> ';
						endif;

						global $project_ID;
						$project_ID = $pid;

						//-------------------

						$ProjectTheme_paypal_enable 		= get_option('ProjectTheme_paypal_enable');
						$ProjectTheme_alertpay_enable 		= get_option('ProjectTheme_alertpay_enable');
						$ProjectTheme_moneybookers_enable 	= get_option('ProjectTheme_moneybookers_enable');


						if($ProjectTheme_paypal_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=paypal_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by PayPal','ProjectTheme').'</a> ';

						if($ProjectTheme_moneybookers_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=mb_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by MoneyBookers/Skrill','ProjectTheme').'</a> ';

						if($ProjectTheme_alertpay_enable == "yes")
							echo '<a href="'.home_url().'/?p_action=payza_listing&pid='.$pid.'" class="btn btn-secondary">'.__('Pay by Payza','ProjectTheme').'</a> ';

						do_action('ProjectTheme_add_payment_options_to_post_new_project', $pid);

						echo '</div>';

	} else  { echo '</table></div>'; }



	echo '<div class="p-3">';
	if($finalize == false)
	echo ' <a href="'. ProjectTheme_post_new_with_pid_stuff_thg($pid, '3') .'" class="btn btn-primary" role="button" >'.__('Go Back','ProjectTheme').'</a>';

	if($total == 0 && $finalize == false)
	echo ' <a href="'. ProjectTheme_post_new_with_pid_stuff_thg($pid, '4', 'finalize').'"
	class="btn btn-primary" role="button" >'.__('Finalize Project Posting','ProjectTheme').'</a>';

	echo '</div>';

}


 ?>

            <?php endif; ?>


              </div>
           </div>

        </div> <!-- end dif content -->




<?php
}


?>
