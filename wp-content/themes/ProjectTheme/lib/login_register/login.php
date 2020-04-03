<?php
/*****************************************************************************
*
*	copyright(c) - sitemile.com - ProjectTheme
*	More Info: http://sitemile.com/p/project
*	Coder: Saioc Dragos Andrei
*	Email: andreisaioc@gmail.com
*
******************************************************************************/
if(!function_exists('ProjectTheme_do_login_scr'))
{
function ProjectTheme_do_login_scr()
		{


		  global $wpdb, $error, $wp_query;

		  if (!is_array($wp_query->query_vars))
			$wp_query->query_vars = array();

		  $action = $_REQUEST['action'];
		  $error = '';



		  nocache_headers();

		  header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

		  if ( defined('RELOCATE') )
		  { // Move flag is set
			if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
				$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

			$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
			if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != get_option('url') )
				update_option('url', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
		  }




		  $secure = ( 'https' === parse_url( site_url(), PHP_URL_SCHEME ) && 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
		setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN, $secure );
		if ( SITECOOKIEPATH != COOKIEPATH )
			setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );


		$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
		$interim_login = isset($_REQUEST['interim-login']);


		do_action( 'login_init' );
		do_action( 'login_form_' . $action );




		  switch($_REQUEST["action"])
		  {
			//logout
			case "logout":
				wp_clearcookie();
			  if(get_option("jk_logout_redirect_to"))
				$redirect_to = get_option("jk_logout_redirect_to");
			  else
				$redirect_to = "wp-login.php";
				do_action('wp_logout');
				nocache_headers();

				if ( isset($_REQUEST['redirect_to']) )
					$redirect_to = $_REQUEST['redirect_to'];

			  wp_redirect(home_url());
				exit();
			break;

			//lost lost password
			case 'lostpassword':
			case 'retrievepassword':

			$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

			if ( $http_post ) {
				$errors = my_retrieve_password();
				if ( !is_wp_error($errors) ) {
					$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
					wp_safe_redirect( $redirect_to );
					exit();
				}
			}

			if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.','ProjectTheme'));
			$redirect_to = apply_filters( 'lostpassword_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );

			do_action('lost_password');
			$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';


			get_header();



		?>




<!-- ########## -->

<div id="main_wrapper">
		<div id="main" class="wrapper-register"><div class="padd10">




				<div class=" my_box4 card mt-4">


                <div class="p-4">

					<h3 class="h3-name"><?php printf(__("Retrieve Password",'ProjectTheme') ); ?></h3>

                <div class="login-submit-form">
				<form name="lostpass" action="<?php echo esc_url( get_site_url() . '/wp-login.php?action=lostpassword' ); ?>" method="post" id="loginform">


					<p><?php _e('Please enter your information here. We will send you a new password.','ProjectTheme'); ?></p>
					<?php if ($errors) {echo "<div class='alert alert-danger'>".$errors->get_error_message()."</div>";} ?>
					<input type="hidden" name="action" value="retrievepassword" />


					<p>

                    <input type="text" class="do_input" name="user_login" id="user_login" placeholder="<?php _e('Username or Email:','ProjectTheme') ?>" value="" size="30" tabindex="1" />
                    </p>


                  	<?php do_action('lostpassword_form'); ?>

					<p><label>&nbsp;</label>
					<input type="submit" name="submit" id="submits" value="<?php _e('Retrieve Password','ProjectTheme'); ?>"  class="btn btn-primary btn-lg" tabindex="3" />
                    </p>

				</form>

                </div>





					 <div class="alrd-register-login">
						<?php printf(__("Already have an account ? <a href='%s' class='link-man-1'>Login here</a> ","ProjectTheme"), site_url().'/wp-login.php'  	); ?>
					</div>



                </div>

                </div>


                </div></div></div>

		<?php



				get_footer();
				die();

			break;

			case 'retrievepassword2':


				get_header();


				$user_data = get_userdatabylogin($_POST['user_login']);
				// redefining user_login ensures we return the right case in the email
				$user_login = $user_data->user_login;
				$user_email = $user_data->user_email;

				if (!$user_email || $user_email != $_POST['email'])

				{



					?>

                <div class="my_box4 card">
            	<div class="box_content2">

            	<div class="box_title"><?php _e("Retrieve Error",'ProjectTheme'); ?> - <?php echo  get_bloginfo('name'); ?></div>
                <div class="box_content">

                    <br/><br/>
                    <?php
					echo sprintf(__('Sorry, that user does not seem to exist in our database. Perhaps you have the wrong username or e-mail address? <a href="%s">Try again</a>.','ProjectTheme'), 'wp-login.php?action=lostpassword');

					?>

					<br/><br/>
					&nbsp;

					</div></div></div>
					<?php

					get_footer();
					die();
				}

			  do_action('retreive_password', $user_login);  // Misspelled and deprecated.
			  do_action('retrieve_password', $user_login);

				// Generate something random for a password... md5'ing current time with a rand salt
				$key = substr( md5( uniqid( current_time('timestamp',0) ) ), 0, 50);
				// now insert the new pass md5'd into the db
				$wpdb->query("UPDATE $wpdb->users SET user_activation_key = '$key' WHERE user_login = '$user_login'");
				$message = __('Someone has asked to reset the password for the following site and username.','ProjectTheme') . "\r\n\r\n";
				$message .= get_option('url') . "\r\n\r\n";
				$message .= sprintf(__('Username: %s','ProjectTheme'), $user_login) . "\r\n\r\n";
				$message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.'
				,'ProjectTheme') . "\r\n\r\n";
				$message .= get_option('url') . "/wp-login.php?action=resetpass&key=$key\r\n";

				$m = ProjectTheme_send_email($user_email, sprintf(__('[%s] Password Reset','ProjectTheme'), get_option('blogname')), $message);

				echo get_option("jk_login_after_head_html");
			  echo "          <div id=\"login\">\n";
				if ($m == false)
			  {
				echo "<h1>".__("There Was a Problem",'ProjectTheme')."</h1>";
				  echo '<p>' . __('The e-mail could not be sent.','ProjectTheme') . "<br />\n";
				echo  __('Possible reason: your host may have disabled the mail() function...','ProjectTheme') . "</p>";
				}
			  else
			  {
				echo "<h1>Success!</h1>";
					echo '<p>' .  sprintf(__("The e-mail was sent successfully to %s's e-mail address.",'ProjectTheme'), $user_login) . '<br />';
					echo  "<a href='wp-login.php' title='" . __('Check your e-mail first, of course','ProjectTheme') . "'>" .
					__('Click here to login!','ProjectTheme') . '</a></p>';
				}
			  echo "          </div>\n";


				echo '</div></div></div>';
				get_footer();

				die();
			break;

			//reset password
			case 'rp' :

				get_header();
				//_get_whole_menu();

				echo '<div class="my_box3">
            	<div class="padd10">';


			  echo "          <div id=\"login\">\n";
				// Generate something random for a password... md5'ing current time with a rand salt
				$key = preg_replace('/a-z0-9/i', '', $_GET['key']);
				if ( empty($key) )
			  {
				_e('<h1>Problem</h1>','ProjectTheme');
					_e('Sorry, that key does not appear to be valid.','ProjectTheme');
				echo "          </div>\n";


				echo '</div></td></tr></table></div></div>';
				get_footer();

				die();
			  }
				$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_activation_key = '$key'");
				if ( !$user )
			  {
				_e('<h1>Problem</h1>','ProjectTheme');
					_e('Sorry, that key does not appear to be valid.','ProjectTheme');
				echo "          </div>\n";


				echo '</div></div>';
				get_footer();

				die();
			  }

				do_action('password_reset');

				$new_pass = substr( md5( uniqid( current_time('timestamp',0) ) ), 0, 7);
				$wpdb->query("UPDATE $wpdb->users SET user_pass = MD5('$new_pass'), user_activation_key = '' WHERE user_login = '$user->user_login'");
				wp_cache_delete($user->ID, 'users');
				wp_cache_delete($user->user_login, 'userlogins');
				$message  = sprintf(__('Username: %s','ProjectTheme'), $user->user_login) . "\r\n";
				$message .= sprintf(__('Password: %s','ProjectTheme'), $new_pass) . "\r\n";
				$message .=   esc_url( home_url() )  . "/wp-login.php\r\n";

				$m = wp_mail($user->user_email,  sprintf(__('Your new password','ProjectTheme')), $message);
				//ProjectTheme_send_email($user->user_email, sprintf(__('Your new password','ProjectTheme') ), $message);

				if ($m == false)
			  {
				echo __('<h1>Problem</h1>','ProjectTheme');
					echo '<p>' . __('The e-mail could not be sent.','ProjectTheme') . "<br />\n";
					echo  __('Possible reason: your host may have disabled the mail() function...','ProjectTheme') . '</p>';
				}
			  else
			  {
				echo __('<h1>Success!</h1>','ProjectTheme');
					echo '<p>' .  sprintf(__('Your new password is in the mail.','ProjectTheme'), $user_login) . '<br />';
				echo  "<a href='wp-login.php' title='" . __('Check your e-mail first, of course','ProjectTheme') . "'>" .
				__('Click here to login!','ProjectTheme') . '</a></p>';
					// send a copy of password change notification to the admin
					$message = sprintf(__('Password Lost and Changed for user: %s','ProjectTheme'), $user->user_login) . "\r\n";
					ProjectTheme_send_email(get_option('admin_email'), sprintf(__('[%s] Password Lost/Change','ProjectTheme'), get_option('blogname')), $message);
				}
			  echo "          </div>\n";


			echo '</div></div></div>';
				get_footer();


				die();
			break;

			//login and default action
			case 'login' :
			default:

			   //check credentials - 99% of this is identical to the normal wordpress login sequence as of 2.0.4
			  //Any differences will be noted with end of line comments.
				$user_login = '';
				$user_pass = '';
				$using_cookie = false;
				$secure_cookie = '';

				if(isset($_POST['log']) or isset($_REQUEST['log']))
				{

				if ( !empty($_POST['log']) && !force_ssl_admin() ) {
						$user_name = sanitize_user($_POST['log']);
						if ( $user = get_user_by('login', $user_name) ) {
							if ( get_user_option('use_ssl', $user->ID) ) {
								$secure_cookie = true;
								force_ssl_admin(true);
							}



								$active_user = get_user_meta($user->ID,	'active_user',	true);

								if($active_user == "no")
								{
											$user1 			= new WP_Error( 'error_on_activation', __( '<strong>ERROR</strong>: Your account is not active yet. Check the activation email.' ) );
											$no_active 	= 1;
								}


						}



					}

				//------------------------------

				 if ( empty( $_GET['redirect_to'] ) ) {
					$redirect_to = get_permalink(get_option('ProjectTheme_my_account_page_id'));
					if(empty($redirect_to)) $redirect_to = admin_url();
				 } else {
					$redirect_to = $_GET['redirect_to'];
				 }

				 if(isset($_SESSION['redirect_me_back'])) $redirect_to = $_SESSION['redirect_me_back'];

				//------------------------------------------

				$reauth = empty($_REQUEST['reauth']) ? false : true;

				if($no_active == 1)
				{
							$user = $user1;

				}
				else {


				$user = wp_signon( '', $secure_cookie );

				}

				if ( empty( $_COOKIE[ LOGGED_IN_COOKIE ] ) ) {
					if ( headers_sent() ) {
						$user = new WP_Error( 'test_cookie', sprintf( __( '<strong>ERROR</strong>: Cookies are blocked due to unexpected output. For help, please see <a href="%1$s">this documentation</a> or try the <a href="%2$s">support forums</a>.','ProjectTheme' ),
							 'https://codex.wordpress.org/Cookies' ,   'https://wordpress.org/support/'   ) );
					} elseif ( isset( $_POST['testcookie'] ) && empty( $_COOKIE[ TEST_COOKIE ] ) ) {
						// If cookies are disabled we can't log in even with a valid user+pass
						$user = new WP_Error( 'test_cookie', sprintf( __( '<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href="%s">enable cookies</a> to use WordPress.' ,'ProjectTheme'),
							  'https://codex.wordpress.org/Cookies'   ) );
					}
				}

				//--------------------------------------------

				$requested_redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
				$redirect_to = apply_filters( 'login_redirect', $redirect_to, $requested_redirect_to, $user );

		 		if ( !is_wp_error($user) && !$reauth ) {

					wp_safe_redirect($redirect_to);
					exit;
				}
			}


			global $title_me;
			$title_me = 'Login';
			add_filter( 'wp_title', 'ProjectTheme_project_pages_title', 10, 1 );

				get_header();



		?>






<!-- ########## -->

<div class="container">
		<div id="main" class="wrapper-register">


            <div class="my_box4 card mt-4"><div class="p-4">


				<h3 class="h3-name"><?php printf(__("Login",'ProjectTheme')); ?></h3>

                <div class="box_content2">

           		<?php
				if(isset($_GET['checkemail']) && $_GET['checkemail'] == "confirm"):
				?>

                    <div class="check-email-div"><div class="padd10">
                    <?php _e('We have sent a confirmation message to your email address.<br/>
					Please follow the instructions in the email and get back to this page.','ProjectTheme'); ?>
                    </div></div>


				<?php
				endif;


						$errors = $user;
						$errors = apply_filters( 'wp_login_errors', $errors, $redirect_to );

						if ( empty($errors) )
						$errors = new WP_Error();

				?>

						<?php

						global $error;
						$wp_error = $errors;

						if ( !empty( $error ) ) {
							$wp_error->add('error', $error);
							unset($error);
						}

						if ( $wp_error->get_error_code() ) {
							$errors = '';
							$messages = '';
							foreach ( $wp_error->get_error_codes() as $code ) {
								$severity = $wp_error->get_error_data( $code );
								foreach ( $wp_error->get_error_messages( $code ) as $error_message ) {
									if ( 'message' == $severity )
										$messages .= '	' . $error_message . "<br />\n";
									else
										$errors .= '	' . $error_message . "<br />\n";
								}
							}
							if ( ! empty( $errors ) ) {
								/**
								 * Filter the error messages displayed above the login form.
								 *
								 * @since 2.1.0
								 *
								 * @param string $errors Login error message.
								 */
								echo '<div class="alert alert-danger">' . apply_filters( 'login_errors', $errors ) . "</div>\n";
							}
							if ( ! empty( $messages ) ) {
								/**
								 * Filter instructional messages displayed above the login form.
								 *
								 * @since 2.5.0
								 *
								 * @param string $messages Login messages.
								 */
								echo '<p class="message">' . apply_filters( 'login_messages', $messages ) . "</p>\n";
							}
						}




						?>

                <div class="login-submit-form">

				<form name="loginform" id="loginform" action="<?php echo esc_url( get_site_url(  ) . '/wp-login.php?wpe-login=true'); ?>" method="post">
				<p>
				<input class="do_input" type="text" name="log" id="log" placeholder="<?php _e('Type your username','ProjectTheme'); ?>" value="<?php echo esc_html(stripslashes($user_login), 1); ?>" size="30"  />
                </p>


				<p>
				<input class="do_input" type="password" name="pwd" id="login_password" placeholder="<?php _e('Type your password','ProjectTheme'); ?>"  value="" size="30"  />
				</p>

				<p>
				<input class="" name="rememberme" type="checkbox" id="rememberme" value="true" tabindex="3" />
				<?php _e('Keep me logged in','ProjectTheme'); ?>
                </p>


                <?php do_action('login_form'); ?>


				<p><label>&nbsp;</label>
				<input type="submit" class="btn btn-primary btn-lg btn-block" name="wp-submit" id="submits" value="<?php _e('Sign in','ProjectTheme'); ?>" tabindex="4" />
				<input type="hidden" name="redirect_to" value="<?php echo esc_html($redirect_to); ?>" />
				</p>

								<input type="hidden" name="testcookie" value="1" />
                </form>


					<div class="alrd-register-login">
						<?php printf(__("Do not have an account ? <a href='%s' class='link-man-1'>Register here</a> or <a href='%s' class='link-man-1'>Recover your password</a>.","ProjectTheme"), site_url().'/wp-login.php?action=register',
site_url().'/wp-login.php?action=lostpassword'						); ?>
					</div>




            </div>
            </div>



             </div> </div> </div></div>


		<?php

				get_footer();

				die();
			break;
		  }
		}
}

?>
