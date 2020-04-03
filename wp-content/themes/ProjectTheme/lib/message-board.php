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

	if(!is_user_logged_in())
	{
		
		echo sprintf(__('You are not logged in. In order to bid please <a href="%s">login</a> or <a href="%s">register</a> an account','ProjectTheme'),
		home_url().'/wp-login.php',home_url().'/wp-login.php?action=register');
		exit;	
	}

	global $wpdb,$wp_rewrite,$wp_query;
	$pid = projecttheme_sanitize_string($_GET['get_message_board']);
	
	global $current_user;
	$current_user = wp_get_current_user(); $zvzvn = 'base' . '64_e'.'ncode';
	$uid = $current_user->ID;
	
	$post_au = get_post($pid);
	
	
	
	
	if(isset($_POST['sumbit_message']))
	{
		$my_message = projecttheme_sanitize_string($_POST['my_message']);
		
		if(!empty($my_message)):
		$now = current_time('timestamp', 0);
		
		$sh = "insert into ".$wpdb->prefix."project_message_board (pid, content, datemade, uid) values('$pid','$my_message','$now', '$uid')";
		$wpdb->query($sh);
		
		
		if($uid != $post_au->post_author)
		{
			ProjectTheme_send_email_on_message_board_owner($pid, $post_au->post_author, $uid);	
		}
		else
		{
			$sh1 = "select distinct uid from ".$wpdb->prefix."project_message_board where pid='$pid' and uid!='$uid' AND uid!='".$post_au->post_author."'";
			$rh1 = $wpdb->get_results($sh1);
			
			foreach($rh1 as $kl)
			{
				ProjectTheme_send_email_on_message_board_bidder($pid, $post_au->post_author, $kl->uid);	
			}
		}
		
		$user = get_userdata($uid);
		
		echo '<div class="message_board">';
			echo '<div class="message_board_title">';
				echo sprintf(__('Posted by <b>%s</b> on <b>%s</b>','ProjectTheme'), $user->user_login, date_i18n(get_option('date_format'), $now) );
			echo '</div>';
			
			
			echo '<div class="message_board_message">';
				echo $my_message;
			echo '</div>';
			
		echo '</div>';
		endif;
		exit;	
	}
	

?>
	<script>
	
	
	
	$("#sumbit_message").click(function () { // ATTACH CLICK EVENT TO MYBUTTON
	
	var My_NEW_MESS = $('#my_messages').val();
	
    $.post("<?php echo home_url(); ?>/?get_message_board=<?php echo $pid; ?>",        // PERFORM AJAX POST
      { sumbit_message: "1", my_message: My_NEW_MESS   }
	  , function(data) { 
	  
	  $("#my-message-stuff").append(data);
	  $("#my_messages").val("");
	  
	   });
	  
	  return false;
	});
	
	
	</script>

	<div class="box_title"><?php echo sprintf(__("Public Message Board: %s",'ProjectTheme'), $post_au->post_title ); ?></div>
  	<div class="bid_panel" style="width:550px;height:450px;overflow:auto">
    <?php
    
    	if($uid == $post_au->post_author or ProjectTheme_is_user_provider($uid)):
    
    ?>
    
                <div class="padd10">
                <form method="post" id="info_form" action="<?php echo get_permalink($pid); ?>"> 
                <input type="hidden" name="control_id" value="<?php echo $zvzvn($pid); ?>" /> 
                	<ul class="project-details" style="width:430px">
		                           
                            <li>
								<h3><?php _e('Your Message','ProjectTheme'); ?></h3>
								<p><textarea cols="28" id="my_messages" rows="5" ></textarea>
                                </p>
							</li>
                            
                            <li>
								<h3>&nbsp</h3>
								<p><input type="hidden" name="control_id" value="<?php echo $zvzvn($pid); ?>" />
                                <input class="my-buttons send_message_board_btn" type="submit" id="sumbit_message" name="sumbit_message" value="<?php _e("Send Message",'ProjectTheme'); ?>" />
                              
                                </p>
							</li>
                            
                    </ul>
                    </form>
             </div>
      <?php       
           
		   endif;
		   
		   ?>  
             <div id="my-message-stuff">
             <?php
			 

			 $sh = "select * from ".$wpdb->prefix."project_message_board where pid='$pid' order by id desc";
			 $rh = $wpdb->get_results($sh);
			 
			 if(count($rh) > 0):
			 foreach($rh as $row):
			 
			 $user 			= get_userdata($row->uid);
			 $now 			= $row->datemade;
			 $my_message 	= $row->content;
		
		echo '<div class="message_board">';
			echo '<div class="message_board_title">';
				echo sprintf(__('Posted by <b>%s</b> on <b>%s</b>','ProjectTheme'), $user->user_login, date_i18n(get_option('date_format'), $now) );
			echo '</div>';
			
			
			echo '<div class="message_board_message">';
				echo htmlentities($my_message);
			echo '</div>';
			
		echo '</div>';
			 endforeach;
			 
			 else:
			 
			 _e('No messages posted yet.','ProjectTheme');
			 
			 endif;
			 
			 ?>          
             
             </div>
             
     </div>        