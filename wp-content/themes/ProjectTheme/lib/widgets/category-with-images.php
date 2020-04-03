<?php

add_action('widgets_init', 'projecttheme_a_register_browse_by_category_widget_images');
function projecttheme_a_register_browse_by_category_widget_images() {
	register_widget('projecttheme_browse_by_category_with_images');
}

class projecttheme_browse_by_category_with_images extends WP_Widget {

	function projecttheme_browse_by_category_with_images() {
		$widget_ops = array( 'classname' => 'browse-by-category-thumbs', 'description' => 'Show all categories and browse by category with thumbnails' );
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'browse-by-category-thumbs' );
		parent::__construct( 'browse-by-category-thumbs', 'ProjectTheme - Category Thumbs', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		
		echo $before_widget;
		
		if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		global $width_widget_categories, $height_widget_categories;
		
		$widget_id 		= $args['widget_id'];
		$width 			= $width_widget_categories;
		$height 		= $height_widget_categories;
		$only_these 	= $instance['only_these'];
		
		$size_string = 'my_size_widget';
		
		//--------------------------------------------------

		$terms_k 		= get_terms("project_cat","parent=0&hide_empty=0");


		global $wpdb;
		$arr = array();
		
		if($only_these == "1")
		{
			$terms = array();
			
			foreach($terms_k as $trm)
			{
				if($instance['term_' . $trm->term_id] == $trm->term_id)
					array_push($terms, $trm);
			}
			
		}
		 
		//-----------------------------
		 
		if(count($terms) < count($terms_k)) $disp_btn = 1;
		else $disp_btn = 0;
		 
		 
		$count = count($terms); 
		$i = 0;
		
		if ( $count > 0 )
		{

			// echo '<style>#'.$widget_id.' .my_image_div_cat_name { width: '.round(100/$nr).'%}</style>';
	
			 foreach ( $terms as $term ) 
			 {
					$projecttheme_get_cat_pic_attached = projecttheme_get_cat_pic_attached($term->term_id);
					$link 		= get_term_link($term->slug,	"project_cat");
					$image 		= projecttheme_generate_thumb3($projecttheme_get_cat_pic_attached, 'my_category_image_thing');
 
					
					echo '<div class="my_category_image_holder"><div class="category-sub-int"><div class="my_image_div">';
					echo '<a href="'.$link.'">';
					echo '<img src="'.$image.'"  />';
					echo '</a></div>';
					
					echo '<div class="my_image_div_cat_name"><div class="padd10">';
					echo '<a href="'.$link.'">'.$term->name.'</a>';
					echo '</div></div>';
					
					
					echo '</div></div>';   
	
			 }
		
			//=========================================================================
				
			if($disp_btn == 1)
			{
					//echo '<div class="see-more-tax"><b><a href="'.get_permalink(get_option('auctiontheme_all_categories_page_id')) .'">'.__('See More Categories','ProjectTheme').'</a></b></div>';		
			}		
		}
		else { echo ('There are no categories defined. Define them from backend.'); }
		
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

         <p>
			<label for="<?php echo $this->get_field_id('nr_rows'); ?>"><?php _e('Only show categories below','ProjectTheme'); ?>:</label>
			<?php echo '<input type="checkbox" name="'.$this->get_field_name('only_these').'"  value="1" '.(
	 $instance['only_these'] == "1" ? ' checked="checked" ' : "" ).' /> '; ?>
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id('nr_rows'); ?>"><?php _e('Categories to show','ProjectTheme'); ?>:</label>
			
                <div style=" width:220px;
    height:180px;
    background-color:#ffffff;
    overflow:auto;border:1px solid #ccc">
     <?php
	 
	 $terms = get_terms("project_cat","parent=0&hide_empty=0");
	 foreach ( $terms as $term ) {
	 
	 echo '<input type="checkbox" name="'.$this->get_field_name('term_'.$term->term_id).'"  value="'.$term->term_id.'" '.(
	 $instance['term_'.$term->term_id] == $term->term_id ? ' checked="checked" ' : "" ).' /> ';
	 echo $term->name.'<br/>';
	 
	 }
	 
	 ?>
     
    </div> 
            
            
            
		</p>
		         
                	
	<?php 
	}
}




?>