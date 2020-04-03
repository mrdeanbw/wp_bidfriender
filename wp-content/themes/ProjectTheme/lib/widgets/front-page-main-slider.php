<?php

// Register and load the widget
function pt_main_page_slider_bo_widget() {
    register_widget( 'pt_main_page_slider_bo_widget_class' );
}
add_action( 'widgets_init', 'pt_main_page_slider_bo_widget' );

// Creating the widget
class pt_main_page_slider_bo_widget_class extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'pt_main_page_slider_bo_widget_class',

// Widget name will appear in UI
__('ProjectTheme - Main Slider Home', 'ProjectTheme'),

// Widget description
array( 'description' => __( 'Shows the big slider for project theme homepage.', 'ProjectTheme' ), )
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
 ?>



         <div class="home_blur">
        <div class="main_area_homepg">
       		<div class="main_tagLine"><?php echo get_option('ProjectTheme_main_tagline') ?></div>
            <div class="sub_tagLine"><div class="wrps"><?php echo get_option('ProjectTheme_sec_tagline') ?></div></div>

            <!--
            <form method="get" action="<?php echo get_permalink(get_option('ProjectTheme_advanced_search_page_id')) ?>">
            <div class="search_box_main">
            	<div class="search_box_main2">
                    <div class="rama1"><input type="text" placeholder="<?php _e('What service do you need? (e.g. website design)','ProjectTheme'); ?>" id="findService" name="term"></div>
                    <div class="rama1 rama2"><input type="image" src="<?php echo get_template_directory_uri(); ?>/images/sear1.png" width="44" height="44" /></div>
                </div>
            </div>
            </form> -->

            <div class="buttons_box_main">
            	<ul class="regular_ul">
                	<li><a class="btn btn-primary btn-lg btn-block" href="<?php echo get_option('ProjectTheme_button1_link') ?>"><?php echo get_option('ProjectTheme_button1_caption') ?></a></li>
                	<li><a class="btn btn-primary btn-lg btn-block" href="<?php echo get_option('ProjectTheme_button2_link') ?>"><?php echo get_option('ProjectTheme_button2_caption') ?></a></li>
                </ul>

            </div>

<div id='search-box'>
<form action='<?php echo site_url(); ?>'  method='get' target='_top'><input type="hidden" value='<?php echo get_option('ProjectTheme_advanced_search_page_id') ?>' name="page_id" />

  <div class="input-group mb-3">
    <input type="text" class="form-control" id="search-box-m1" placeholder='<?php _e('Start search...','ProjectTheme') ?>' aria-label="Recipient's username" aria-describedby="basic-addon2" name="term" />
    <div class="input-group-append">
      <button class="btn btn-primary" id="search-button-m1" type="submit"><?php _e('Search Now','ProjectTheme') ?></button>
    </div>
  </div>





</form>
</div>

        </div>
       	</div>


 <?php

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
<!--<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ProjectTheme' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /> -->


Control the options for this widget, and the captions of the buttons, links, images and more from <a href="<?php echo admin_url() ?>admin.php?page=layout-settings&activate_tab=tabs_home" target="_blank">this link</a>.
</p>
<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class pt_main_page_slider_bo_widget_class ends here




?>
