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


	global $pagenow;
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
	{
	     // When theme is activated this code runs.
	     // Still be defensive if you need to be, and check if
	     // your baby is alreprojecty born
		 global $wpdb;
		//update_option('sitemile_home_page_layout', '3');
	//--------------------------------------------------------------------

			//ProjectTheme_enable_facebook_login

			$option = get_option('ProjectTheme_enable_facebook_login');

			if(empty($option))
			{


				update_option('projectTheme_nr_max_of_images',	'15');
				update_option('ProjectTheme_charge_fees_for_images',	'no');
				update_option('ProjectTheme_enable_images_in_projects',	'yes');
				update_option('ProjectTheme_enable_twitter_login','yes');
				update_option('ProjectTheme_enable_facebook_login','yes');
				update_option('ProjectTheme_enable_project_location','yes');
				update_option('ProjectTheme_slider_in_front','yes');
				update_option('ProjectTheme_show_blue_menu','yes');
				update_option("project_theme_logo_url",'');
				update_option("projectTheme_currency","USD");
				update_option("projectTheme_currency_symbol","$");
				update_option("projectTheme_price_in_front","yes");
				update_option('projectTheme_base_fee',"0");
				update_option('projectTheme_featured_fee',"0");
				update_option('projectTheme_projectmin_approves_each_project',"no");
				update_option('projectTheme_show_project_views',"yes");
				update_option('projectTheme_featured_fee',"0");
				update_option('projectTheme_featured_fee',"0");
				update_option('projectTheme_enable_blog',"yes");
				update_option('projectTheme_projectmin_approves_each_project',"30");
				update_option('projectTheme_project_period_featured',"35");
				update_option('ProjectTheme_moderate_private_messages',"no");
				update_option('ProjectTheme_enable_2_user_tp',"yes");

				update_option('ProjectTheme_decimal_sum_separator',".");
				update_option('ProjectTheme_thousands_sum_separator',",");



			}
		//-----------------------------

			update_option('ProjectTheme_right_side_footer', '<a title="WordPress Project Bidding Theme" href="http://sitemile.com/products/wordpress-project-freelancer-theme/">WordPress Project Bidding Theme</a>');
			update_option('ProjectTheme_left_side_footer', 'Copyright (c) '.get_bloginfo('name'));

			update_option('ProjectTheme_main_tagline', 'FIND FREELANCERS. GET YOUR PROJECT DONE.');
			update_option('ProjectTheme_sec_tagline', 'YOU CAN START BY POSTING A CHORE YOU NEED DONE OR REGISTER TO GET A JOB.');



		//---------------------------

		ProjectTheme_insert_pages('ProjectTheme_recently_closed_page_id', 					'Recently Closed Projects', 	'[project_theme_recently_closed_projects]' );
		ProjectTheme_insert_pages('ProjectTheme_all_blog_posts_page_id', 					'Blog Posts', 					'[project_theme_all_blog_posts]' );

		//----------------------------

		ProjectTheme_insert_pages('ProjectTheme_all_locations_page_id', 					'All Locations', 				'[project_theme_all_locations]' );
		ProjectTheme_insert_pages('ProjectTheme_all_categories_page_id', 					'All Categories', 				'[project_theme_all_categories]' );
		ProjectTheme_insert_pages('ProjectTheme_advanced_search_page_id', 					'Advanced Search', 				'[project_theme_advanced_search]' );
		ProjectTheme_insert_pages('ProjectTheme_provider_search_page_id', 					'Service Provider Search', 		'[project_theme_provider_search]' );

		//-------------------

		ProjectTheme_insert_pages('ProjectTheme_post_new_page_id', 					'Post New', 				'[project_theme_post_new]' );
		ProjectTheme_insert_pages('ProjectTheme_my_account_page_id', 				'My Account', 				'[project_theme_my_account_home]' );
		ProjectTheme_insert_pages('ProjectTheme_my_account_personal_info_id', 		'Personal Information', 	'[project_theme_my_account_personal_info]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_payments_id', 			'Finances', 				'[project_theme_my_account_payments]', 			get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_private_messages_id', 	'Private Messages', 		'[project_theme_my_account_private_messages]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_feedback_id', 			'Feedback/Reviews', 		'[project_theme_my_account_feedback]', 			get_option('ProjectTheme_my_account_page_id') );


		ProjectTheme_insert_pages('ProjectTheme_my_account_pay_for_project', 			'Pay for Project', 		'[project_theme_my_account_pay_for_project]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_pay_with_credits', 			'Virtual Cash Payment', 		'[project_theme_my_account_pay_with_credits]', 	get_option('ProjectTheme_my_account_page_id') );

		//--------------

		ProjectTheme_insert_pages('ProjectTheme_my_account_won_projects_id', 			"Projects I've Won", 		'[project_theme_my_account_won_projects]', 			get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_bid_projects_id', 			"Projects I've Bid", 		'[project_theme_my_account_bid_projects]', 			get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_delivered_projects_id', 		"Delivered Projects", 		'[project_theme_my_account_delivered_projects]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_outstanding_projects_id', 	"Outstanding Projects", 	'[project_theme_my_account_outstanding_projects]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_awaiting_payments_id', 		"Awaiting Payments", 		'[project_theme_my_account_awaiting_payments]', 	get_option('ProjectTheme_my_account_page_id') );



		//--------------



		ProjectTheme_insert_pages('ProjectTheme_my_account_active_projects_id', 			"Active Projects",  		'[project_theme_my_account_active_projects]', 		get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_closed_projects_id', 			"Closed Projects",  		'[project_theme_my_account_closed_projects]', 		get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_unpublished_projects_id', 		"Unpublished Projects",		'[project_theme_my_account_unpublish_projects]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_outstanding_payments_id', 		"Outstanding Payments",		'[project_theme_my_account_outstanding_payments]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_completed_payments_id', 			"Completed Payments", 		'[project_theme_my_account_completed_projects]', 	get_option('ProjectTheme_my_account_page_id') );
		ProjectTheme_insert_pages('ProjectTheme_my_account_awaiting_completion_id', 		"Awaiting Completion", 		'[project_theme_my_account_awaiting_completion]', 	get_option('ProjectTheme_my_account_page_id') );

		 //===========================================================================================================

		update_option('ProjectTheme_button1_caption', 'Post Your Project');
			update_option('ProjectTheme_button1_link', get_permalink(get_option('ProjectTheme_post_new_page_id')));

			update_option('ProjectTheme_button2_caption', 'Join Us. It`s free');
			update_option('ProjectTheme_button2_link', home_url() . '/wp-login.php?action=register');



			$ss = " CREATE TABLE `".$wpdb->prefix."project_ratings` (
					`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`pid` BIGINT NOT NULL DEFAULT '0',
					`fromuser` BIGINT NOT NULL DEFAULT '0',
					`touser` BIGINT NOT NULL DEFAULT '0',
					`comment` TEXT NOT NULL ,
					`grade` TINYINT NOT NULL DEFAULT '0',
					`datemade` BIGINT NOT NULL DEFAULT '0',
					`awarded` TINYINT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ";

			$wpdb->query($ss);

			//--------------------

			$ss = "CREATE TABLE `".$wpdb->prefix."project_pm` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`owner` INT NOT NULL DEFAULT '0',
					`user` INT NOT NULL DEFAULT '0',
					`content` TEXT NOT NULL ,
					`subject` TEXT NOT NULL ,
					`rd` TINYINT NOT NULL DEFAULT '0',
					`parent` BIGINT NOT NULL DEFAULT '0',
					`pid` INT NOT NULL DEFAULT '0' ,
					`datemade` INT NOT NULL DEFAULT '0',
					`readdate` INT NOT NULL DEFAULT '0',
					`initiator` INT NOT NULL DEFAULT '0',
					`attached` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);

			//---------------

			$ss = "CREATE TABLE `".$wpdb->prefix."project_bids` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`date_made` BIGINT NOT NULL DEFAULT '0',
			`bid` DOUBLE NOT NULL DEFAULT '0',
			`pid` BIGINT NOT NULL DEFAULT '0',
			`uid` BIGINT NOT NULL DEFAULT '0',
			`winner` TINYINT NOT NULL DEFAULT '0',
			`paid` TINYINT NOT NULL DEFAULT '0',
			`reserved1` VARCHAR( 255 ) NOT NULL DEFAULT '0',
			`date_choosen` BIGINT NOT NULL DEFAULT '0'
			) ENGINE = MYISAM ";

			$wpdb->query($ss);


			//----------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_packs` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`pack_name` VARCHAR( 255 ) NOT NULL ,
					`projects_number` INT NOT NULL DEFAULT '0' ,
					`pack_cost` VARCHAR( 255 ) NOT NULL ,
					`datemprojecte` VARCHAR( 255 ) NOT NULL DEFAULT '0' ,
					`featured_free` INT NOT NULL DEFAULT '0',
					`pause` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

		//------------------------------------------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_bidding_intervals` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`bidding_interval_name` VARCHAR( 255 ) NOT NULL ,
					`low_limit` INT NOT NULL ,
					`high_limit` VARCHAR( 255 ) NOT NULL
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

		//----------------------------------

			 $ss = " CREATE TABLE `".$wpdb->prefix."project_coupons` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`coupon_name` VARCHAR( 255 ) NOT NULL ,
					`coupon_solid_reduction` VARCHAR( 255 ) NOT NULL,
					`coupon_percent_reduction` VARCHAR( 255 ) NOT NULL,

					`ending` VARCHAR( 255 ) NOT NULL,
					`coupon_code` VARCHAR( 255 ) NOT NULL ,
					`datemprojecte` VARCHAR( 255 ) NOT NULL ,
					`featured_free` INT NOT NULL DEFAULT '0',
					`pause` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

			//-----------------------

			 		$ss = " CREATE TABLE `".$wpdb->prefix."project_custom_fields` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`name` VARCHAR( 255 ) NOT NULL ,
					`tp` VARCHAR( 48 ) NOT NULL ,
					`ordr` INT NOT NULL ,
					`cate` VARCHAR( 255 ) NOT NULL ,
					`pause` INT NOT NULL DEFAULT '1'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

		//-------------------
			 $ss = " CREATE TABLE `".$wpdb->prefix."project_custom_options` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`valval` VARCHAR( 255 ) NOT NULL ,
					`ordr` INT( 11 ) NOT NULL ,
					`custid` INT NOT NULL
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);



		//----------------------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_custom_relations` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`custid` BIGINT NOT NULL ,
					`catid` BIGINT NOT NULL
					) ENGINE = MYISAM ";
			$wpdb->query($ss);

		//-----------------------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_transactions` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`pid` BIGINT NOT NULL ,
					`datemprojecte` INT NOT NULL ,
					`uid` INT NOT NULL ,
					`payment_date` VARCHAR( 255 ) NOT NULL ,
					`txn_id` VARCHAR( 255 ) NOT NULL ,
					`item_name` VARCHAR( 255 ) NOT NULL ,
					`mc_currency` VARCHAR( 255 ) NOT NULL ,
					`last_name` VARCHAR( 255 ) NOT NULL ,
					`first_name` VARCHAR( 255 ) NOT NULL ,
					`payer_email` VARCHAR( 255 ) NOT NULL ,
					`projectdress_country` VARCHAR( 255 ) NOT NULL ,
					`projectdress_state` VARCHAR( 255 ) NOT NULL ,
					`projectdress_country_code` VARCHAR( 255 ) NOT NULL ,
					`projectdress_zip` VARCHAR( 255 ) NOT NULL ,
					`projectdress_street` VARCHAR( 255 ) NOT NULL ,
					`mc_fee` VARCHAR( 255 ) NOT NULL ,
					`mc_gross` VARCHAR( 255 ) NOT NULL
					) ENGINE = MYISAM ";

			$wpdb->query($ss);
		//-------$wpdb->query---------------------

		 $ss = " CREATE TABLE `".$wpdb->prefix."project_withdraw` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`datemade` INT NOT NULL ,
					`done` INT NOT NULL ,
					`datedone` INT NOT NULL ,
					`payeremail` VARCHAR( 255 ) NOT NULL ,
					`uid` INT NOT NULL ,
					`amount` DOUBLE NOT NULL
					) ENGINE = MYISAM ";
		$wpdb->query($ss);


		$ss = " CREATE TABLE `".$wpdb->prefix."project_escrow` (
				`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
				`fromid` INT NOT NULL ,
				`toid` INT NOT NULL ,
				`pid` INT NOT NULL ,
				`amount` DOUBLE NOT NULL ,
				`datemade` INT NOT NULL ,
				`releasedate` INT NOT NULL ,
				`released` TINYINT( 0 ) NOT NULL
				) ENGINE = MYISAM ";
		 $wpdb->query($ss);



		 $ss = " CREATE TABLE `".$wpdb->prefix."project_payment_transactions` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` INT NOT NULL ,
					`reason` TEXT NOT NULL ,
					`datemade` INT NOT NULL ,
					`amount` DOUBLE NOT NULL ,
					`tp` TINYINT NOT NULL DEFAULT '1',
					`uid2` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ";
		$wpdb->query($ss);



		//---------------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_custom_fields` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`name` VARCHAR( 255 ) NOT NULL ,
					`tp` VARCHAR( 48 ) NOT NULL ,
					`ordr` INT NOT NULL ,
					`cate` VARCHAR( 255 ) NOT NULL ,
					`pause` INT NOT NULL DEFAULT '1'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);
		//-------------------

		//-------------------
			 $ss = " CREATE TABLE `".$wpdb->prefix."project_custom_options` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`valval` VARCHAR( 255 ) NOT NULL ,
					`ordr` INT( 11 ) NOT NULL ,
					`custid` INT NOT NULL
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

		//----------------------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_custom_relations` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`custid` BIGINT NOT NULL ,
					`catid` BIGINT NOT NULL
					) ENGINE = MYISAM ";
			$wpdb->query($ss);


				global $wpdb;
				$sql_option_my = "ALTER TABLE  `".$wpdb->prefix."project_bids` ADD  `description` TEXT NOT NULL ;";
				$wpdb->query($sql_option_my);

				$sql_option_my = "ALTER TABLE  `".$wpdb->prefix."project_bids` ADD  `days_done` VARCHAR(255) NOT NULL ;";
				$wpdb->query($sql_option_my);


				$s = "ALTER TABLE `".$wpdb->prefix."project_pm` CHANGE `content` `content` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
												  CHANGE `subject` `subject` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";
				$wpdb->query($s);


				$s = "ALTER TABLE `".$wpdb->prefix."project_bids` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";
				$wpdb->query($s);

					$s = "ALTER TABLE `".$wpdb->prefix."project_ratings` CHANGE `comment` `comment` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";
				$wpdb->query($s);



			$ss = "CREATE TABLE `".$wpdb->prefix."project_email_alerts` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` INT NOT NULL ,
					`catid` INT NOT NULL
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);

			//-------------------------------------------

			$ss = "CREATE TABLE `".$wpdb->prefix."project_message_board` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` INT NOT NULL ,
					`content` TEXT NOT NULL ,
					`rd` TINYINT NOT NULL DEFAULT '0',
					`pid` INT NOT NULL ,
					`datemade` INT NOT NULL
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);

			$s = "ALTER TABLE `".$wpdb->prefix."project_message_board` CHANGE `content` `content` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";
			$wpdb->query($s);

			//---------------------------------------------------

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm` ADD  `show_to_source` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			//---------------------------

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm` ADD  `show_to_destination` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);



		//==================
	}

	$opt = get_option('ProjectTheme_upd138_ba');

	if(empty($opt) or isset($_GET['sitemile_reset_theme']))
	{


		update_option('ProjectTheme_slider_img_1', get_template_directory_uri() . '/images/sc1.jpg');
		update_option('ProjectTheme_slider_img_2', get_template_directory_uri() . '/images/sc2.jpg');
		update_option('ProjectTheme_slider_img_3', get_template_directory_uri() . '/images/sc3.jpg');
		update_option('ProjectTheme_slider_img_4', get_template_directory_uri() . '/images/sc4.jpg');
		update_option('ProjectTheme_slider_img_5', get_template_directory_uri() . '/images/sc5.jpg');


		global $wpdb;
		update_option('ProjectTheme_upd138_ba','y');

			$ss = " CREATE TABLE `".$wpdb->prefix."project_user_custom_fields` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`name` VARCHAR( 255 ) NOT NULL ,
					`tp` VARCHAR( 48 ) NOT NULL ,
					`ordr` INT NOT NULL ,
					`cate` VARCHAR( 255 ) NOT NULL ,
					`pause` INT NOT NULL DEFAULT '1'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

		//-------------------
			 $ss = " CREATE TABLE `".$wpdb->prefix."project_user_custom_options` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`valval` VARCHAR( 255 ) NOT NULL ,
					`ordr` INT( 11 ) NOT NULL ,
					`custid` INT NOT NULL
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

		//----------------------------

			$ss = " CREATE TABLE `".$wpdb->prefix."project_user_custom_relations` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`custid` BIGINT NOT NULL ,
					`catid` VARCHAR( 255 ) NOT NULL
					) ENGINE = MYISAM ";
			$wpdb->query($ss);

		//---------------------

		$ss = "ALTER TABLE `".$wpdb->prefix."project_custom_fields` ADD  `step_me` VARCHAR( 255 ) NOT NULL;";
		$wpdb->query($ss);

		$ss = "ALTER TABLE `".$wpdb->prefix."project_custom_fields` ADD  `content_box6` TEXT NOT NULL ;";
		$wpdb->query($ss);

	}


	$opt = get_option('ProjectTheme_upd138saa_bass001av');

	if(empty($opt) or isset($_GET['sitemile_reset_theme']))
	{
		global $wpdb;
		update_option('ProjectTheme_upd138saa_bass001av','y');

		$wpdb->query("ALTER TABLE `".$wpdb->prefix."project_withdraw` ADD `methods` VARCHAR( 255 ) NOT NULL ;");

		$ss = "ALTER TABLE `".$wpdb->prefix."project_withdraw` CHANGE  `methods`  `methods` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
		$wpdb->query($ss);


		$wpdb->query("ALTER TABLE `".$wpdb->prefix."project_pm` ADD `file_attached` VARCHAR( 255 ) NOT NULL ;");

		$ss = "ALTER TABLE `".$wpdb->prefix."project_pm` CHANGE  `file_attached`  `file_attached` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
		$wpdb->query($ss);


		$ss = "CREATE TABLE `".$wpdb->prefix."project_email_alerts_locs` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` INT NOT NULL ,
					`catid` INT NOT NULL
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);


				$s = "ALTER TABLE `".$wpdb->prefix."project_bidding_intervals` CHANGE `bidding_interval_name` `bidding_interval_name` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL  ";
				$wpdb->query($s);



		$sql_option_my = "ALTER TABLE  `".$wpdb->prefix."project_withdraw` ADD  `rejected` VARCHAR(255) NOT NULL DEFAULT '0';";
		$wpdb->query($sql_option_my);



			$ss = " CREATE TABLE `".$wpdb->prefix."project_workspace` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`pid` BIGINT NOT NULL NOT NULL ,
					`project_owner` VARCHAR( 48 ) NOT NULL ,
					`freelancer1` BIGINT NOT NULL ,
					`freelancer2` BIGINT NOT NULL  DEFAULT '0',
					`freelancer3` BIGINT NOT NULL  DEFAULT '0',
					`freelancer4` BIGINT NOT NULL DEFAULT '0' ,
					`freelancer5` BIGINT NOT NULL DEFAULT '0' ,
					`datemade` BIGINT NOT NULL ,
					`last_updated` BIGINT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);


			 		$ss = "CREATE TABLE `".$wpdb->prefix."project_workspace_pm` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`owner` INT NOT NULL DEFAULT '0',
					`user` INT NOT NULL DEFAULT '0',
					`content` TEXT NOT NULL ,
					`subject` TEXT NOT NULL ,
					`workspace_id` BIGINT NOT NULL DEFAULT '0',
					`pid` BIGINT NOT NULL DEFAULT '0' ,
					`datemade` INT NOT NULL DEFAULT '0',
					`readdate` INT NOT NULL DEFAULT '0',
					`attached` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);

			$s = "ALTER TABLE `".$wpdb->prefix."project_workspace_pm` CHANGE `content` `content` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
												  CHANGE `subject` `subject` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";


					$ss = " CREATE TABLE `".$wpdb->prefix."project_workspace_pm_reads` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`workspace_pm_id` BIGINT NOT NULL NOT NULL ,
					`read_message` INT NOT NULL DEFAULT '0' ,
					`receiver_user` BIGINT NOT NULL  DEFAULT '0',
					`read_date` BIGINT NOT NULL  DEFAULT '0'

					) ENGINE = MYISAM ";
			 $wpdb->query($ss);

			 ProjectTheme_insert_pages('ProjectTheme_my_account_workspaces_id', 	'Workspaces', 		'[project_theme_my_account_workspaces]', 	get_option('ProjectTheme_my_account_page_id') );

	}

	//---------------------------------------------------------

	$opt = get_option('ProjectTheme_upd408');

	if(empty($opt) or isset($_GET['sitemile_reset_theme']))
	{



				global $wpdb;


					$ss = "CREATE TABLE `".$wpdb->prefix."project_freelancer_skills` (
							`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							`uid` INT NOT NULL ,
							`catid` INT NOT NULL
							) ENGINE = MYISAM ;
							";
					$wpdb->query($ss);


		ProjectTheme_insert_pages('ProjectTheme_my_account_received_bids_id', 			"Received Offers",  		'[project_theme_my_account_received_bids]', 		get_option('ProjectTheme_my_account_page_id') );

				$ss = "CREATE TABLE `".$wpdb->prefix."project_pm_wk` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`owner` INT NOT NULL DEFAULT '0',
					`user` INT NOT NULL DEFAULT '0',
					`content` TEXT NOT NULL ,
					`subject` TEXT NOT NULL ,
					`rd` TINYINT NOT NULL DEFAULT '0',
					`parent` BIGINT NOT NULL DEFAULT '0',
					`pid` INT NOT NULL DEFAULT '0' ,
					`datemade` INT NOT NULL DEFAULT '0',
					`readdate` INT NOT NULL DEFAULT '0',
					`initiator` INT NOT NULL DEFAULT '0',
					`attached` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);


				$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_wk` ADD  `approved` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_wk` ADD  `approved_on` BIGINT NOT NULL DEFAULT '0';";
			$wpdb->query($ss);


			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_wk` ADD  `show_to_source` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			//---------------------------

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_wk` ADD  `show_to_destination` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

				$wpdb->query("ALTER TABLE `".$wpdb->prefix."project_pm_wk` ADD `file_attached` VARCHAR( 255 ) NOT NULL ;");

		$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_wk` CHANGE  `file_attached`  `file_attached` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL";
		$wpdb->query($ss);



		update_option('ProjectTheme_upd408','y');

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm` ADD  `approved` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm` ADD  `approved_on` BIGINT NOT NULL DEFAULT '0';";
			$wpdb->query($ss);

			$ss = "ALTER TABLE `".$wpdb->prefix."project_custom_fields` ADD  `is_mandatory` TINYINT NOT NULL DEFAULT '0';";
			$wpdb->query($ss);

		//-----------------------------------------------

		ProjectTheme_insert_pages('ProjectTheme_all_projects_page_id', 					'All Posted Projects', 		'[project_theme_all_projects]' );

		$ss = " CREATE TABLE `".$wpdb->prefix."project_disputes` (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`uid` BIGINT NOT NULL NOT NULL ,
		`pid` BIGINT NOT NULL DEFAULT '0' ,
		`closed` BIGINT NOT NULL  DEFAULT '0',
		`solved` BIGINT NOT NULL  DEFAULT '0' ,
		`datemade` BIGINT NOT NULL  DEFAULT '0',
		`dateclosed` BIGINT NOT NULL  DEFAULT '0',
		`datesolved` BIGINT NOT NULL  DEFAULT '0',
		`content` TEXT NOT NULL ,
			`subject` TEXT NOT NULL

		) ENGINE = MYISAM ";
 //$wpdb->query($ss);

 $ss = "ALTER TABLE `".$wpdb->prefix."project_disputes` ADD  `uid2` BIGINT NOT NULL DEFAULT '0';";
 //$wpdb->query($ss);



			$ss = "CREATE TABLE `".$wpdb->prefix."project_pm_threads` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`user1` BIGINT NOT NULL DEFAULT '0',
					`user2` BIGINT NOT NULL DEFAULT '0',

					`datemade` BIGINT NOT NULL DEFAULT '0',
					`lastupdate` BIGINT NOT NULL DEFAULT '0',
					`pid` BIGINT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);


			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm` ADD  `threadid` BIGINT NOT NULL DEFAULT '0';";
			$wpdb->query($ss);


			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_threads` ADD  `show_to_user1` BIGINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_threads` ADD  `show_to_user2` BIGINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_threads` ADD  `admin_approved` BIGINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);

			$ss = "ALTER TABLE `".$wpdb->prefix."project_pm_threads` ADD  `message_title` TEXT NOT NULL ;";
			$wpdb->query($ss);

	}





?>
