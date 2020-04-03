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

add_action('template_redirect', 'projectTheme_close_projects_cron',1); //wp_init - here


function projectTheme_close_projects_cron()
{
	global $wpdb;
		$closed = array(
			'key' => 'closed',
			'value' => "0",
			'compare' => '='
		);
		
		
		$ending = array(
			'key' => 'ending',
			'value' => current_time('timestamp',0),
			'type' => 'numeric',
			'compare' => '<'
		);
		
		
	$args2 = array( 'posts_per_page' =>'-1', 'post_type' => 'project', 'post_status' => 'publish', 'meta_query' => array($closed, $ending));
	$the_query = new WP_Query( $args2 );
	
	
		if($the_query->have_posts()):
		while ( $the_query->have_posts() ) : $the_query->the_post();
			
			update_post_meta(get_the_ID(), 'closed',"1");
			update_post_meta(get_the_ID(), 'closed_date',current_time('timestamp',0));
			$pid = get_the_ID();
			
			$post = get_post($pid);
		
		

			// just close the project and email to users maybe...				
			$s = "select distinct uid from ".$wpdb->prefix."project_bids where pid='$pid'";
			$r = $wpdb->get_results($s);
			
				foreach($r as $row)
				{
					$uid = $row->uid;	
					
					$subject 	= "Project closed: ".$post->post_title;
					$message 	= "The project <a href='".get_permalink($pid)."'>".$post->post_title."</a> was just closed. A winner hasnt been chosen yet.";
					$user 		= get_userdata($uid);
					$email  	= $user->user_email;
					
					//sitemile_send_email($email, $subject, $message);
					
					
				}
				
				//--- email to the owner as well ---
					
					$subject 	= "Your project was closed: ".$post->post_title;
					$message 	= "The project <a href='".get_permalink($pid)."'>".$post->post_title."</a> was just closed. Please choose a winner.";
					$user 		= get_userdata($post->post_author);
					$email  	= $user->user_email;
					
					//sitemile_send_email($email, $subject, $message);
				
				//-------
				
		
		
		
		endwhile;
		endif;
	
}


?>