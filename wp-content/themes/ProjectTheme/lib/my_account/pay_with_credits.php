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

function ProjectTheme_my_account_pay_with_credits_area_function()
{
		global $current_user, $wpdb, $wp_query;
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;
		$pid = $_GET['pid'];
		$post_ar = get_post($pid);



					do_action('pt_for_demo_work_3_0');


					
?>


     <div class="account-main-area col-xs-12 col-sm-8 col-md-8 col-lg-9">
        	<div class="my_box3 border_bottom_0">


            	<div class="box_title"><?php _e("Pay with virtual currency",'ProjectTheme'); ?></div>
                <div class="box_content">



           <div class="post no_border_btm" id="post-<?php the_ID(); ?>">

                <div class="image_holder">
                <a href="<?php echo get_permalink($pid); ?>"><img width="45" height="45" class="image_class"
                src="<?php echo ProjectTheme_get_first_post_image($pid,45,45); ?>" /></a>
                </div>
                <div  class="title_holder" >
                     <h2><a href="<?php echo get_permalink($pid) ?>" rel="bookmark" title="Permanent Link to <?php echo $post_ar->post_title; ?>">
                        <?php


                        echo $post_ar->post_title;


                        ?></a></h2>
      			</div>
                <?php

					if(isset($_GET['pay'])):
						echo '<div class="details_holder sk_sk_class">';

							$post_ar 	= get_post($pid);
							$cr 	= projectTheme_get_credits($uid);
							$bid 	= projectTheme_get_winner_bid($pid);
							$amount = $bid->bid;

							if($cr < $amount) { echo '<div class="error2">'; echo __('You do not have enough credits to pay for this project.','ProjectTheme');
							echo '</div><div class="clear10 flt_lft"></div>';
							?>

							<div class="tripp">
							<a class="post_bid_btn" href="<?php echo ProjectTheme_get_payments_page_url('deposit'); ?>"><?php
							echo __('Add More Credits','ProjectTheme'); ?></a>
							</div>

							<?php
                            }
							else
							{
								projectTheme_send_email_to_project_payer($pid, $uid, $bid->uid, $amount, '1');
								echo __('Your payment has been sent.','ProjectTheme');
							}
							echo '</div>';
				?>


                <?php else: ?>
                <div class="details_holder sk_sk_class">

                <b>
                 <?php echo __('The price for the project is','ProjectTheme'); ?>: <?php $bid = projectTheme_get_winner_bid($pid); echo projectTheme_get_show_price($bid->bid); ?></b>
                <br/><br/>

               <?php _e("Your credits amount",'ProjectTheme'); ?>: <?php echo projectTheme_get_credits($uid); ?> <?php echo projectTheme_currency(); ?> <br/><br/>
               <a class="post_bid_btn" href="<?php echo ProjectTheme_get_pay_with_credits_page_url($pid, '&pay=yes'); ?>"><?php echo __('Pay Now','ProjectTheme'); ?></a>

               <a class="post_bid_btn" href="<?php echo ProjectTheme_get_payments_page_url('deposit'); ?>"><?php echo __('Add More Credits','ProjectTheme'); ?></a>
                </div><?php endif; ?>


           </div></div>
           </div>


  		</div>
<?php
		ProjectTheme_get_users_links();

}

?>
