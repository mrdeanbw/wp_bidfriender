

<div class="modal fade" id="bidding-panel-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelc" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelc"><?php _e('Post your proposal','ProjectTheme') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">







<?php

	if(!is_user_logged_in())
	{
		echo '<div class="padd10"><div class="padd10">';
		echo sprintf(__('You are not logged in. In order to bid please <a href="%s">login</a> or <a href="%s">register</a> an account','ProjectTheme'),
		home_url().'/wp-login.php',home_url().'/wp-login.php?action=register');
		echo '</div></div>';

		?>


	</div>

			<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e("Close",'ProjectTheme'); ?></button>
			</div>

			<!-- ##### -->

			</div>
			</div>
			</div>


		<?php


	}
  else {




	 $zvzvn = 'base' . '64_e'.'ncode';
	 global $myown_project_bid;


	global $wpdb,$wp_rewrite,$wp_query;
	$pid = $myown_project_bid;

	global $current_user;
	$current_user = wp_get_current_user();
	$cid = $current_user->ID;
	$cwd = str_replace('wp-admin','',getcwd());
	$post = get_post($pid);

	//---------

	if($post->post_author == $cid)
	{
		echo '<div class="padd10"><div class="padd10">';
		echo sprintf(__('You cannot submit proposals to your own projects.','ProjectTheme'));
		echo '</div></div>';
		exit;
	}

	//----------------------

	$cwd .= 'wp-content/uploads';



	$query = "select * from ".$wpdb->prefix."project_bids where uid='$cid' AND pid='$pid'";
	$r = $wpdb->get_results($query); $bd_plc = 0;

	if(count($r) > 0) { $row = $r[0]; $bid = $row->bid; $description = $row->description; $days_done = $row->days_done; $bd_plc = 1; }

	do_action('ProjectTheme_display_bidding_panel', $pid);

  //ProjectTheme_can_post_bids_anymore

	//====================================================================


	$is_it_allowed = true;
	$is_it_allowed = apply_filters('ProjectTheme_is_allowed_to_place_bids', $is_it_allowed);

  if(function_exists('ProjectTheme_can_post_bids_anymore'))
  {
    $val = ProjectTheme_can_post_bids_anymore();
    if($val == "no") $is_it_allowed = false;
  }

	if($is_it_allowed == false):

	   //do_action('ProjectTheme_is_it_not_allowed_place_bids_action');
?>



<?php else: ?>


<script type="text/javascript">

function check_submits()
{
	if(!jQuery('#submits_crt_check').is(':checked'))
	{
		alert("<?php _e('Please accept you can do the work.','ProjectTheme'); ?>");
		return false;
	}

	if( jQuery("#days_done").val().length == 0 )
	{
		alert("<?php _e('Please type in the number of days.','ProjectTheme'); ?>");
		return false;
	}

	if( jQuery("#bid").val().length == 0 )
	{
		alert("<?php _e('Please type in a bid value.','ProjectTheme'); ?>");
		return false;
	}


	return true;
}


</script>

<div class=" ">

  	<div class="bid_panel" >
    <?php

	$do_not_show = 0;
	$uid = $cid;

	$projectTheme_enable_custom_bidding = get_option('projectTheme_enable_custom_bidding');
	if($projectTheme_enable_custom_bidding == "yes")
	{
		$ProjectTheme_get_project_primary_cat = ProjectTheme_get_project_primary_cat($pid);
		$projectTheme_theme_bidding_cat_ = get_option('projectTheme_theme_bidding_cat_' . $ProjectTheme_get_project_primary_cat);

		if($projectTheme_theme_bidding_cat_ > 0)
		{
			$ProjectTheme_get_credits = ProjectTheme_get_credits($uid);

			if(	$ProjectTheme_get_credits < $projectTheme_theme_bidding_cat_) { $do_not_show = 1;
				$prc = projecttheme_get_show_price($projectTheme_theme_bidding_cat_);
			}
		}

	}

	if($do_not_show == 1 and $bd_plc != 1)
	{
		echo '<div class="padd10">';
		echo sprintf(__('You need to have at least %s in your account to bid. <a href="%s">Click here</a> to deposit money.','ProjectTheme'), $prc, get_permalink(get_option('ProjectTheme_my_account_payments_id')));
		echo '</div>';
	}
	else
	{
		?>

                <div class="padd10">
                <form onsubmit="return check_submits();" method="post" action="<?php echo get_permalink($pid); ?>">
                <input type="hidden" name="control_id" value="<?php

					global $projecttheme_en_k;
					$cryptor = new ProjectTheme_cryptor($projecttheme_en_k);
					$crypted_token = $cryptor->encrypt($pid);

					echo $crypted_token;


					?>" />

					<script>

					function isNumber(evt) {
					    evt = (evt) ? evt : window.event;
					    var charCode = (evt.which) ? evt.which : evt.keyCode;

              if (charCode == 44) return true;
              if (charCode == 46) return true;

					    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
					        return false;
					    }
					    return true;
					}

					</script>
                	<div class="row">

                            <div class="col-md-12">
								<div class="form-group">

                <label class="form-label">  <?php _e('Your Bid','ProjectTheme'); ?></label>



               <div class="input-group mb-3">
                 <div class="input-group-prepend">
                   <span class="input-group-text" id="basic-addon1"><?php

   $currency = projectTheme_currency();
   $currency = apply_filters('ProjectTheme_currency_in_bidding_panel', $currency);

   echo $currency; ?></span>
                 </div>

                  <input type="text" name="bid" id="bid" class="form-control" value="<?php echo $bid; ?>" size="10" onkeypress="return isNumber(event)" />
               </div>




							</div></div>

              <div class="col-md-12">
                  <div class="form-group">
								<label class="form-label"><?php _e('Days to Complete','ProjectTheme'); ?></label>
								 <input type="text" name="days_done" id="days_done" class="form-control" value="<?php echo $days_done; ?>" size="10" onkeypress="return isNumber(event)" />


							</div></div>
                           <?php

						   	$ProjectTheme_enable_project_files = get_option('ProjectTheme_enable_project_files');

						   	if($ProjectTheme_enable_project_files != "no"):

						   ?>

               <div class="col-md-12">
   <div class="form-group">
								<label class="form-label"><?php _e('Attach Files','ProjectTheme'); ?></label>

                                <!-- ################### -->

         <div class="cross_cross2">



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
	url: "<?php echo home_url() ?>/?my_upload_of_project_files=1",
};

var myDropzone = new Dropzone('div#myDropzoneElement', myDropzoneOptions);

myDropzone.on("sending", function(file, xhr, formData) {
  formData.append("authora", "<?php echo $cid; ?>"); // Will send the filesize along with the file as POST data.
  formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
});


    <?php

	if(empty($cid)) $cid = -1;

	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
		'post_author'    => $cid,
	'meta_key'		 => 'is_bidding_file',
	'meta_value'	 => '1',
	'numberposts'    => -1,
	'post_status'    => null,
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
 			if($attachment->post_author == $cid)
			{

			?>

					var mockFile = { name: "<?php echo $attachment->post_title ?>", size: 12345, serverId: '<?php echo $attachment->ID ?>' };
					myDropzone.options.addedfile.call(myDropzone, mockFile);
					myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo get_template_directory_uri() ?>/images/file_icon.png");


			<?php
			}

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
						url : '<?php echo home_url();?>/?_ad_delete_pid='+id,
						dataType : 'text',
						success: function (text) {   jQuery('#image_ss'+id).remove();  }
					 });
		  //alert("a");

	}





	</script>

	<?php _e('Click the grey area below to add project files. Images are not accepted.','ProjectTheme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement" ></div>


	</div>





                                <!-- ################### -->

							</div></div>
                            <?php endif; ?>

                            <div class="col-md-12">
                <div class="form-group">
							<label class="form-label"><?php _e('Description','ProjectTheme'); ?></label>


                                	<textarea name="description2" cols="28" class="form-control" rows="3"><?php echo $description; ?></textarea>


							</div></div>


              <div class="col-md-12">
  <div class="form-group">




                                <input type="checkbox" name="accept_trms" id="submits_crt_check" value="1" /> <?php _e("I can perform work where/when described in post.",'ProjectTheme'); ?>
								</div></div>



            </div>

                </div> <?php } ?>
                </div> </div> <?php endif; ?>


								<!-- ##### -->
								      </div>

								<div class="modal-footer"> <input type="hidden" value="1" name="bid_now_reverse" />
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php _e("Close",'ProjectTheme'); ?></button>
									<button type="submit" class="btn btn-primary"><?php _e("Place Bid",'ProjectTheme'); ?></button>
								</div>

								</form>

<!-- ##### -->

    </div>
							</div>
            </div> <?php } ?>
