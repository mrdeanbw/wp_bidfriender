<?php

	$opt = get_option('ProjectTheme_new_emails_135');
	if(empty($opt)):

		update_option('ProjectTheme_new_emails_135', 'DonE');

		update_option('ProjectTheme_new_user_email_subject', 'Welcome to ##your_site_name##');
		update_option('ProjectTheme_new_user_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																'Welcome to our website.'.PHP_EOL.
																'Your username: ##username##'.PHP_EOL.
																'Your password: ##user_password##'.PHP_EOL.PHP_EOL.
																'Login here: ##site_login_url##' .PHP_EOL.PHP_EOL.
																'Activation Link: ##activation_link##' .PHP_EOL.PHP_EOL.
																'Thank you,'.PHP_EOL.
																'##your_site_name## Team');  

		//-----------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_new_user_email_admin_subject', 'New user registration on your site');
		update_option('ProjectTheme_new_user_email_admin_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
																	'A new user has been registered on your website.'.PHP_EOL.
																	'See the details below:'.PHP_EOL.PHP_EOL.
																	'Username: ##username##'.PHP_EOL.
																	'Email: ##user_email##');

		//------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_new_project_email_approve_admin_subject', 'New project posted: ##project_name##');
		update_option('ProjectTheme_new_project_email_approve_admin_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
																				'The user ##username## has posted a new project on your website.'.PHP_EOL.
																				'The project name: [##project_name##]'.PHP_EOL.
																				'The project was automatically approve on your website.'.PHP_EOL.PHP_EOL.
																				'View the project here: ##project_link##'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_new_project_email_not_approve_admin_subject', 'New project posted. Must approve ##project_name##');
		update_option('ProjectTheme_new_project_email_not_approve_admin_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
																			'The user ##username## has posted a new project on your website.'.PHP_EOL.
																			'The project name: <b>##project_name##</b> '.PHP_EOL.
																			'The project is not automatically approved so you have to manually approve the project before it appears on your website.'.PHP_EOL.PHP_EOL.
																			'You can approve the project by going to your admin dashboard in your website'.PHP_EOL.
																			'Go here: ##your_site_url##/wp-admin');

		//------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_new_project_email_not_approved_subject', 'Your new project posted, but not yet approved: ##project_name##');
		update_option('ProjectTheme_new_project_email_not_approved_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																			'Your project <b>##project_name##</b> has been posted on the website. However it is not live yet.'.PHP_EOL.
																			'The project needs to be approved by the admin before it goes live. '.PHP_EOL.
																			'You will be notified by email when the project is active and published.'.PHP_EOL.PHP_EOL.
																			'After is approved the project will appear here: ##project_link##'.PHP_EOL.PHP_EOL.
																			'Thank you,'.PHP_EOL.
																			'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_new_project_email_approved_subject', 'Your new project posted, and approved: ##project_name##');
		update_option('ProjectTheme_new_project_email_approved_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'Your project <b>##project_name##</b> has been posted on the website.'.PHP_EOL.
																				'The project is live and you can see it here: ##project_link##'.PHP_EOL.
																				'Also you can check your project offers here: ##my_account_url##'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_bid_project_owner_email_subject', 'Your have received a new bid to your project: ##project_name##');
		update_option('ProjectTheme_bid_project_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have received a new bid to your project <a href="##project_link##"><b>##project_name##</b></a>.'.PHP_EOL.
																				'See your bid details below:'.PHP_EOL.PHP_EOL.
																				'Bidder Username: ##bidder_username##'.PHP_EOL.
																				'Bid Value: ##bid_value##'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------


		update_option('ProjectTheme_bid_project_bidder_email_subject', 'Your has been posted to the project: ##project_name##');
		update_option('ProjectTheme_bid_project_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You posted a new bid to the project <a href="##project_link##"><b>##project_name##</b></a>.'.PHP_EOL.
																				'See your bid details below:'.PHP_EOL.PHP_EOL.
																				'Project Link: ##project_link##'.PHP_EOL.
																				'Bid Value: ##bid_value##'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_won_project_loser_email_subject', 'The project: ##project_name## has ended. You did not win.');
		update_option('ProjectTheme_won_project_loser_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The project: <a href="##project_link##"><b>##project_name##</b></a> has ended.'.PHP_EOL.
																				'Sorry, you did not win. See won project details below:'.PHP_EOL.PHP_EOL.
																				'Project Link: ##project_link##'.PHP_EOL.
																				'Winner Bid Value: ##winner_bid_value##'.PHP_EOL.
																				'Winner Username: ##winner_bid_username##'.PHP_EOL.
																				'Your bid on this project: ##user_bid_value##'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_won_project_winner_email_subject', 'The project: ##project_name## has ended. You are the winner!');
		update_option('ProjectTheme_won_project_winner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The project: <a href="##project_link##"><b>##project_name##</b></a> has ended.'.PHP_EOL.
																				'You just wont it. See won project details below:'.PHP_EOL.PHP_EOL.
																				'Project Link: ##project_link##'.PHP_EOL.
																				'Winner Bid Value: ##winner_bid_value##'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_won_project_owner_email_subject', 'Your have selected a winner for your project: ##project_name##.');
		update_option('ProjectTheme_won_project_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'Your project: <a href="##project_link##"><b>##project_name##</b></a>
																				has ended.'.PHP_EOL.
																				'You just selected a winner for it.
																				See won project details below:'.PHP_EOL.PHP_EOL.
																				'Project Link: ##project_link##'.PHP_EOL.
																				'Winner Bidder Username: ##winner_bid_username##'.PHP_EOL.
																				'Winner Bid Value: ##winner_bid_value##'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_rated_user_email_subject', 'Your were just rated for the project: ##project_name##.');
		update_option('ProjectTheme_rated_user_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have received a rating for the project:
																				<a href="##project_link##"><b>##project_name##</b></a>.'.PHP_EOL.
																				'See rating details below:'.PHP_EOL.PHP_EOL.
																				'Project Link: ##project_link##'.PHP_EOL.
																				'Rating: ##rating##'.PHP_EOL.
																				'Comment: ##comment##'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_priv_mess_received_email_subject', 'Your have received a private message from user: ##sender_username##.');
		update_option('ProjectTheme_priv_mess_received_email_message', 'Hello ##receiver_username##,'.PHP_EOL.PHP_EOL.
																				'You have received a private message from <b>##sender_username##</b>'.PHP_EOL.
																				'To read it, just login to your account: ##my_account_url##'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_completed_project_owner_email_subject', 'Project marked as completed by provider: ##project_name##.');
		update_option('ProjectTheme_completed_project_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The provider/winner of this project has marked it as completed <b>##project_name##</b> ( ##project_link## )'.PHP_EOL.
																				'To check the project out and accept it go to your account area: ##my_account_url##'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_completed_project_bidder_email_subject', 'You completed the project: ##project_name##.');
		update_option('ProjectTheme_completed_project_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have just marked the following project as completed: <b>##project_name##</b> ( ##project_link## )'.PHP_EOL.
																				'You will be notified when the project owner will accept your project.'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_delivered_project_bidder_email_subject', 'Project marked delivered and accepted by the owner: ##project_name##.');
		update_option('ProjectTheme_delivered_project_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The owner of the project: <b>##project_name##</b> ( ##project_link## ) has accepted and marked it as delivered.'.PHP_EOL.
																				'You will be notified when the owner pays the project fee.'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.

																				'##your_site_name## Team');

		//--------------------------------------------------------------------------------------------------------------

		update_option('ProjectTheme_delivered_project_owner_email_subject', 'Your project accepted as delivered: ##project_name##.');
		update_option('ProjectTheme_delivered_project_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have just accepted as delivered your project: <b>##project_name##</b> ( ##project_link## ).'.PHP_EOL.
																				'You need to login into your account area and pay the project fee.'.PHP_EOL.
																				'Login here: ##my_account_url##'.PHP_EOL.PHP_EOL.

																				'Thank you,'.PHP_EOL.

																				'##your_site_name## Team');

	endif;



	$opt = get_option('ProjectTheme_new_emails_138');
	if(empty($opt)):

	update_option('ProjectTheme_new_emails_138', 'DonE');

	update_option('ProjectTheme_subscription_email_subject', 'Project matching your criteria: ##project_name##.');
		update_option('ProjectTheme_subscription_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'A new project that matches your criteria has been posted: <b>##project_name##</b> ( ##project_link## ).'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.

																				'##your_site_name## Team');

	//----------------------------------------------------

	update_option('ProjectTheme_message_board_owner_email_subject', 'New message on project message board: ##project_name##.');
	update_option('ProjectTheme_message_board_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The user ##message_owner_username## has posted a new message on the project message board.'.PHP_EOL.
																				'You can check the message here: <b>##project_name##</b> ( ##project_link## )'.	PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

	//----------------------------------------------------

	update_option('ProjectTheme_message_board_bidder_email_subject', 'New message on project message board: ##project_name##.');
	update_option('ProjectTheme_message_board_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The project owner (##project_username##) has posted a reply on the project message board.'.PHP_EOL.
																				'You can check the answer out here: <b>##project_name##</b> ( ##project_link## )'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');

	endif;

	$opt = get_option('ProjectTheme_new_emails_14a9');
	if(empty($opt)):

	update_option('ProjectTheme_new_emails_14a9', 'DonE');

		update_option('ProjectTheme_payment_on_completed_project_subject', 'Your paid for the project: ##project_name##');
		update_option('ProjectTheme_payment_on_completed_project_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have paid the winning bid for your project <a href="##project_link##"><b>##project_name##</b></a>.'.PHP_EOL.
																				'See your payment details below:'.PHP_EOL.PHP_EOL.
																				'Bidder Username: ##bidder_username##'.PHP_EOL.
																				'Bid Value: ##bid_value##'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');




																				update_option('ProjectTheme_escrow_project_owner_email_subject', 'Escrow was sent for this project: ##project_name##.');
update_option('ProjectTheme_escrow_project_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																		'You have sent an escrow payment for this project <b>##project_name##</b> ( ##project_link## )'.PHP_EOL.
																		'Amount of escrow <b>##escrow_amount##</b>  '.PHP_EOL.
																		'To check the project out and accept it go to your account area: ##my_account_url##'.PHP_EOL.PHP_EOL.

																		'Thank you,'.PHP_EOL.
																		'##your_site_name## Team');


update_option('ProjectTheme_escrow_project_bidder_email_subject', 'Escrow received for this project: ##project_name##.');
update_option('ProjectTheme_escrow_project_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																		'You have received an escrow payment for this project <b>##project_name##</b> ( ##project_link## )'.PHP_EOL.
																		'Amount of escrow <b>##escrow_amount##</b>  '.PHP_EOL.
																		'To check the project out and accept it go to your account area: ##my_account_url##'.PHP_EOL.PHP_EOL.

																		'Thank you,'.PHP_EOL.
																		'##your_site_name## Team');



																		update_option('ProjectTheme_withdrawal_completed_user_email_subject', 'Your withdrawal request was completed: ##withdrawal_method##.');
																		update_option('ProjectTheme_withdrawal_completed_user_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																																				'Your withdrawal request was processed. See the details below: '.PHP_EOL.
																																				'Amount: <b>##withdrawal_amount##</b>  '.PHP_EOL.
																																				'Method: <b>##withdrawal_method##</b>'.PHP_EOL.PHP_EOL.

																																				'Thank you,'.PHP_EOL.
																																				'##your_site_name## Team');


update_option('ProjectTheme_withdrawal_requested_admin_email_subject', 'Withdrawal requested on your website: ##withdrawal_method##.');
update_option('ProjectTheme_withdrawal_requested_admin_email_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
		'There was a withdrawal request on your website. See the details below: '.PHP_EOL.

		'Username: <b>##username##</b>  '.PHP_EOL.
		'Amount: <b>##withdrawal_amount##</b>  '.PHP_EOL.
		'Method: <b>##withdrawal_method##</b>'.PHP_EOL.PHP_EOL.

		'Thank you,'.PHP_EOL.
		'##your_site_name## Team');




	update_option('ProjectTheme_withdrawal_requested_user_email_subject', 'You have requested a new withdrawal: ##withdrawal_method##.');
	update_option('ProjectTheme_withdrawal_requested_user_email_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
			'There was a withdrawal request on your website. See the details below: '.PHP_EOL.

			'Username: <b>##username##</b>  '.PHP_EOL.
			'Amount: <b>##withdrawal_amount##</b>  '.PHP_EOL.
			'Method: <b>##withdrawal_method##</b>'.PHP_EOL.PHP_EOL.

			'Thank you,'.PHP_EOL.
			'##your_site_name## Team');

		endif;

?>
