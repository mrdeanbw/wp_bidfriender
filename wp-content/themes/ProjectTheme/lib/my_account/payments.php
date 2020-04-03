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


function ProjectTheme_my_account_payments_area_function()
{

		global $current_user, $wpdb, $wp_query;
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;


					do_action('pt_for_demo_work_3_0');

					pt_account_main_menu_new();


?>

<div class="row">

      <?php ProjectTheme_get_users_links(); ?>

<div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-8">
<?php

			$ProjectTheme_payment_model = get_option('ProjectTheme_payment_model');
			if($ProjectTheme_payment_model == "marketplace_gateways")
			{

						// gateways like stripe connect and mangopay, and maybe others who knows ?

						$gateways = 0;

						if(function_exists('ptt_stripe_connect_mss')) $gateways++;
						if(function_exists('ptt_mangopay_mss')) 	$gateways++;

						//----------------------------


						?>



						<?php

								if($gateways == 0)
								{
									 ?>

									 			<div class="error">There is an error, you have enabled direct payment model and you dont have any gateway enabled for this model (stripe connect, mangopay or others).
													You either need to activate these extensions/plugins or purchase the <a href="https://sitemile.com/p/project">pro version</a> of the project theme if you havent done that already.
													You can also <a href="https://sitemile.com">contact us</a> about this issue.</div>

									 <?php
								}

						?>


						<?php
			}
			elseif($ProjectTheme_payment_model == "invoice_model_pay_outside")
			{
					?>

					<h3 class="my-account-headline-1"><?php echo __('Due Invoices/Payments','ProjectTheme'); ?></h3>
					<div class="card">


						<div class="box_content">

										<div class="padd20">	<?php _e('There are no due invoices yet.','ProjectTheme'); ?></div>

						</div>
					</div>



					<?php


			}
			else {



 ?>
            <?php





			$pg = $_GET['pg'];
			if(!isset($pg)) $pg = 'home';

			global $wpdb;

			if($_GET['pg'] == 'closewithdrawal')
					{
						$id = $_GET['id'];

						$s = "select * from ".$wpdb->prefix."project_withdraw where id='$id' AND uid='$uid'";
						$r = $wpdb->get_results($s);

						if(count($r) == 1)
						{
							$row = $r[0];
							$amount = $row->amount;

							$cr = projectTheme_get_credits($uid);
							projectTheme_update_credits($uid, $cr + $amount);

							$s = "delete from ".$wpdb->prefix."project_withdraw where id='$id' AND uid='$uid'";
							$wpdb->query($s);

							echo '<div class="">';
							echo sprintf(__('Request canceled! <a href="%s">Return to payments</a>.','ProjectTheme'), get_permalink(get_option('ProjectTheme_my_account_payments_id')) );
							echo '</div>';
						}
					}


					if($_GET['pg'] == 'releasepayment')
					{
						$id = $_GET['id'];

						$s = "select * from ".$wpdb->prefix."project_escrow where id='$id' AND fromid='$uid'";
						$r = $wpdb->get_results($s);

						if(count($r) == 1 and $r[0]->released != 1)
						{
							$row = $r[0];
							$amount = $row->amount;
							$toid = $row->toid;
							$pid = $row->pid;
							$my_pst = get_post($pid);

							$projectTheme_get_winner_bid = projectTheme_get_winner_bid($pid);
							ProjectTheme_send_email_when_on_completed_project($pid, $projectTheme_get_winner_bid->uid, $projectTheme_get_winner_bid->bid);

							//-------------------------------------------------------------------------------

							$projectTheme_fee_after_paid = get_option('projectTheme_fee_after_paid');
							if(!empty($projectTheme_fee_after_paid)):

								$deducted = $amount*($projectTheme_fee_after_paid * 0.01);
							else:

								$deducted = 0;

							endif;


							//-------------------------------------------------------------------------------

							$cr = projectTheme_get_credits($toid);
							projectTheme_update_credits($toid, $cr + $amount - $deducted);

							$reason = sprintf(__('Escrow payment received from %s for the project <b>%s</b>','ProjectTheme'), $current_user->user_login, $my_pst->post_title);
							projectTheme_add_history_log('1', $reason, $amount, $toid, $uid);


							if($deducted > 0)
							$reason = sprintf(__('Payment fee for project %s','ProjectTheme'), $my_pst->post_title);
							projectTheme_add_history_log('0', $reason, $deducted, $toid );

							//-----------------------------
							$email 		= get_bloginfo('admin_email');
							$site_name 	= get_bloginfo('name');

							$usr = get_userdata($uid);

							$subject = __("Money Escrow Completed",'ProjectTheme');
							$message = sprintf(__("You have released the escrow of: %s","ProjectTheme"), ProjectTheme_get_show_price($amount));

							//($usr->user_email, $subject , $message);

							//-----------------------------

							$usr = get_userdata($toid);

							$reason = sprintf(__('Escrow Payment completed, sent to %s for project <b>%s</b>','ProjectTheme'), $usr->user_login, $my_pst->post_title);
							projectTheme_add_history_log('0', $reason, $amount, $uid, $toid);

							$subject = __("Money Escrow Completed","ProjectTheme");
							$message = sprintf(__("You have received the amount of: %s","ProjectTheme"), ProjectTheme_get_show_price($amount));

							//($usr->user_email, $subject , $message);

							//-----------------------------
							$tm = current_time('timestamp',0);

							update_post_meta($pid,'paid_user','1');
							update_post_meta($pid,'paid_user_date',current_time('timestamp',0));

							$s = "update ".$wpdb->prefix."project_escrow set released='1', releasedate='$tm' where id='$id'";
							$r = $wpdb->query($s);


						}

						echo __('Escrow completed! Redirecting...','ProjectTheme'); echo '<br/><br/>';

						$url_redir = ProjectTheme_get_payments_page_url();
						echo '<meta http-equiv="refresh" content="2;url='.$url_redir.'" />';

					}



			$ProjectTheme_enable_credits_wallet = get_option('ProjectTheme_enable_credits_wallet');
			if($ProjectTheme_enable_credits_wallet != 'no'):

			if($pg == 'home'):


					do_action('ProjectTheme_before_payments_in_payments');

			?>


						<h3 class="my-account-headline-1"><?php echo __('Finances','ProjectTheme'); ?></h3>
            <div class="card">


            	<div class="padd20">



                <?php
				$bal = projectTheme_get_credits($uid);
				echo '<span class="balance">'.__("Your Current Balance is", "ProjectTheme").": ".ProjectTheme_get_show_price($bal,2)."</span>";


				?>



            </div>
            </div>




							<h3 class="my-account-headline-1"><?php echo __('What do you want to do','ProjectTheme'); ?></h3>
            <div class="card">



            	<div class="padd20">

                <ul class="cms_cms">

               <li> <a href="<?php echo ProjectTheme_get_payments_page_url('deposit'); ?>"  class="btn btn-dark btn-sm" role="button"><?php _e('Deposit Money','ProjectTheme'); ?></a>  </li>
							 <?php $ProjectTheme_enable_credits_direct = get_option('ProjectTheme_enable_credits_direct');


							 		if($ProjectTheme_enable_credits_direct == "yes")
									{

							 ?>
              <li>  <a href="<?php echo ProjectTheme_get_payments_page_url('makepayment'); ?>" class="btn btn-dark btn-sm" role="button"><?php _e('Make Payment','ProjectTheme'); ?></a> </li> <?php } ?>

                <?php if(ProjectTheme_is_user_business($uid)): ?>
              <!-- <li> <a href="<?php echo ProjectTheme_get_payments_page_url('escrow'); ?>" class="green_btn old_mm_k"><?php _e('Deposit Escrow','ProjectTheme'); ?></a> </li> -->
                <?php endif; ?>

               <li> <a href="<?php echo ProjectTheme_get_payments_page_url('withdraw'); ?>"  class="btn btn-dark btn-sm" role="button"><?php _e('Withdraw Money','ProjectTheme'); ?></a> </li>
               <li> <a href="<?php echo ProjectTheme_get_payments_page_url('transactions'); ?>"  class="btn btn-dark btn-sm" role="button"><?php _e('Transactions','ProjectTheme'); ?></a></li>

							 <?php

									$f = get_option('ProjectTheme_bank_details_enable');
									if($f == "yes")
									{

							  ?>
							 <li> <a href="<?php echo ProjectTheme_get_payments_page_url('bktransfer'); ?>"  class="btn btn-dark btn-sm" role="button"><?php _e('Bank Transfer Details','ProjectTheme'); ?></a>   </li>
						 <?php } ?>


                  <?php do_action('ProjectTheme_financial_buttons_main') ?>

              	</ul>

            </div>
            </div>

            <!-- ###################### -->



<h3 class="my-account-headline-1"><?php echo __('Pending Withdrawals','ProjectTheme'); ?></h3>
            <div class="card">



            	<div class="padd20">


         				<?php

					global $wpdb;

					//----------------

					$s = "select * from ".$wpdb->prefix."project_withdraw where done='0' and rejected!='1' AND uid='$uid' order by id desc";
					$r = $wpdb->get_results($s);

					if(count($r) == 0) echo __('No withdrawals pending yet.','ProjectTheme');
					else
					{
						echo '<table width="100%" class="da_table_done">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{


							echo '<tr>';
							echo '<td>'.date_i18n('d-M-Y g:i A', $row->datemade).'</td>';
							echo '<td>'.ProjectTheme_get_show_price($row->amount).'</td>';
							echo '<td>'.$row->methods .'</td>';
							echo '<td>'.$row->payeremail .'</td>';
							echo '<td><a href="'.ProjectTheme_get_payments_page_url('closewithdrawal', $row->id).'"
							class="green_btn">'.__('Close Request','ProjectTheme'). '</a></td>';
							echo '</tr>';


						}
						echo '</table>';

					}

				?>


            </div>
            </div>





<h3 class="my-account-headline-1"><?php echo __('Rejected Withdrawals','ProjectTheme'); ?></h3>
            <div class="card">




            	<div class="padd20">


         				<?php

					global $wpdb;

					//----------------

					$s = "select * from ".$wpdb->prefix."project_withdraw where done='0' and rejected='1' AND uid='$uid' order by id desc";
					$r = $wpdb->get_results($s);

					if(count($r) == 0) echo __('No rejected withdrawals yet.','ProjectTheme');
					else
					{
						echo '<table width="100%" class="da_table_done">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{


							echo '<tr>';
							echo '<td>'.date_i18n('d-M-Y g:i A', $row->datemade).'</td>';
							echo '<td>'.ProjectTheme_get_show_price($row->amount).'</td>';
							echo '<td>'.$row->methods .'</td>';
							echo '<td>'.$row->payeremail .'</td>';
							echo '<td> </td>';
							echo '</tr>';


						}
						echo '</table>';

					}

				?>


            </div>
            </div>


           <!-- ###################### -->



<h3 class="my-account-headline-1"><?php echo __('Pending Incoming Payments','ProjectTheme'); ?></h3>
            <div class="card">


            	<div class="padd20">


   				<?php

					$s = "select * from ".$wpdb->prefix."project_escrow where released='0' AND toid='$uid' order by id desc";
					$r = $wpdb->get_results($s);

					if(count($r) == 0) echo __('No payments pending yet.','ProjectTheme');
					else
					{
						echo '<table width="100%"  class="da_table_done">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{
							$post = get_post($row->pid);
							$from = get_userdata($row->fromid);

							echo '<tr>';
							echo '<td>'.$from->user_login.'</td>';
							echo '<td>'.$post->post_title.'</td>';
							echo '<td>'.date_i18n('d-M-Y g:i A', $row->datemade).'</td>';
							echo '<td>'.ProjectTheme_get_show_price($row->amount).'</td>';

							echo '</tr>';


						}
						echo '</table>';

					}

				?>


            </div>
            </div>


                    <!-- ###################### -->

                   <?php if(ProjectTheme_is_user_business($uid)): ?>





												<h3 class="my-account-headline-1"><?php echo __('Pending Outgoing Payments','ProjectTheme'); ?></h3>
            <div class="card">



            	<div class="padd20">


      				<?php

					$s = "select * from ".$wpdb->prefix."project_escrow where released='0' AND fromid='$uid' order by id desc";
					$r = $wpdb->get_results($s);

					if(count($r) == 0) echo __('No payments pending yet.','ProjectTheme');
					else
					{
						echo '<table width="100%"  class="da_table_done">';

						echo '<tr>';
							echo '<td><b>'.__('User','ProjectTheme').'</b></td>';
							echo '<td><b>'.__('Project','ProjectTheme').'</b></td>';
							echo '<td><b>'.__('Date','ProjectTheme').'</b></td>';
							echo '<td><b>'.__('Amount','ProjectTheme').'</b></td>';
							echo '<td><b>'.__('Options','ProjectTheme').'</b></td>';

							echo '</tr>';


						foreach($r as $row) // = mysql_fetch_object($r))
						{
							$post = get_post($row->pid);
							$from = get_userdata($row->toid);

							echo '<tr>';
							echo '<td><a href="'.ProjectTheme_get_user_profile_link($from->ID).'">'.$from->user_login.'</a></td>';
							echo '<td><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></td>';
							echo '<td>'.date_i18n('d-M-Y g:i A', $row->datemade).'</td>';
							echo '<td>'.ProjectTheme_get_show_price($row->amount).'</td>';
							echo '<td><a href="'.ProjectTheme_get_payments_page_url('releasepayment', $row->id).'" class="btn btn-outline-success" role="button">'.__('Release Payment','ProjectTheme').'</a></td>';

							echo '</tr>';


						}
						echo '</table>';

					}

				?>


            </div>
            </div> <?php endif; ?>
        <?php
			elseif($pg == 'escrow'):
		?>


		<?php do_action('pt_escrow_screen_thing') ?>

<h3 class="my-account-headline-1"><?php echo __('Make Escrow Payment','ProjectTheme'); ?></h3>
        <div class="card">


            	<div class="padd20">



                <?php

				$bal = projectTheme_get_credits($uid);


				if(isset($_POST['escrowme']))
				{
					$amount 	= $_POST['amount'];
					$projects 	= $_POST['projectss'];

					$projectTheme_tax_fee_paypal_deposit = get_option('projectTheme_tax_fee_paypal_deposit');
					if($projectTheme_tax_fee_paypal_deposit > 0)
					{

							$fee = round(0.01*$amount*$projectTheme_tax_fee_paypal_deposit, 2);

						} else $fee = 0;


					if(!is_numeric($amount) || $amount < 0)
					{
						echo '<div class="newproject_error">'.__('Provide a well formated amount.','ProjectTheme').'</div>';

					}
					else if(empty($projects))
					{
						echo '<div class="newproject_error">'.__('Please choose an project.','ProjectTheme').'</div>';
					}
					else
					{
						if($bal < ($amount + $fee))
						{
							echo '<div class="newproject_error">'.__('Your balance is smaller than the amount requested.','ProjectTheme').'</div>';
						}
						else
						{
							$post 	= get_post($projects);
							$uid2   = get_post_meta($projects, "winner", true);

							$tm = $_POST['tm'];
							if(empty($tm)) $tm = current_time('timestamp',0);


							if($post->post_author != $uid)
								$uid2 = $post->post_author;





							//-----------------------
							$email 		= get_bloginfo('admin_email');
							$site_name 	= get_bloginfo('name');

							$usr = get_userdata($uid);

							$subject = __("Money Escrow Sent","ProjectTheme");
							$message = sprintf(__("You have placed in escrow the amount of: %s to user:
							<b>%s</b>","ProjectTheme"),ProjectTheme_get_show_price($amount) ,$username);

							//($usr->user_email, $subject , $message);

							$s = "select * from ".$wpdb->prefix."project_escrow where datemade='$tm' and fromid='$uid'";
							$rr = $wpdb->get_results($s);

							if(count($rr) == 0)
							{

								$s = "insert into ".$wpdb->prefix."project_escrow (datemade, amount, fromid, toid, pid)
								values('$tm','$amount','$uid','$uid2','$projects')";
								$wpdb->query($s);

									// for logged in user, the user who sends
									//======================================================
									$cr = projectTheme_get_credits($uid);
									projectTheme_update_credits($uid, $cr - $amount);

									if($fee > 0)
									{
											$cr = projectTheme_get_credits($uid);
											projectTheme_update_credits($uid, $cr - $fee);

											$projects_obj = get_post($projects);

											$reason = sprintf(__("Amount fee for escrow for project %s","ProjectTheme"), $projects_obj->post_title);
											projectTheme_add_history_log('0', $reason, $fee, $uid);

									}

							}
							//======================================================

							// for other user, the user who receives
							//======================================================



							$usr2 = get_userdata($uid2);

							$subject = __("Money Escrow Received","ProjectTheme");
							$message = sprintf(__("You have received in escrow the amount of: %s from user: <b>%s</b>","ProjectTheme"),
							ProjectTheme_get_show_price($amount),$usr->user_login);

							//($usr2->user_email, $subject , $message);


							//======================================================

							echo '<div class="saved_thing">'.__('Your payment has been processed. Redirecting to my account...','ProjectTheme').'</div>';
							$url_redir = get_permalink(get_option('ProjectTheme_my_account_payments_id'));
							echo '<meta http-equiv="refresh" content="2;url='.$url_redir.'" />';
						}

					}

				}


				$bal = projectTheme_get_credits($uid);
			//	echo '<span class="balance">'.sprintf(__('Your Current Balance is: %s','ProjectTheme'), ProjectTheme_get_show_price($bal))."</span>";
				//echo '&nbsp; <a class="post_bid_btn" href="'.ProjectTheme_get_payments_page_url_redir('deposit').'">'.__('Add More Credits','ProjectTheme').'</a>';
				//echo "<br/><br/>";

				?>

                <script>

				function on_proj_sel()
				{
					var sel_value = jQuery("#my_proj_sel").val();

					jQuery.post("<?php echo esc_url( home_url() )  ?>/?get_my_project_vl_thing=1", {queryString: ""+sel_value+""}, function(data){
						if(data.length >0) {

							var currency = '<?php echo ProjectTheme_get_currency() ?>';
							jQuery("#my_escrow_amount").html(currency  + data);
							jQuery("#amount").val(data);


						}
					});



				}

				<?php

					if(!empty($_GET['poid']))
					{
						?>
						jQuery(function() {
							  on_proj_sel();
							});

						<?php
					}

				?>


				</script>


					<?php

					$poid = $_GET['poid'];
					$bid = projectTheme_get_winner_bid($poid); $bid2 = $bid;
					$bid = projecttheme_get_show_price($bid->bid);

					$credits = projectTheme_get_credits(get_current_user_id());

					if($_GET['poid'] > 0)
					{
							$ProjectTheme_paypal_enable = get_option('ProjectTheme_paypal_enable');
							if($ProjectTheme_paypal_enable == "yes") //$credits < $bid->bid )
							{

								$link = site_url() . "/?pay_escrow_by_pp=" . $poid;

						?>

									<h5><?php printf(__('To make escrow of %s pay by PayPal <a href="%s">click here</a>.','ProjectTheme'), projectTheme_get_show_price($bid2->bid) , $link); ?></h5>

									<br/><br/> &nbsp;




						<?php
						}


							 do_action('ProjectTheme_escrow_tag');
					}

					?>
					<!--You are about to make an escrow payment for this project. The amount is: <?php echo $bid ?> <br/> <br/><br/>

					<a href="<?php bloginfo('siteurl') ?>/?escrow_com_1=<?php echo $_GET['poid'] ?>" class="green_btn">Go to escrow.com</a> -->
<style>
#asd tr td { padding:6px; border-bottom:1px solid #ddd }
</style>

<?php if($credits >= $bid2->bid ) {





	?>

	<h5><?php _e('Escrow through e-wallet','ProjectTheme'); ?></h5>
                     <table class="table">

											 <script>

											 jQuery(document).ready(function () {

													jQuery('#escromeform').submit(function() {
													    var c = confirm("<?php _e('Are you sure you want to complete escrow?','ProjectTheme') ?>");
													    return c; //you can just return c because it will be true or false
													});


												});

											 </script>

					<form method="post" id="escromeform" action="">
                    <input type="hidden" value="<?php echo current_time('timestamp',0) ?>" name="tm" />

										<tr>
										<td width="190"><?php _e('Your e-wallet balance','ProjectTheme'); ?>:</td><td>  <?php echo projectTheme_get_show_price($credits) ?></td>
										</tr>


										<tr>
                    <td width="150"><?php _e('Escrow amount','ProjectTheme'); ?>:</td><td>
											<input type="hidden" value="<?php echo $bid2->bid ?>" name="amount"  />
											<input value="0" type="hidden"
                    size="10" name="amount2" id="amount" /> <span id="my_escrow_amount2"><?php  echo ($bid) ?></span></td>
                    </tr>

										<?php

												$projectTheme_tax_fee_paypal_deposit = get_option('projectTheme_tax_fee_paypal_deposit');
												if($projectTheme_tax_fee_paypal_deposit > 0)
												{

														$fee = round(0.01*$bid2->bid*$projectTheme_tax_fee_paypal_deposit, 2);


										 ?>
										 <tr>
                     <td width="150"><?php printf(__('Escrow fee %s','ProjectTheme'), $projectTheme_tax_fee_paypal_deposit . "%"); ?>:</td><td>
 										  <span id="my_escrow_amount22"><?php  echo projecttheme_get_show_price($fee) ?></span></td>
                     </tr>



										 <tr>
                     <td width="150"><?php printf(__('Total','ProjectTheme')); ?>:</td><td>
 										  <span id="my_escrow_amount22"><?php  echo projecttheme_get_show_price($fee+ $bid2->bid) ?></span></td>
                     </tr>

									<?php } ?>


                    <tr>
                    <td><?php _e('Escrow for Project','ProjectTheme'); ?>:</td><td> <?php $st = ProjectTheme_get_my_awarded_projects($uid);
					if($st == false) echo '<strong>'.__('You dont have any awarded projects.','ProjectTheme').'</strong>'; else echo $st;?></td>
                    </tr>

                    <tr>
                    <td></td>
                    <td>
                    <input type="submit" class="btn btn-primary" name="escrowme" value="<?php _e('Make Escrow','ProjectTheme'); ?>" /></td></tr></form></table> <?php }

										else {

												$lnk = ProjectTheme_get_payments_page_url('deposit');

											?>

														<div class="alert alert-danger"><?php printf(__('You do not have enough balance in your e-wallet to finish this payment. <a href="%s">Click here to deposit more.</a> ','ProjectTheme'), $lnk); ?></div>

											<?php
										}


										?>


            </div>
            </div>



        <?php
			elseif($pg == 'bktransfer'):
		?>


        <div class="card">
        <div class="box_headline"> <i class="far fa-folder blueish"></i> <?php echo __('Set your Bank Transfer Details','ProjectTheme'); ?></div>


            	<div class="box_content">



                <?php

				$bal = projectTheme_get_credits($uid);


				if(isset($_POST['bank_details']))
				{
					$bank_details 	= $_POST['bank_details'];
					update_user_meta($uid, 'bank_details', $bank_details);
					echo __("Saved","ProjectTheme");

				}


				?>
    				<br /><br />
                    <table>
                    <form method="post">
                    <tr>
                    <td valign="top"><?php _e("Bank details","ProjectTheme"); ?>:</td>
                    <td> <textarea cols="60" name="bank_details" rows="6"><?php echo get_user_meta($uid,'bank_details',true); ?></textarea></td>
                    </tr>


                    <tr>
                    <td></td>
                    <td>
                    <input type="submit" name="submit" value="<?php _e("Save Details","ProjectTheme"); ?>" /></td></tr></form></table>


            </div>
            </div>



        <?php
			elseif($pg == 'makepayment'):


		?>

          <div class="card">
           <div class="box_headline"> <i class="far fa-folder blueish"></i> <?php echo __('Make Payment','ProjectTheme'); ?></div>



            	<div class="box_content">



                <?php

				$bal = projectTheme_get_credits($uid);


				if(isset($_POST['payme']))
				{
					$amount 	= $_POST['amount'];
					$username 	= $_POST['username'];
					$tms 	= $_POST['tms'];

					$username_select 	= $_POST['projectss'];

					if(!is_numeric($amount) || $amount < 0)
					{
						echo '<div class="newproject_error">'.__('ERROR: Provide a well formated amount.','ProjectTheme').'</div>';

					}
					else if(projectTheme_username_is_valid($username) == false && empty($username_select))
					{
						echo '<div class="newproject_error">'.__('ERROR: Invalid username provided.','ProjectTheme').'</div>';
					}

					else if($username == $current_user->user_login)
					{
						echo '<div class="newproject_error">'.__('ERROR: You cannot transfer money to your own account.','ProjectTheme').'</div>';
					}
					else
					{
						$min = get_option('project_theme_transfer_limit');
						if(empty($min)) $min = 20;

						if($bal < $amount)
						{
							echo '<div class="newproject_error">'.__('ERROR: Your balance is smaller than the amount requested.','ProjectTheme').'</div>';
						}
						else if($amount < $min)
						{
							echo '<div class="newproject_error">'.sprintf(__('ERROR: The amount should not be less than %s','ProjectTheme'), ProjectTheme_get_show_price($min)).'.</div>';
						}
						else
						{
							$tm = current_time('timestamp',0);
							$uid2 = projectTheme_get_userid_from_username($username);
							$usr2 = get_userdata($uid2);

							if(!empty($username_select)) { $uid2 = $username_select; $username = get_userdata($uid2); $username = $username->user_login; }

							// for logged in user, the user who sends
							//======================================================

							$option_1 = get_option("money_sent_action_" . $tms);
							if(empty($option_1))
							{
									update_option("money_sent_action_" . $tms, "1");
									$cr = projectTheme_get_credits($uid);
									projectTheme_update_credits($uid, $cr - $amount);

									//-----------------------
									$email 		= get_bloginfo('admin_email');
									$site_name 	= get_bloginfo('name');

									$usr = get_userdata($uid);

									$subject = __("Money Sent","ProjectTheme");
									$message = sprintf(__("You have sent amount of: %s to user: <b>%s</b>","ProjectTheme")
									,ProjectTheme_get_show_price($amount),$usr2->user_login);

									//($usr->user_email, $subject , $message);

									$reason = sprintf(__("Amount transfered to user %s","ProjectTheme"), $usr2->user_login);
									projectTheme_add_history_log('0', $reason, $amount, $uid, $uid2);

									//======================================================

									// for other user, the user who receives
									//======================================================

									$cr = projectTheme_get_credits($uid2);
									projectTheme_update_credits($uid2, $cr + $amount);



									$reason = sprintf(__("Amount transfered from user %s","ProjectTheme"), $usr->user_login);
									projectTheme_add_history_log('1', $reason, $amount, $uid2, $uid);

									//======================================================
							}
							echo '<div class="saved_thing">'.__('Your payment has been sent. Redirecting...','ProjectTheme').'</div>';
							$url_redir = get_permalink(get_option('ProjectTheme_my_account_payments_id'));
							echo '<meta http-equiv="refresh" content="2;url='.$url_redir.'" /><br/>';
						}

					}

				}

				global $current_user;
				$current_user = wp_get_current_user();
				$uid = $current_user->ID;

				$bal = projectTheme_get_credits($uid);
				echo '<span class="balance">'. sprintf(__("Your Current Balance is %s",""), ProjectTheme_get_show_price($bal)).":</span><br/><br/>";

				?>
    				<br /><br />
                    <table>
                    <form method="post" enctype="application/x-www-form-urlencoded"> <input type="hidden" value="<?php echo time() ?>" name="tms" />
                    <tr>
                    <td><?php echo __("Payment amount","ProjectTheme"); ?>:</td>
                    <td> <input value="<?php echo $_POST['amount']; ?>" type="text"
                    size="10" name="amount" /> <?php echo projectTheme_currency(); ?></td>
                    </tr>
                    <tr>
                    <td><?php echo __("Pay to user","ProjectTheme"); ?>:</td>
                    <td><input value="<?php echo $_POST['username']; ?>" type="text" size="30" name="username" />


					<?php

					$trg = ProjectTheme_get_my_awarded_projects2($uid);

					if($trg) { _e('or','ProjectTheme')." &nbsp; ";
					echo ProjectTheme_get_my_awarded_projects2($uid); } ?></td>
                    </tr>

                    <tr>
                    <td></td>
                    <td>
                    <input type="submit" name="payme" value="<?php echo __("Make Payment","ProjectTheme"); ?>" /></td></tr></form></table>


            </div>
            </div>


        <?php
            elseif($pg == 'withdraw'):

		?>


<h3 class="my-account-headline-1"><?php echo __('Request Withdrawal','ProjectTheme'); ?></h3>






                <?php

				$bal = projectTheme_get_credits($uid);


				?>


						<div class="card p-3">
							<div class="d-flex align-items-center">
								<span class="stamp stamp-md bg-blue mr-3">
									<i class="fas fa-funnel-dollar"></i>
								</span>
								<div>
									<h4 class="m-0"><?php 			printf(__('Balance is: %s','ProjectTheme'), ProjectTheme_get_show_price($bal)); ?></h4>

								</div>
							</div>
						</div>


				<?php




				do_action('ProjectTheme_add_new_withdraw_posts');

				if(isset($_POST['withdraw']) or isset($_POST['withdraw2']) or isset($_POST['withdraw3']) or isset($_POST['withdraw_bnk']))
				{
					$amount = $_POST['amount'];
					$paypal = $_POST['paypal'];
					$meth = $_POST['meth'];

					if(isset($_POST['withdraw2']))
					{

						$amount = $_POST['amount2'];
						$paypal = $_POST['paypal2'];
						$meth = $_POST['meth2'];

					}

					if(isset($_POST['withdraw3']))
					{

						$amount = $_POST['amount3'];
						$paypal = $_POST['paypal3'];
						$meth = $_POST['meth3'];

					}


					if(isset($_POST['withdraw_bnk']))
					{
						$amount = $_POST['amount_bnk'];
						$paypal = $_POST['bnk_dets'];
						$meth 	= 'Bank';
					}


					if(!is_numeric($amount) || $amount < 0)
					{
						echo '<br/><span class="newproject_error">'.__('Provide a well formated amount.','ProjectTheme').'</span><br/>';

					}
					else if(project_isValidEmail($paypal) == false and !isset($_POST['withdraw_bnk']))
					{
						echo '<br/><span class="newproject_error">'.__('Invalid email provided.','ProjectTheme').'</span><br/>';
					}
					else
					{
						$min = get_option('project_theme_min_withdraw');
						if(empty($min)) $min = 25;

						if($bal < $amount)
						{
							echo '<br/><span class="newproject_error">'.__('Your balance is smaller than the amount requested.','ProjectTheme').'</span><br/>';
						}
						else if($amount < $min)
						{
							echo '<br/><span class="newproject_error">'.sprintf(__('The amount should not be less than %s','ProjectTheme'),
							projecttheme_get_show_price($min)).'.</span><br/>';
						}
						else
						{
							$tm = current_time('timestamp',0);
							global $wpdb; $wpdb->show_errors = true;

							if(!empty($_POST['tm']))
							{
								$tm = $_POST['tm']; //current_time('timestamp',0);
							}

							$s = "select * from ".$wpdb->prefix."project_withdraw where uid='$uid' and datemade='$tm' ";
							$r = $wpdb->get_results($s);

							if(count($r) == 0)
							{

								$s = "insert into ".$wpdb->prefix."project_withdraw (methods, payeremail, amount, datemade, uid, done)
								values('$meth','$paypal','$amount','$tm','$uid','0')";
								$wpdb->query($s);


								// added 3.1.7
								ProjectTheme_send_email_on_withdrawal_requested_user($uid, $amount, $meth);
								ProjectTheme_send_email_on_withdrawal_requested_admin($uid, $amount, $meth);

								if(!empty($wpdb->last_error)) { echo $wpdb->last_error; exit; }

								$cr = projectTheme_get_credits($uid);
								projectTheme_update_credits($uid, $cr - $amount);

							}



							//-----------------------
							$email 		= get_bloginfo('admin_email');
							$site_name 	= get_bloginfo('name');

							$usr = get_userdata($uid);

							$subject = __("Money Withdraw Requested","ProjectTheme");
							$message = sprintf(__("You have requested a new withdrawal of: %s","ProjectTheme"), $amount." ".projectTheme_currency());

							//($usr->user_email, $subject , $message);

							//-----------------------

							echo '<div class="saved_thing">'.__('Your request has been queued. Redirecting...','ProjectTheme').'</div>';
							$url_redir = get_permalink(get_option('ProjectTheme_my_account_payments_id'));
							echo '<meta http-equiv="refresh" content="2;url='.$url_redir.'" />';
						}

					}

				}

				global $current_user;
				$current_user = wp_get_current_user();
				$uid = $current_user->ID;

					$opt = get_option('ProjectTheme_paypal_enable');
					if($opt == "yes"):

				?>
    		 <div class="card mb-4"><div class="card-body">
					<h5 class="cff123 mb-4"><?php _e('Widthdraw by PayPal','ProjectTheme') ?></h5>


                    <form method="post" enctype="application/x-www-form-urlencoded">
                    <input type="hidden" name="meth" value="PayPal" />
                    <input type="hidden" name="tm" value="<?php echo current_time('timestamp',0) ?>" />


										<div class="form-group">
										<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text"><?php echo projectTheme_currency() ?></span>
												</span>
												<input type="number" step="0.01" name="amount" required="" class="form-control" placeholder="<?php _e('Amount to withdraw','ProjectTheme') ?>">
											</div></div>


												<div class="form-group">
											<div class="input-group">
													<input type="text"  required="" class="form-control" name="paypal" placeholder="<?php _e('Your PayPal email address','ProjectTheme') ?>">
												</div>	</div>

												</div>

									<div class="card-footer text-right"> <input type="submit" class="btn btn-success" name="withdraw" value="<?php echo __("Withdraw","ProjectTheme"); ?>" /> </div>


								</form>
											</div>

                    <?php
					endif;

					$opt = get_option('ProjectTheme_moneybookers_enable');
					if($opt == "yes"):

					?>


					<div class="card mb-4"><div class="card-body">
					 <h5 class="cff123 mb-4"><?php _e('Widthdraw by Skrill','ProjectTheme') ?></h5>


										 <form method="post" enctype="application/x-www-form-urlencoded">
										 <input type="hidden" name="meth" value="Skrill" />
										 <input type="hidden" name="tm" value="<?php echo current_time('timestamp',0) ?>" />


										 <div class="form-group">
										 <div class="input-group">
												 <span class="input-group-prepend">
													 <span class="input-group-text"><?php echo projectTheme_currency() ?></span>
												 </span>
												 <input type="number" step="0.01" name="amount2" required="" class="form-control" placeholder="<?php _e('Amount to withdraw','ProjectTheme') ?>">
											 </div></div>


												 <div class="form-group">
											 <div class="input-group">
													 <input type="text"  required="" class="form-control" name="paypal2" placeholder="<?php _e('Your Skrill email address','ProjectTheme') ?>">
												 </div>	</div>

												 </div>

									 <div class="card-footer text-right"> <input type="submit" class="btn btn-success" name="withdraw2" value="<?php echo __("Withdraw","ProjectTheme"); ?>" /> </div>

								 </form>	 </div>




					<?php endif;


					$opt = get_option('ProjectTheme_alertpay_enable');
					if($opt == "yes"):

					?>
                        <br /><br />
						<h4 class="cff123"><?php _e('Widthdraw by Payza','ProjectTheme') ?></h4>
                        <table class="my-table-1">
                        <form method="post" enctype="application/x-www-form-urlencoded">
                        <input type="hidden" name="meth3" value="Payza" />
                        <tr>
                        <td><?php echo __("Withdraw amount","ProjectTheme"); ?>:</td>
                        <td> <input value="<?php echo $_POST['amount3']; ?>" type="text"
                        size="10" name="amount3" /> <?php echo projectTheme_currency(); ?></td>
                        </tr>
                        <tr>
                        <td><?php echo __("Payza Email","ProjectTheme"); ?>:</td>
                        <td><input value="<?php echo get_user_meta($uid, 'payza_email',true); ?>" type="text" size="30" name="paypal3" /></td>
                        </tr>

                        <tr>
                        <td></td>
                        <td>
                        <input type="submit" name="withdraw3" class="btn btn-success" value="<?php echo __("Withdraw","ProjectTheme"); ?>" /></td></tr></form></table>

					<?php endif;


					$opt = get_option('ProjectTheme_bank_details_enable');
					if($opt == "yes"):

					?>


					<div class="card mb-4"><div class="card-body">
					 <h5 class="cff123 mb-4"><?php _e('Widthdraw by Bank','ProjectTheme') ?></h5>


										 <form method="post" enctype="application/x-www-form-urlencoded">
										 <input type="hidden" name="meth3" value="Bank" />
										 <input type="hidden" name="tm" value="<?php echo current_time('timestamp',0) ?>" />


										 <div class="form-group">
										 <div class="input-group">
												 <span class="input-group-prepend">
													 <span class="input-group-text"><?php echo projectTheme_currency() ?></span>
												 </span>
												 <input type="number" step="0.01" name="withdraw_bnk" required="" class="form-control" placeholder="<?php _e('Amount to withdraw','ProjectTheme') ?>">
											 </div></div>


												 <div class="form-group">
											 <div class="input-group">
												 <textarea class="form-control" placeholder="<?php _e('Your Bank Details','ProjectTheme') ?>" name="bnk_dets"></textarea>

												 </div>	</div>

												 </div>

									 <div class="card-footer text-right"> <input type="submit" class="btn btn-success" name="withdraw_bnk" value="<?php echo __("Withdraw","ProjectTheme"); ?>" /> </div>

								 </form>	 </div>






					<?php endif; ?>


               <?php do_action('ProjectTheme_add_new_withdraw_methods'); ?>






        <?php
            elseif($pg == 'deposit'):

			global $USERID;
			$USERID = $uid;
		?>



		<h3 class="my-account-headline-1"><?php echo __('Deposit Money','ProjectTheme'); ?></h3>


                <?php

				$ProjectTheme_bank_details_enable = get_option('ProjectTheme_bank_details_enable');
				if($ProjectTheme_bank_details_enable == "yes"):

				?>

				<div class="card mb-4"> <div class="box_content">

                <strong><?php _e('Deposit money by Bank Transfer','ProjectTheme'); ?></strong><br/><br/>

                <?php echo get_option('ProjectTheme_bank_details_txt'); ?>

			</div></div>
                <?php endif; ?>


            	<?php

				$ProjectTheme_paypal_enable = get_option('ProjectTheme_paypal_enable');
				if($ProjectTheme_paypal_enable == "yes"):

				?>
				<div class="card mb-4"> <div class="box_content">

                <strong><?php _e('Deposit money by PayPal','ProjectTheme'); ?></strong><br/><br/>

                <form method="post" action="<?php echo esc_url( home_url() )  ?>/?p_action=paypal_deposit_pay"> <input type="hidden" value="deposit" name="deposit" />
									<?php

												$fee = get_option('projectTheme_tax_fee_paypal_deposit');
												if($fee > 0)
												{


									 ?>
										<div class="input-group"><?php echo sprintf(__('You will have to pay a fee of %s on top of this amount.','ProjectTheme'), $fee."%") ?></div>

									<?php } ?>
									<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text"><?php echo projectTheme_currency(); ?></span>
												</span>
												<input type="number" step="0.01" name="amount" required class="form-control" class="amount" placeholder="<?php _e("Amount to deposit","ProjectTheme"); ?>">

												<span class="input-group-append">
                              <button class="btn btn-success" type="submit"><?php _e('Deposit','ProjectTheme'); ?></button>
                            </span>

											</div>


              </form>
    			 	</div>	</div>
                <?php endif; ?>
                <!-- ################## -->

                <?php

				$ProjectTheme_alertpay_enable = get_option('ProjectTheme_alertpay_enable');
				if($ProjectTheme_alertpay_enable == "yes"):

				?>
				<div class="card mb-4"> <div class="box_content">
                <strong><?php _e('Deposit money by Payza','ProjectTheme'); ?></strong><br/><br/>

                <form method="post" action="<?php echo esc_url( home_url() )  ?>/?p_action=payza_deposit_pay">

									<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text"><?php echo projectTheme_currency(); ?></span>
												</span>
												<input type="number" step="0.01" required class="form-control" class="amount" placeholder="<?php _e("Amount to deposit","ProjectTheme"); ?>">

												<span class="input-group-append">
															<button class="btn btn-success" type="submit"><?php _e('Deposit','ProjectTheme'); ?></button>
														</span>

											</div>

							</form>
    			</div>	</div>
                <?php endif; ?>



                <?php

				$ProjectTheme_moneybookers_enable = get_option('ProjectTheme_moneybookers_enable');
				if($ProjectTheme_moneybookers_enable == "yes"){

				?>
				<div class="card mb-4"> <div class="box_content">

                <strong><?php _e('Deposit money by Skrill','ProjectTheme'); ?></strong><br/><br/>

                <form method="post" action="<?php echo esc_url( home_url() )  ?>/?p_action=mb_deposit_pay">



								<div class="input-group">
											<span class="input-group-prepend">
												<span class="input-group-text"><?php echo projectTheme_currency(); ?></span>
											</span>
											<input type="number" step="0.01" required class="form-control" name="amount" placeholder="<?php _e("Amount to deposit","ProjectTheme"); ?>">

											<span class="input-group-append">
														<button class="btn btn-success" type="submit"><?php _e('Deposit','ProjectTheme'); ?></button>
													</span>

										</div>


							</form>





            </div>
            </div>

        <?php   }

							  do_action('ProjectTheme_deposit_methods', $uid);


            elseif($pg == 'transactions'):

		?>


		<h3 class="my-account-headline-1"><?php echo __('Payment Transactions','ProjectTheme'); ?></h3>
            <div class="card">



            	<div class="table-responsive">


                <?php

					$s = "select * from ".$wpdb->prefix."project_payment_transactions where uid='$uid' order by id desc";
					$r = $wpdb->get_results($s);

					if(count($r) == 0) echo __('No activity yet.','ProjectTheme');
					else
					{
						$i = 0;
						echo '<table  class="table table-hover table-outline table-vcenter   card-table"><thead>';

						echo '<tr>';
						echo '<th>'.__('Event','ProjectTheme').'</th>';
						echo '<th>'. __('Date','ProjectTheme') .'</th>';
						echo '<th>'. __('Amount','ProjectTheme') .'</th>';

						echo '</tr></thead>';

						echo '<tbody>';

						foreach($r as $row) // = mysql_fetch_object($r))
						{
							if($row->tp == 0){ $class="redred"; $sign = "-"; }
							else { $class="greengreen"; $sign = "+"; }

							echo '<tr>';
							echo '<td class="small-font">'.$row->reason.'</td>';
							echo '<td class="small-font">'.date_i18n('d-M-Y H:i:s',$row->datemade).'</td>';
							echo '<td class="small-font '.$class.'"><b>'.$sign.ProjectTheme_get_show_price($row->amount).'</b></td>';

							echo '</tr>';
							$i++;
						}

						echo '</tbody></table>';


					}

				?>


            </div>
            </div>
        <?php endif; endif; ?>


<?php } ?>

        </div>  </div> <!-- end dif content -->




<?php
}


?>
