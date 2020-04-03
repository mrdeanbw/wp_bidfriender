<?php




		$ProjectTheme_stretch_enable = get_option('ProjectTheme_stretch_enable');
		
		if($ProjectTheme_stretch_enable == 'yes'):
		if(is_home()) {			
		
				echo '<div class="stretch-body"><div class="stretch-area wrapper"><ul class="xoxo">';
				dynamic_sidebar( 'main-stretch-area' );
				echo '</ul></div></div> ';
					
					}
		endif;
		
		
		
		?>