<?php

// Register and load the widget
function pt_main_page_latest_freelancers_widget() {
    register_widget( 'pt_main_page_latest_freelancers_big_class' );
}
add_action( 'widgets_init', 'pt_main_page_latest_freelancers_widget' );

// Creating the widget
class pt_main_page_latest_freelancers_big_class extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'pt_main_page_latest_freelancers_big_class',

// Widget name will appear in UI
__('ProjectTheme - Latest Freelancers', 'ProjectTheme'),

// Widget description
array( 'description' => __( 'Shows a list of freelancers for homepage.', 'ProjectTheme' ), )
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );


$show_skills = $instance['show_skills'];

// before and after widget arguments are defined by themes
echo $args['before_widget'];


		if ($instance['title']) echo '<h5>' . apply_filters('widget_title', $instance['title']) . '</h5>';
		$limit = $instance['show_freelancers_limit'];

		if(empty($limit) || !is_numeric($limit)) $limit = 5;


			$ProjectTheme_enable_2_user_tp = get_option('ProjectTheme_enable_2_user_tp');


			// prepare arguments
			$args['orderby']  = 'display_name';
			$arr_aray = array();



			if($ProjectTheme_enable_2_user_tp == "yes" and $rf_demo)
			{
				$arr_sbg = 	array(
						// uses compare like WP_Query
						'key' => 'user_tp',
						'value' => 'service_provider',
						'compare' => '='
						);

				array_push(	$arr_aray, 	$arr_sbg);

			}

			//-----------------------------------------------
			$offset = 0;

			$args['meta_query']  	= $arr_aray;
			$args['number'] 		 = $limit;

      $args['role'] 		    = 'service_provider';
			$args['count_total'] 	= true;
      $args['orderby'] 	    = 'rand()';

			//-----------------------------------------------

			$wp_user_query = new projecttheme_user_query($args);
			$authors = $wp_user_query->get_results();

			// Check for results
			if (!empty($authors))
			{

				echo '<div class="row">';
				foreach ($authors as $author)
				{
					// get all the user's data

					ProjectTheme_get_user_table_row_widget($author->ID, $show_skills);
				}

        echo '</div>';

				echo '<div class="see-all-freelancers"><a class="btn btn-primary btn-lg" href="'.get_permalink(get_option('ProjectTheme_provider_search_page_id')).'">'.__('Search For More Freelancers','ProjectTheme').'</a></div>';



			} else {
				echo __('No service providers found for this query.', 'ProjectTheme' );
			}






echo $args['after_widget'];
}

// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'ProjectTheme' );
}
// Widget admin form
?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','ProjectTheme'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
			value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:95%;" />
		</p>


    <p>
			<label for="<?php echo $this->get_field_id('show_freelancers_limit'); ?>"><?php _e('Show projects limit','ProjectTheme'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('show_freelancers_limit'); ?>" name="<?php echo $this->get_field_name('show_freelancers_limit'); ?>"
			value="<?php echo esc_attr( $instance['show_freelancers_limit'] ); ?>" style="width:20%;" />
		</p>



    <p>
			<label for="<?php echo $this->get_field_id('show_skills'); ?>"><?php _e('Show skills for users','ProjectTheme'); ?>:</label>
			<input type="checkbox" id="<?php echo $this->get_field_id('show_skills'); ?>" name="<?php echo $this->get_field_name('show_skills'); ?>"
			value="1" <?php if($instance['show_skills'] == "1") echo "checked" ?> style="width:20%;" />
		</p>
<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['show_skills'] = $new_instance['show_skills'] ;
$instance['show_freelancers_limit'] = ( ! empty( $new_instance['show_freelancers_limit'] ) ) ? strip_tags( $new_instance['show_freelancers_limit'] ) : '';

return $instance;
}
} // Class pt_main_page_latest_proj_big_class ends here




?>
