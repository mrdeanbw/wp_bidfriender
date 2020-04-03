<?php


function ProjectTheme_new_user_notification($user_id, $plaintext_pass = '', $act_link = '') {
	$user = new WP_User($user_id);

	$subject 	= get_option('ProjectTheme_new_user_email_subject');
	$message 	= get_option('ProjectTheme_new_user_email_message');

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	$site_login_url = ProjectTheme_login_url();
	$site_name 		= get_bloginfo('name');
	$account_url 	= get_permalink(get_option('ProjectTheme_my_account_page_id'));

	$find 		= array('##username##', '##user_email##', '##site_login_url##', '##your_site_name##', '##your_site_url##' , '##my_account_url##', '##user_password##', '##activation_link##');
	$replace 	= array($user_login, $user_email, $site_login_url, $site_name,  home_url(), $account_url, $plaintext_pass, $act_link);
	$message 	= ProjectTheme_replace_stuff_for_me($find, $replace, $message);
	$subject 	= ProjectTheme_replace_stuff_for_me($find, $replace, $subject);

	//---------------------------------------------

	ProjectTheme_send_email($user_email, $subject, $message);

}

function ProjectTheme_new_user_notification_admin($user_id) {
	$user = new WP_User($user_id);

	$subject 	= get_option('ProjectTheme_new_user_email_admin_subject');
	$message 	= get_option('ProjectTheme_new_user_email_admin_message');

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	$site_login_url = ProjectTheme_login_url();
	$site_name 		= get_bloginfo('name');
	$account_url 	= get_permalink(get_option('ProjectTheme_my_account_page_id'));

	$find 		= array('##username##', '##user_email##', '##site_login_url##', '##your_site_name##', '##your_site_url##' , '##my_account_url##', '##user_password##');
	$replace 	= array($user_login, $user_email, $site_login_url, $site_name, home_url(), $account_url, $plaintext_pass);
	$message 	= ProjectTheme_replace_stuff_for_me($find, $replace, $message);
	$subject 	= ProjectTheme_replace_stuff_for_me($find, $replace, $subject);

	//---------------------------------------------

	$email = get_bloginfo('admin_email');
	ProjectTheme_send_email($email, $subject, $message);

}




if ( !function_exists('my_retrieve_password') ) :
function my_retrieve_password()
{

	global   $wpdb, $current_site;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) ) {
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.', 'ProjectTheme'));
	} else if ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.', 'ProjectTheme'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}


	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.', 'ProjectTheme'));
		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	$allow = apply_filters('allow_password_reset', true, $user_data->ID);

	if ( ! $allow )
		return new WP_Error('no_password_reset', __('Password reset is not allowed for this user', 'ProjectTheme'));
	else if ( is_wp_error($allow) )
		return $allow;

	$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
	if ( empty($key) ) {
		// Generate something random for a key...
		$key = wp_generate_password(20, false);
		do_action('retrieve_password_key', $user_login, $key);
		// Now insert the new md5 key into the db
		$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
	}
	$message = __('Someone requested that the password be reset for the following account:', 'ProjectTheme') . " ";
	$message .= home_url() . "<br/><br/>";
	$message .= sprintf(__('Username: %s', 'ProjectTheme'), $user_login) . "<br/>";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'ProjectTheme') . "<br/>";
	$message .= __('To reset your password, visit the following address:' ,'ProjectTheme') . "<br/>";
	$message .= '' . home_url()."/wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login) . "<br/>";

	if ( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else
		// The blogname option is escaped with esc_html on the way into the database in sanitize_option
		// we want to reverse this for the plain text arena of emails.
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('Password Reset', 'ProjectTheme') );

	$title = apply_filters('retrieve_password_title', $title);
	$message = apply_filters('retrieve_password_message', $message, $key);

	if ( $message && !wp_mail($user_email, $title, $message) )
		wp_die( __('The e-mail could not be sent.', 'ProjectTheme') . "<br />\n" . __('Possible reason: your host may have disabled the
		mail() function...', 'ProjectTheme') );

		}
endif;
?>
