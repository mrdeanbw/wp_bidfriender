<?php
		// sitemile theme functions needed
		// copyright sitemile.com
		// sitemile@sitemile.com

		if(!function_exists("sitemile_set_header_phng_stuff")) {
		function sitemile_set_header_phng_stuff()
		{
			header("Content-type: image/png");
      $png_image = imagecreate(150, 150);
      imagecolorallocate($png_image, 15, 142, 210);
      imagepng($png_image);
      imagedestroy($png_image);
		}}

		if(!function_exists("sitemile_xml_2_rray")) {
		function sitemile_xml_2_rray($xml)
		{
				foreach ($xml->Formula as $element) {
				foreach($element as $key => $val) {
				 echo "{$key}: {$val}";
				}
		}}}

		if(!function_exists("sitemile_small_fnc_content")) { function sitemile_small_fnc_content() { $small = "e4334esa545dshgsadsad_88324"; return "extra-dev_46199"; }} ?>