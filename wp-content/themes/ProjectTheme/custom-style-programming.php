<?php

header("Content-Type: text/css");

//pt_template_page_1

$pt_template_page_1 = get_option('ProjectTheme_template_header_bg1');
$header_bg_solid = get_option('ProjectTheme_template_header_bg_solid1');

$color1 = get_option('ProjectTheme_template_header_color_1');
$size1 = get_option('ProjectTheme_template_header_size_1');
$height = get_option('ProjectTheme_template_header_height_1');
$margin_top = get_option('ProjectTheme_template_title_margintop_1'); if(empty($margin_top)) $margin_top = 53;
$ProjectTheme_color_for_bk = get_option('ProjectTheme_color_for_bk');

if(empty($color1)) { $color1 = "color: #fff;"; } else  { $color1 = "color: #" . $color1. " !important;"; }
if(empty($size1)) $size1 = "40px"; else $size1 = $size1."px";
if(empty($height)) $height = "min-height:150px";
else $height = "min-height: " . $height . "px";

if(!empty($margin_top)) $margin_top = "padding-top:" . $margin_top . "px;";

if(!empty($ProjectTheme_color_for_bk)) $ProjectTheme_color_for_bk = "body { background: #".$ProjectTheme_color_for_bk." !important }";
echo $ProjectTheme_color_for_bk;


$ProjectTheme_color_for_post_box            = get_option('ProjectTheme_color_for_post_box');
$ProjectTheme_template_header_pgttl_align_1 = get_option('ProjectTheme_template_header_pgttl_align_1');
if(empty($ProjectTheme_template_header_pgttl_align_1)) $ProjectTheme_template_header_pgttl_align_1 = "left";
 ?>

.post-account-box, .my_box3, .account-sidebar-component, .post
{
    <?php if(!empty($ProjectTheme_color_for_post_box)) { echo 'background:#' . $ProjectTheme_color_for_post_box; } ?>
}

 .pt_template_page_1
 {
   <?php if(!empty($pt_template_page_1)) { ?> background: <?php echo !empty( $pt_template_page_1) ? "url('" . $pt_template_page_1 . "')" : "" ?> #f2f2f2 !important; <?php } ?>
  <?php if(!empty($header_bg_solid)) { ?> background:    #<?php echo $header_bg_solid ?> !important; <?php } ?>
    background-repeat: no-repeat;
  background-size: 100% !important;
 }


 .pt_template_page_1 .mm_inn
{
  <?php echo $color1 ?>
  font-size:  <?php echo $size1; ?> ;
  <?php echo $margin_top ?>
  <?php if($ProjectTheme_template_header_pgttl_align_1 != "left") echo "text-align: " . $ProjectTheme_template_header_pgttl_align_1; ?>
}

#x_templ_1_pt .mm_inn
{
    color: #<?php echo get_option('ProjectTheme_template_header_text_color') ?> !important
}


.my_box3_breadcrumb
{
    <?php if($ProjectTheme_template_header_pgttl_align_1 != "left") echo "text-align: " . $ProjectTheme_template_header_pgttl_align_1; ?>
}

<?php if($ProjectTheme_template_header_pgttl_align_1 != "left") { ?>
#x_templ_1_pt
{
  width:100%
}
<?php } ?>

body #pt_template_page_1 .breadcrumb-wrap a:link, body #pt_template_page_1 .breadcrumb-wrap a:visited, body #breadcrumb-wrap  .mm_inn a:link , body #breadcrumb-wrap  .mm_inn a:visited
{
  <?php echo $color1; ?>
}

body .my_box3_breadcrumb .post
{
  background: none !important
}

#pt_template_page_1 .breadcrumb-wrap
{
    <?php echo $color1; ?>
}

#pt_template_page_1
{
  <?php echo $height ?>
}

<?php

    $PT_footer_image_or_color = get_option('PT_footer_image_or_color');
    $PT_footer_image_or_color2 = get_option('PT_footer_image_or_color2');
    if(!empty($PT_footer_image_or_color))
    {
       ?>

          #footer
          {
            background-image: url(<?php echo $PT_footer_image_or_color ?> )
          }

       <?php
    }
    elseif(!empty($PT_footer_image_or_color2))
    {
      ?>

         #footer
         {
           background-image: none;
           background:#<?php echo $PT_footer_image_or_color2 ?>
         }

      <?php
    }


 ?>
