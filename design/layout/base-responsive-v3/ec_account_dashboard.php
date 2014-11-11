<div id="ec_account_dashboard">
	
    <div class="ec_account_left">

		<div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_recent_orders_title' )?></div>

			<?php if( $this->orders->num_orders > 0 ){ ?>

			<div class="ec_account_dashboard_row" id="ec_dashboard_orders_list">
            
            	<div class="ec_account_order_line_header">
            
            	<div class="ec_account_order_line_column1_header"><?php echo $GLOBALS['language']->get_text( 'account_orders', 'account_orders_header_1' )?></div>
            
            	<div class="ec_account_order_line_column2_header"><?php echo $GLOBALS['language']->get_text( 'account_orders', 'account_orders_header_2' )?></div>
            
            	<div class="ec_account_order_line_column3_header"><?php echo $GLOBALS['language']->get_text( 'account_orders', 'account_orders_header_3' )?></div>
            
            	<div class="ec_account_order_line_column4_header"><?php echo $GLOBALS['language']->get_text( 'account_orders', 'account_orders_header_4' )?></div>
            
            	<div class="ec_account_order_line_column5_header"></div>
            
            </div>

          	<?php $days_prior_to_show = 21; $max_orders_to_show = 10; $this->orders->display_order_list( $days_prior_to_show, $max_orders_to_show ); ?>

		</div>

		<div class="ec_account_dashboard_row_divider">

			<?php $this->display_orders_link( $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_all_orders_linke' ) ); ?>

        </div>

        <?php }else{ echo $GLOBALS['language']->get_text( "account_dashboard", "account_dashboard_recent_orders_none" ); }?>

		<div class="ec_cart_header"><?php echo $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_email_title' )?></div>

        <div class="ec_cart_input_row"><?php $this->user->display_email(); ?></div>

        <div class="ec_cart_input_row">

			<?php $this->display_personal_information_link( $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_email_edit_link' ) ); ?>

			<?php echo $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_email_note' )?></div>

        <div class="ec_cart_header"><?php echo $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_billing_title' )?></div>

        <?php if( $this->user->billing->first_name || $this->user->billing->last_name ){ ?>

		<div class="ec_cart_input_row">

			<?php $this->user->billing->display_first_name(); ?>

			<?php $this->user->billing->display_last_name(); ?>

        </div>

        <?php } ?>
        
        <?php if( $this->user->billing->company_name ){ ?>

		<div class="ec_cart_input_row">

			<?php $this->user->billing->display_company_name(); ?>

        </div>

		<?php } ?>

        <?php if( $this->user->billing->address_line_1 ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->user->billing->display_address_line_1(); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->billing->address_line_2 != "" ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->user->billing->display_address_line_2( ); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->billing->city || $this->user->billing->state || $this->user->billing->zip ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->user->billing->display_city(); ?>, <?php $this->user->billing->display_state(); ?> <?php $this->user->billing->display_zip(); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->billing->country ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->user->billing->display_country(); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->billing->phone ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->billing->display_phone(); ?>

        </div>

        <?php } ?>

        <div class="ec_cart_input_row">

			<?php $this->display_billing_information_link( $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_billing_link' ) ); ?>

        </div>

        <?php if( get_option( 'ec_option_use_shipping' ) ){ ?>

        <div class="ec_cart_header"><?php echo $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_shipping_title' )?></div>

        <?php if( $this->user->shipping->first_name || $this->user->shipping->last_name ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->shipping->display_first_name(); ?>
            
            <?php $this->user->shipping->display_last_name(); ?>

        </div>

        <?php } ?>
        
        <?php if( $this->user->shipping->company_name ){ ?>

		<div class="ec_cart_input_row">

			<?php $this->user->shipping->display_company_name(); ?>

        </div>

		<?php } ?>

        <?php if( $this->user->shipping->address_line_1 ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->shipping->display_address_line_1(); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->shipping->address_line_2 != "" ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->shipping->display_address_line_2( ); ?>

		</div>

		<?php } ?>

        <?php if( $this->user->shipping->city || $this->user->shipping->state || $this->user->shipping->zip ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->shipping->display_city(); ?>, <?php $this->user->shipping->display_state(); ?> <?php $this->user->shipping->display_zip(); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->shipping->country ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->shipping->display_country(); ?>

        </div>

        <?php } ?>

        <?php if( $this->user->shipping->phone ){ ?>

        <div class="ec_cart_input_row">

			<?php $this->user->shipping->display_phone(); ?>

        </div>

        <?php } ?>

        <div class="ec_cart_input_row">

			<?php $this->display_shipping_information_link( $GLOBALS['language']->get_text( 'account_dashboard', 'account_dashboard_shipping_link' )); ?>

        </div>

        <?php }?>

    </div>

	<div class="ec_account_right">

		<div class="ec_cart_header ec_top"><?php echo $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_title' )?></div>

		<div class="ec_cart_input_row">

			<?php $this->display_billing_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_billing_information' ) ); ?>

		</div>

        <div class="ec_cart_input_row">

			<?php $this->display_shipping_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_shipping_information' ) ); ?>

		</div>

        <div class="ec_cart_input_row">

			<?php $this->display_personal_information_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_basic_inforamtion' ) ); ?>

		</div>

       <div class="ec_cart_input_row">

          <?php $this->display_password_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_password' ) ); ?>

        </div>

		<?php if( $this->using_subscriptions( ) ){ ?>

        <div class="ec_cart_input_row">

          <?php $this->display_subscriptions_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_subscriptions' )); ?>

        </div>

        <?php }?>

        <div class="ec_cart_input_row">

          <?php $this->display_logout_link( $GLOBALS['language']->get_text( 'account_navigation', 'account_navigation_sign_out' )); ?>

        </div>

    </div>

</div>