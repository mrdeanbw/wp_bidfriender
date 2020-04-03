<?php
/*****************************************************************************
*
*	copyright(c) - sitemile.com - ProjectTheme
*	More Info: http://sitemile.com/p/project
*	Coder: Saioc Dragos Andrei
*	Email: andreisaioc@gmail.com
*
******************************************************************************/

		if(!function_exists('ProjectTheme_do_register_scr')) {
		function ProjectTheme_do_register_scr()
		{
		  global $wpdb, $wp_query;

		  if (!is_array($wp_query->query_vars))
			$wp_query->query_vars = array();

		header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

		session_start();
		  switch( $_REQUEST["action"] )
		  {

			case 'register':
			  require_once( ABSPATH . WPINC . '/registration-functions.php');

				$user_login = sanitize_user( str_replace(" ","",$_POST['user_login']) );
				$user_email = trim($_POST['user_email']);

				$sanitized_user_login = $user_login;



				$errors = Project_register_new_user_sitemile($user_login, $user_email);

					if (!is_wp_error($errors))
					{
						$ok_reg = 1;
					}


			  if ( 1 == $ok_reg )
			  {//continues after the break;

					do_action('ProjectTheme_on_success_registration', $user_login);

				get_header();


		?>
              <div class="page_heading_me">
                        <div class="page_heading_me_inner">
                            <div class="mm_inn"><?php printf(__("Registration Complete - %s",'ProjectTheme'), get_bloginfo('name')); ?>   </div>


                        </div>

                    </div>

        <div id="main_wrapper">
		<div id="main" class="wrapper"><div class="padd10">

				<div class="my_box3">
            	<div class="padd10">


							<p><?php printf(__('Username: %s','ProjectTheme'), "<strong>" . esc_html($user_login) . "</strong>") ?><br />
							<?php printf(__('Password: %s','ProjectTheme'), '<strong>' . __('emailed to you','ProjectTheme') . '</strong>') ?> <br />
							<?php printf(__('E-mail: %s','ProjectTheme'), "<strong>" . esc_html($user_email) . "</strong>") ?><br /><br />
							<?php _e("Please check your <strong>Junk Mail</strong> if your account information does not appear within 5 minutes.",'ProjectTheme'); ?>
                            </p>

							<p class="submit"><a href="wp-login.php"><?php _e('Login', 'ProjectTheme'); ?> &raquo;</a></p>
						</div></div>


                        </div></div></div>
		<?php


				get_footer();

				die();
			break;
			  }//continued from the error check above

			default:


			global $title_me;
			$title_me = 'Register';
			add_filter( 'wp_title', 'ProjectTheme_project_pages_title', 10, 1 );

			get_header();



				?>



<div class="container mt-4">
		<div id="main" class="wrapper-register">


				  <div class="my_box4 card"><div class="padd30">

				<h3 class="h3-name"><?php printf(__("Register",'ProjectTheme')); ?></h3>




						  <?php if ( isset($errors) && isset($_POST['action']) ) : ?>
						  <div class="alert alert-danger">
							<ul class="no-style-ul">
							<?php

							$me = $errors->get_error_messages();

						 	foreach($me as $mm)
							 echo "<li>".($mm)."</li>";



							?>
							</ul>
						  </div>
						  <?php endif; ?>
						  <div class="login-submit-form">


                          <form method="post" id="registerform" action="<?php echo esc_url( get_site_url() . '/wp-login.php?action=register' ); ?>">
						  <input type="hidden" name="action" value="register" />

							<p>

							<input type="text" class="do_input" name="user_login" id="user_login" size="30" maxlength="20" placeholder="<?php _e('Your username','ProjectTheme') ?>" value="<?php echo esc_html($user_login); ?>" />
							</p>

							<p>

							<input type="text" class="do_input" name="user_email" id="user_email" size="30" maxlength="100" placeholder="<?php _e('Your email address','ProjectTheme') ?>" value="<?php echo esc_html($user_email); ?>" />
							</p>


							<p>

							<input type="password" class="do_input" name="password" id="password" size="30" maxlength="100"  placeholder="<?php _e('Your password','ProjectTheme') ?>"  />
							</p>


							<p>

							<input type="password" class="do_input" name="cpassword" id="cpassword" size="30" maxlength="100"  placeholder="<?php _e('Your password confirmation','ProjectTheme') ?>" />
							</p>

							<!-- Leon -->
							<p>
							<input class="do_input" name="instagram_username" id="instagram_username" size="30" maxlength="100"  placeholder="<?php _e('Instagram UserName','ProjectTheme') ?>" />
							</p>
							<!-- Leon -->

                            <?php

								$ProjectTheme_enable_2_user_tp = get_option('ProjectTheme_enable_2_user_tp');
								if($ProjectTheme_enable_2_user_tp == "yes"):

								$enbl = true;
								$enbl = apply_filters('ProjectTheme_enbl_two_user_types_thing',$enbl);

								if($enbl):
							?>

                            <p>
							<label for="register-email"><?php _e('User Type:','ProjectTheme') ?></label>
							<input type="radio" class="do_input_radio" name="user_tp" id="user_tp" value="service_provider" checked="checked" /> <?php _e('Freelancer/Service Provider','ProjectTheme'); ?><br/>
                            <input type="radio" class="do_input_radio" name="user_tp" id="user_tp" value="business_owner" /> <?php _e('Buyer/Customer','ProjectTheme'); ?><br/>
							</p>



                            <?php endif; endif; ?>




							<?php do_action('register_form'); ?>




						<p class="submit">
                        <label for="submitbtn">&nbsp;</label>
							 <input type="submit" class="btn btn-primary btn-lg btn-block" value="<?php _e('Register now','ProjectTheme') ?>" id="submits" name="submits" />
						</p>




						  <div class="alrd-register-login">
						<?php printf(__("Already have an account ? <a href='%s' class='link-man-1'>Login here</a> or <a href='%s' class='link-man-1'>Recover your password</a>.","ProjectTheme"), get_site_url().'/wp-login.php',
get_site_url().'/wp-login.php?action=lostpassword'						); ?>
					</div>


                          </form>
						</div>





                        </div>



                        </div></div></div>


		<?php


	 			  get_footer();

			  die();
			break;
			case 'disabled':

	 			  get_header();


		?>
        <div class="clear10"></div>
				<div class="my_box3">
            	<div class="padd10">

        <div class="box_title"><?php _e('Registration Disabled','ProjectTheme') ?></div>
                <div class="box_content">


							<p><?php _e('User registration is currently not allowed.','ProjectTheme') ?><br />
							<a href="<?php echo home_url(); ?>/" title="<?php _e('Go back to the blog','ProjectTheme') ?>"><?php _e('Home','ProjectTheme') ?></a>
							</p>
						</div></div></div>
		<?php

				 get_footer();

			  die();
			break;
		  }
		}


		}

//===================================================================




if(!function_exists('Project_register_new_user_sitemile')) {
function Project_register_new_user_sitemile( $user_login, $user_email ) {
	$errors = new WP_Error();
	global $wpdb;

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.', 'ProjectTheme' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.', 'ProjectTheme' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.', 'ProjectTheme' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.', 'ProjectTheme' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.', 'ProjectTheme' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.', 'ProjectTheme' ) );
	}


	if ( strlen($password) < 5 ) {
		$errors->add( 'pass', __( '<strong>ERROR</strong>: Please type a password with at least 5 characters.', 'ProjectTheme' ) );
	}
	else if ( $password!= $cpassword )
		{
		$errors->add( 'pass', __( '<strong>ERROR</strong>: Your password doesnt match the confirmation.', 'ProjectTheme' ) );
	}


	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );




	if ( $errors->get_error_code() )
		return $errors;

	//--------------------

	$user_tp = $_POST['user_tp'];
	if(empty($user_tp)) $capa = 'subscriber';
	else $capa = $user_tp;

	//--------------------

	$user_pass = $password; //wp_generate_password( 12, false);

	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email, $capa );
	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'ProjectTheme' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	//---------------------
	// set the user role ----

	$user = new WP_User($user_id);
	$user->set_role($capa);

	//---------------------
	// set the activation key for the user

	$key = md5( wp_generate_password() );

	$wpdb->query("update $wpdb->users set user_activation_key='$key' where ID='$user_id'");
	update_user_meta( $user_id, 'active_user', 			'no' );

	//--------------------------
	// send the notifications by email

	$act_link = get_site_url() . "/?p_action=activate_user&key=" . $key;

	ProjectTheme_new_user_notification($user_id, $user_pass, $act_link );
	ProjectTheme_new_user_notification_admin($user_id);

	//------------------------

	return $user_id;
} }

?>
