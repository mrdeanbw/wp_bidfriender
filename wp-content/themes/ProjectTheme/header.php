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


?>
<html <?php language_attributes(); ?>  dir="ltr">
 <head>

	 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <meta http-equiv="Content-Language" content="en" />
 <meta name="msapplication-TileColor" content="#2d89ef">
 <meta name="theme-color" content="#4188c9">
 <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
 <meta name="apple-mobile-web-app-capable" content="yes">
 <meta name="mobile-web-app-capable" content="yes">
 <meta name="HandheldFriendly" content="True">
 <meta name="MobileOptimized" content="320">


	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" defer></script>

 <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">


    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_enqueue_script("jquery"); ?>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" async  crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" async integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">




	<?php

		wp_head();

	?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" defer integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" defer integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



<script src="<?php echo get_template_directory_uri() ?>/js/jquery.countdown.js" defer></script>
<script src="<?php echo get_template_directory_uri() ?>/js/vegas.min.js" defer></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/vegas.css" async>


<script>





jQuery(document).ready(function(){


  jQuery('.expiration_project_p').each(function(index)
  {
  var until_now = jQuery(this).html();
  jQuery(this).countdown({until: until_now, format: 'd H M S', compact: false});


  });

jQuery(".home_blur").vegas({
slides: [

<?php

for($i=1;$i<=10; $i++)
{
  $fri = get_option('ProjectTheme_slider_img_' . $i);
  if(!empty($fri))
  {
?>

    { src: "<?php echo $fri ?>" },

<?php }} ?>
]
});});

</script>

    <?php do_action('ProjectTheme_before_head_tag_closes'); ?>






	</head>
	<body <?php body_class(); ?> > <?php do_action('ProjectTheme_after_body_tag_open'); ?>

		<div class="page">
				<div class="flex-fill">
						<div class="header py-3">
								<div class="container">
										<div class="d-flex">

								<?php

								//starting of generating and working with the logo

								$logo = get_option('ProjectTheme_logo_URL');
								if(empty($logo)){

									$logo = get_template_directory_uri().'/images/project_theme_logo.png';
									$logo = apply_filters('ProjectTheme_logo_URL', $logo);
								}

								$logo_options = '';
								$logo_options = apply_filters('ProjectTheme_logo_options', $logo_options);


								$width = 200;
								$ProjectTheme_logo_width = get_option('ProjectTheme_logo_width');
								if(!empty($ProjectTheme_logo_width)) $width = $ProjectTheme_logo_width;


								?>
									<a class="header-brand" href="<?php echo home_url(); ?>">
											<img  class="header-brand-img" alt="<?php bloginfo('name'); ?> logo" <?php echo $logo_options; ?> src="<?php echo $logo; ?>" width="<?php echo $width ?>"  />
										</a>

										<!-- end of logo block -->


										<div class="d-flex order-lg-2 ml-auto" id="very-top-header-menu">
                    <?php

                    if(!is_user_logged_in())
                    {

                    ?>



                    <div class="nav-item   d-md-flex">
                      <a href="<?php echo get_site_url() ?>/wp-login.php" class="btn btn-sm  "  ><?php _e('Login','ProjectTheme') ?></a>
                    </div>

                    <div class="nav-item  d-md-flex">
                      <a href="<?php echo get_site_url() ?>/wp-login.php?action=register" class="btn btn-sm  "  ><?php _e('Register','ProjectTheme') ?></a>
                    </div>



                    <div class="nav-item d-none d-md-flex">
                      <a href="<?php echo get_permalink(get_option('ProjectTheme_post_new_page_id')) ?>" class="btn btn-sm btn-primary"  ><?php _e('Post Project','ProjectTheme') ?></a>
                    </div>


                <?php

                    }

                    if(is_user_logged_in())
                    {

                        if(ProjectTheme_is_user_business(get_current_user_id()))
                        {
                ?>


                <div class="nav-item d-none d-md-flex">
                  <a href="<?php echo get_permalink(get_option('ProjectTheme_post_new_page_id')) ?>" class="btn btn-sm btn-primary"  ><?php _e('Post Project','ProjectTheme') ?></a>
                </div>

              <?php }

                if(function_exists('pt_notifications_plugin_zm'))
                {
                        pt_notifications_plugin_zm();            } ?>


                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown" id="avatar-top-menu-img" aria-expanded="false">
                    <?php

                          $avatar = ProjectTheme_get_avatar(get_current_user_id(), 40, 40);

                          $user = wp_get_current_user();
                          $username = $user->user_login;

                        	$usr_nm = $user->first_name." ".$user->last_name;
                        	$usr_nm = trim($usr_nm);

                          if(!empty($usr_nm)) $showing = $usr_nm;
                          else $showing = $username;

                          $showing = substr($showing, 0, 20);

                     ?>
                    <span class="avatar" style="background-image: url('<?php echo $avatar ?>')"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default"><?php echo $showing ?></span>
                      <small class="text-muted d-block mt-1"><?php echo pt_get_user_role_nice_string(get_current_user_id()); ?></small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; transform: translate3d(136px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <?php

                        if( current_user_can('administrator') )
                        {


                     ?>

                    <a class="dropdown-item" href="<?php echo get_site_url() ?>/wp-admin/">
                    <?php _e('<i class="dropdown-icon fe fe-user"></i> WP-ADMIN','ProjectTheme') ?>
                    </a>

                  <?php } ?>


                  <a class="dropdown-item" href="<?php echo get_permalink(get_option('ProjectTheme_my_account_page_id')) ?>">
                  <?php _e('<i class="dropdown-icon fe fe-user"></i> Dashboard','ProjectTheme') ?>
                  </a>


                  <a class="dropdown-item" href="<?php echo get_permalink(get_option('ProjectTheme_my_account_payments_id')) ?>">
                  <?php _e('<i class="dropdown-icon fe fe-user"></i> Finances','ProjectTheme') ?>
                  </a>

                    <a class="dropdown-item" href="<?php echo get_permalink(get_option('ProjectTheme_my_account_personal_info_id')) ?>">
                       <?php _e('<i class="dropdown-icon fe fe-settings"></i> Settings','ProjectTheme') ?>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="<?php echo wp_logout_url( home_url()); ?>">
                       <?php _e('<i class="dropdown-icon fe fe-log-out"></i> Sign out','ProjectTheme') ?>
                    </a>
                  </div>
                </div> <?php } ?>
              </div>


							<a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>

						</div></div></div>

						<!-- end the header block -->

						<!-- starting the menu block -->

						<?php

							//******************************************************************
							//
							//	you can control this from admin, to show or not show the main menu, nice feature
							//
							//******************************************************************

		 					$ProjectTheme_show_blue_menu = get_option('ProjectTheme_show_blue_menu');
		 					if($ProjectTheme_show_blue_menu == 'yes') {  // && !projecttheme_is_home()):
	 ?>

						<div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container" id="container-main">
            <div class="row align-items-center">

              <?php $menu_name = 'primary-projecttheme-main-header'; ?>

              <?php
              wp_nav_menu( array(
                'theme_location'    => $menu_name,
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'col-lg order-lg-first',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav nav-tabs border-0 flex-column flex-lg-row pt-theme-main-navi',
                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                'walker'            => new WP_Bootstrap_Navwalker(),
              ) );
              ?>


 <!--
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">




                  <li class="nav-item">
                    <a href="./index.html" class="nav-link"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-box"></i> Interface</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./cards.html" class="dropdown-item ">Cards design</a>
                      <a href="./charts.html" class="dropdown-item ">Charts</a>
                      <a href="./pricing-cards.html" class="dropdown-item ">Pricing cards</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link active" data-toggle="dropdown"><i class="fe fe-calendar"></i> Components</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./maps.html" class="dropdown-item ">Maps</a>
                      <a href="./icons.html" class="dropdown-item ">Icons</a>
                      <a href="./store.html" class="dropdown-item active">Store</a>
                      <a href="./blog.html" class="dropdown-item ">Blog</a>
                      <a href="./carousel.html" class="dropdown-item ">Carousel</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown"><i class="fe fe-file"></i> Pages</a>
                    <div class="dropdown-menu dropdown-menu-arrow">
                      <a href="./profile.html" class="dropdown-item ">Profile</a>
                      <a href="./login.html" class="dropdown-item ">Login</a>
                      <a href="./register.html" class="dropdown-item ">Register</a>
                      <a href="./forgot-password.html" class="dropdown-item ">Forgot password</a>
                      <a href="./400.html" class="dropdown-item ">400 error</a>
                      <a href="./401.html" class="dropdown-item ">401 error</a>
                      <a href="./403.html" class="dropdown-item ">403 error</a>
                      <a href="./404.html" class="dropdown-item ">404 error</a>
                      <a href="./500.html" class="dropdown-item ">500 error</a>
                      <a href="./503.html" class="dropdown-item ">503 error</a>
                      <a href="./email.html" class="dropdown-item ">Email</a>
                      <a href="./empty.html" class="dropdown-item ">Empty page</a>
                      <a href="./rtl.html" class="dropdown-item ">RTL mode</a>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="./form-elements.html" class="nav-link"><i class="fe fe-check-square"></i> Forms</a>
                  </li>
                  <li class="nav-item">
                    <a href="./gallery.html" class="nav-link"><i class="fe fe-image"></i> Gallery</a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/index.html" class="nav-link"><i class="fe fe-file-text"></i> Documentation</a>
                  </li>
                </ul>
              </div> -->
            </div>
          </div>
        </div>

				<?php } ?>
				<!-- ending the menu block -->

				<div id='project-theme-page-template-1'>
