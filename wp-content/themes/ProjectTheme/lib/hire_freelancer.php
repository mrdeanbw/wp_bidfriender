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


	//----------

	global $wpdb,$wp_rewrite,$wp_query;

//---------------------------------

	global $current_user;
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;




//==========================

get_header();

$author_info = get_userdata($_GET['uid']);
$usr = $author_info->first_name. ' '. $author_info->last_name;
if(empty($usr)) $usr = $author_info->user_login;

$author_to_hire = $_GET['uid'];

?>

<div class="page_heading_me pt_template_page_1" id="pt_template_page_1">
	<div class="page_heading_me_inner">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="x_templ_1_pt">
    	<div class="mm_inn"><?php

						   echo sprintf(__("Hire this freelancer - %s",'ProjectTheme'), $usr);

					 ?>
                     </div>


 	</div>




    </div>
</div>




<div class="container mt-4">
		<div id="main" class="wrapper">

			<div class="my_box3">
            	<div class="padd10">

                <div class="box_content">



                  <?php

                  if(isset($_POST['submit']))
                  {

										echo sprintf(__('Your request has been sent. <a href="%s"><b>Click here</b></a> to get back to account area, or <a href="%s"><b>click here</b></a> to get back to search freelancers page.','ProjectTheme'), get_permalink(get_option('ProjectTheme_my_account_page_id')),
	                  get_permalink(get_option('ProjectTheme_provider_search_page_id')));

																												$budget = $_POST['budget'];
																												$project_description = $_POST['project_description'];
																												$subject = sprintf(__('You have a hire request from: %s', 'ProjectTheme'), $current_user->user_login);

																												$message = 'Hello ' . $author_info->user_login.'<br/><br/>You have a new hire request. The message of the user was: <br/><br/>Project Description: ' . $project_description.'
																												<br/>Project Budget: ' . projectTheme_get_show_price($budget) ;


																												//*********************************************



																												global $wpdb;
																												$tm = projecttheme_sanitize_string($_POST['tm']); //current_time('timestamp',0);
																												$myuid = get_current_user_id();

																												$sr = "select * from ".$wpdb->prefix."project_pm where initiator='$myuid' and user='$author_to_hire' and datemade='$tm'";
																												$rr = $wpdb->get_results($sr);


																												if(count($rr) == 0)
																												{


																													$thid 								= pt_create_thread_id_message($myuid, $author_to_hire, $tm, $subject);
																													$show_to_destination 	= pt_check_moderate_private_messages();

																													$s = "insert into ".$wpdb->prefix."project_pm
																													(approved, subject, content, datemade, pid, initiator, user, file_attached, show_to_destination, parent, threadid)
																													values('$approved','$subject','$message','$tm','0','$myuid','$author_to_hire', '$attach_id', '$show_to_destination','$parent', '$thid')";

																													$wpdb->query($s);

																													if($ProjectTheme_moderate_private_messages == false)
																														ProjectTheme_send_email_on_priv_mess_received($myuid, $uids);
																													else
																													{
																														//send message to admin to moderate

																													}


																												}

																												//--------------




                  }
                  else {



                   ?>


                <div class="clear10"></div>

               <form method="post" >

                 <div class="my_row_m1">
                       <div class="full_width_m1"><?php _e('Write something about your custom project:','ProjectTheme'); ?></div>
                       <div class="full_width_m1">
                             <textarea class="form-control" name="project_description" style="height:160px;" placeholder="<?php _e('Here you can write your project description for the freelancer to see...','ProjectTheme'); ?>"></textarea>
                       </div>
                 </div>


                 <div class="my_row_m1">
                       <div class="full_width_m1"><?php _e('Your project budget:','ProjectTheme'); ?></div>
                       <div class="full_width_m1">
                             <input type="text" required  class="form-control" value="<?php echo $_POST['budget']; ?>" placeholder="<?php echo projectTheme_get_currency() ?>" name="budget" />
                       </div>
                 </div>


<div class="my_row_m1">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit" />
								<input type="hidden"  value="<?php echo current_time('timestamp') ?>" name="tm" />
   </div>

 </form> <?php } ?>
    </div>
			</div>
			</div>
        </div>  </div>


        <div class="clear100"></div>


<?php

get_footer();

?>
