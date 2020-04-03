<?php

// Register and load the widget
function pt_main_page_latest_proj_widget_sml() {
    register_widget( 'pt_main_page_latest_proj_big_class_sml' );
}
add_action( 'widgets_init', 'pt_main_page_latest_proj_widget_sml' );

// Creating the widget
class pt_main_page_latest_proj_big_class_sml extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'pt_main_page_latest_proj_big_class_sml',

// Widget name will appear in UI
__('ProjectTheme - Latest posts Small', 'ProjectTheme'),

// Widget description
array( 'description' => __( 'Shows the latest posted projects small.', 'ProjectTheme' ), )
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];


		if ($instance['title']) echo '<h5>' . apply_filters('widget_title', $instance['title']) . '</h5>';
		$limit = $instance['show_projects_limit'];

		if(empty($limit) || !is_numeric($limit)) $limit = 5;



				 global $wpdb;
				 $querystr = "
					SELECT distinct wposts.*
					FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
					WHERE wposts.ID = wpostmeta.post_id
					AND wpostmeta.meta_key = 'closed'
					AND wpostmeta.meta_value = '0' AND
					wposts.post_status = 'publish'
					AND wposts.post_type = 'project'
					ORDER BY wposts.post_date DESC LIMIT ".$limit;

				 $pageposts = $wpdb->get_results($querystr, OBJECT);

				 ?>

					 <?php $i = 0; if ($pageposts): ?>
					 <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>


                     <?php projectTheme_get_post(); ?>


                     <?php endforeach;


			echo '<div class="see-all-freelancers"><a class="btn btn-primary btn-lg" href="'.get_permalink(get_option('ProjectTheme_advanced_search_page_id')).'">'.__('Search For More Projects','ProjectTheme').'</a></div>';


				 ?>
                     <?php else : ?> <?php $no_p = 1; ?>

                       <div class="my_box3">
                       <div class="padd100"><p class="center"><?php _e("Sorry, there are no posted projects yet.",'ProjectTheme'); ?></p></div></div>

                     <?php endif;




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
			<label for="<?php echo $this->get_field_id('show_projects_limit'); ?>"><?php _e('Show projects limit','ProjectTheme'); ?>:</label>
			<input type="text" id="<?php echo $this->get_field_id('show_projects_limit'); ?>" name="<?php echo $this->get_field_name('show_projects_limit'); ?>"
			value="<?php echo esc_attr( $instance['show_projects_limit'] ); ?>" style="width:20%;" />
		</p>
<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['show_projects_limit'] = ( ! empty( $new_instance['show_projects_limit'] ) ) ? strip_tags( $new_instance['show_projects_limit'] ) : '';

return $instance;
}
} // Class pt_main_page_latest_proj_big_class ends here




?>
