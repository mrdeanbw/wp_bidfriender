<?php

add_action('widgets_init', 'register_best_rated_users_widget');
function register_best_rated_users_widget() {
	register_widget('ProjectTheme_best_rated_users');
}

class ProjectTheme_best_rated_users extends WP_Widget {

	function ProjectTheme_best_rated_users() {
		$widget_ops = array( 'classname' => 'best-rated-users', 'description' => 'Show the best rated users.' );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'best-rated-users' );
		parent::__construct( 'best-rated-users', 'ProjectTheme - Best Rated Users', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		
		echo $before_widget;
		
		if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		
		$user_limit = $instance['user_limit'];
		$user_tp 	= $instance['user_tp'];
		global $wpdb;
		
		if($user_tp == "both") { $inr = ''; $whr = ''; }
		
		if($user_tp == "service_provider") { $inr = "INNER JOIN $wpdb->usermeta m ON m.user_id = users.ID "; 
		$whr = "m.meta_key = 'wp_capabilities' AND m.meta_value LIKE '%service_provider%' AND"; }
		
		if($user_tp == "service_contractor") { $inr = "INNER JOIN $wpdb->usermeta m ON m.user_id = users.ID "; 
		$whr = "m.meta_key = 'wp_capabilities' AND m.meta_value LIKE '%business_owner%' AND"; }
		
		
		
		//$widget_id = $args['widget_id'];
		
		if(empty($user_limit)) $user_limit = 5;
		
		
		
			 $querystr = "
					SELECT users.user_email email,users.ID UID, users.user_registered dt, users.user_login username, ratings.touser uid, 
					AVG(ratings.grade) rate FROM ".$wpdb->prefix."project_ratings ratings, $wpdb->users users 
					".$inr." where ".$whr."				
					users.ID=ratings.touser 
					group by ratings.touser order by rate DESC LIMIT $user_limit";
				
				$r = $wpdb->get_results($querystr);
				 
				if(count($r) == 0) echo __('No rated users yet.','ProjectTheme'); 
				else
				{
					echo '<table width="100%">';
					foreach($r as $row) // = mysql_fetch_object($r))
					{
						$hash = md5( strtolower( trim($row->email)));
						$dt = date_i18n("jS \of F, Y",strtotime($row->dt));
						
						echo '<tr>';
						
						echo '<td width="20%"><a href="'.ProjectTheme_get_user_profile_link($row->UID).'"><img class="image_class"
						src="'.ProjectTheme_get_avatar($row->UID,40,40).'" width="40" /></a></td>';
						echo '<td><b><a href="'.ProjectTheme_get_user_profile_link($row->UID).'">'.$row->username.'</a></b><br/>
						 '.sprintf(__('Joined on: %s','ProjectTheme'), $dt).'
						<br/>'.ProjectTheme_get_project_stars(floor($row->rate/2)).'
						</td>';
						
						echo '</tr>';
					}
					echo '</table>';
				}
		
		
				
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	
		return $new_instance;
	}

	function form($instance) { ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','ProjectTheme'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" 
			value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
		</p>
        <?php
		
		$usrtp = esc_attr( $instance['user_tp'] );
		if(empty($usrtp)) $usrtp = 'both';
		
		?>
		
        <p>
			<label for="<?php echo $this->get_field_id('user_tp'); ?>"><?php _e('User Type','ProjectTheme'); ?>:</label><br/>
			<input type="radio"  value="both" name="<?php echo $this->get_field_name('user_tp'); ?>" 
			 <?php if( $usrtp == 'both') echo 'checked="checked"'; ?> /> Both<br/>
             
             <input type="radio"  value="service_provider" name="<?php echo $this->get_field_name('user_tp'); ?>" 
			 <?php if( $usrtp == 'service_provider') echo 'checked="checked"'; ?> /> Service Provider<br/>
             
              <input type="radio"  value="service_contractor" name="<?php echo $this->get_field_name('user_tp'); ?>" 
			 <?php if( $usrtp == 'service_contractor') echo 'checked="checked"'; ?> /> Service Contractor<br/>
		</p>
        
        
      
        
		<p>
			<label for="<?php echo $this->get_field_id('user_limit'); ?>"><?php _e('Users Limit','ProjectTheme'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('user_limit'); ?>" name="<?php echo $this->get_field_name('user_limit'); ?>" 
			value="<?php echo esc_attr( $instance['user_limit'] ); ?>" style="width:20%;" />
		</p>
					
	<?php 
	}
}



?>