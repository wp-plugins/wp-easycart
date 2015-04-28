<?php
//Load Wordpress Connection Data
define( 'WP_USE_THEMES', false );
require( '../../../../../wp-load.php' );

$mysqli = new ec_db( );

$body = @file_get_contents('php://input');
$json = json_decode( $body );

if( isset( $json->type ) && isset( $json->data ) ){

	$webhook_id = $json->id;
	$webhook_type = $json->type;
	$webhook_data = $json->data->object;
	
	
	$webhook = $mysqli->get_webhook( $webhook_id );
	
	if( !$webhook ){
		
		$mysqli->insert_webhook( $webhook_id, $webhook_type, $webhook_data );
	
		if( $webhook_type == "account.updated" ){
			
		}else if( $webhook_type == "account.application.deauthorized" ){
			
		}else if( $webhook_type == "balance.available" ){
			
		}else if( $webhook_type == "charge.succeeded" ){
			
		}else if( $webhook_type == "charge.failed" ){
			
		}else if( $webhook_type == "charge.refunded" ){
			// Refund order
			$stripe_charge_id = $webhook_data->id;
			$original_amount = $webhook_data->amount;
			
			$refunds = $webhook_data->refunds;
			$refund_total = 0;
			$order_status = 16;
			
			foreach( $refunds as $refund ){
				$refund_total = $refund_total + $refund->amount;
			}
			
			if( $refund_total < $original_amount ){
				$order_status = 17;
			}
			
			$mysqli->update_stripe_order_status( $stripe_charge_id, $order_status, ( $refund_total / 100 ) );
			
		}else if( $webhook_type == "charge.captured" ){
			// Change order status for pre-orders
			// Using the Stripe charge ID, update the order status to total captured
			
		}else if( $webhook_type == "charge.updated" ){
			
		}else if( $webhook_type == "charge.dispute.created" ){
			
		}else if( $webhook_type == "charge.dispute.updated" ){
			
		}else if( $webhook_type == "charge.dispute.closed" ){
			
		}else if( $webhook_type == "customer.created" ){
			
		}else if( $webhook_type == "customer.updated" ){
			// Update a customer
			// Run through and update each subscription
			// Update the customer's saved credit card
			
		}else if( $webhook_type == "customer.deleted" ){
			
		}else if( $webhook_type == "customer.card.created" ){
			
		}else if( $webhook_type == "customer.card.updated" ){
			
		}else if( $webhook_type == "customer.card.deleted" ){
			
		}else if( $webhook_type == "customer.subscription.created" ){
			// Insert a subscription if not exists
			
		}else if( $webhook_type == "customer.subscription.updated" ){
			// Update a subscription
			
		}else if( $webhook_type == "customer.subscription.deleted" ){
			$stripe_subscription_id = $webhook_data->id;
			$mysqli->cancel_stripe_subscription( $stripe_subscription_id );
			
		}else if( $webhook_type == "customer.subscription.trial_will_end" ){
			// This fires 3 days before trial ends
		}else if( $webhook_type == "customer.discount.created" ){
			
		}else if( $webhook_type == "customer.discount.updated" ){
			
		}else if( $webhook_type == "customer.discount.deleted" ){
			
		}else if( $webhook_type == "invoice.created" ){
			
		}else if( $webhook_type == "invoice.updated" ){
			
		}else if( $webhook_type == "invoice.payment_succeeded" ){
			$payment_timestamp = $webhook_data->date;
			$stripe_subscription_id = $webhook_data->subscription;
			$stripe_charge_id = $webhook_data->charge;
			$subscription = $mysqli->get_stripe_subscription( $stripe_subscription_id );
			
			$mysqli->insert_response( 0, 1, "STRIPE Subscription", print_r( $subscription, true ) );
			
			if( $subscription && $subscription->last_payment_date == $payment_timestamp ){
				$mysqli->update_stripe_order( $subscription->subscription_id, $stripe_charge_id );
			}else if( $subscription ){
				$user = $mysqli->get_stripe_user( $webhook_data->customer );
				$order_id = $mysqli->insert_stripe_order( $subscription, $webhook_data, $user );
				$mysqli->update_stripe_subscription( $stripe_subscription_id, $webhook_data );
				$db_admin = new ec_db_admin( );
				$order_row = $db_admin->get_order_row_admin( $order_id );
				$order = new ec_orderdisplay( $order_row, true, true );
				$order->send_email_receipt( );
				
				if( $subscription->payment_duration > 0 && $subscription->payment_duration <= $subscription->number_payments_completed + 1 ){
					// Used to cancel when payment duration reached
					$stripe = new ec_stripe( );
					$stripe->cancel_subscription( $user, $stripe_subscription_id );
					$mysqli->cancel_stripe_subscription( $stripe_subscription_id );
				}
				
				if( class_exists( "Affiliate_WP" ) && affiliate_wp( )->tracking->was_referred( ) ){
			
					$affiliate_id = affiliate_wp( )->tracking->get_affiliate_id( );
					$default_rate = affwp_get_affiliate_rate( $affiliate_id );
					$has_affiliate_rule = false;
				
					$affiliate_rule = $mysqli->get_affiliate_rule( affiliate_wp()->tracking->get_affiliate_id( ), $subscription->product_id );
					if( $affiliate_rule )
						$has_affiliate_rule = true;
					
					if( $has_affiliate_rule && $affiliate_rule->rule_recurring ){
						if( $affiliate_rule->rule_type == "percentage" )
							$total_earned += ( $subscription->price * ( $affiliate_rule->rule_amount / 100 ) );
								
						else if( $affiliate_rule->rule_type == "amount" )
							$total_earned += $affiliate_rule->rule_amount;	
						
					}else
						$total_earned += ( $subscription->price * $default_rate );
					
					$data = array(
						'affiliate_id' => $affiliate_id,
						'visit_id'     => affiliate_wp()->tracking->get_visit_id( ),
						'amount'       => $total_earned,
						'description'  => $subscription->first_name . " " . $subscription->last_name,
						'reference'    => $order_id,
						'context'      => 'WP EasyCart',
					);
					$result = affiliate_wp()->referrals->add( $data );
		
				}
			}
			
		}else if( $webhook_type == "invoice.payment_failed" ){
			$payment_timestamp = $webhook_data->date;
			$stripe_subscription_id = $webhook_data->subscription;
			$stripe_charge_id = $webhook_data->charge;
			$subscription = $mysqli->get_stripe_subscription( $stripe_subscription_id );
			
			$mysqli->insert_response( 0, 1, "STRIPE Subscription Failed", print_r( $subscription, true ) );
			
			$order_id = $mysqli->insert_stripe_failed_order( $subscription, $webhook_data );
			$mysqli->update_stripe_subscription_failed( $subscription_id, $webhook_data );
			
			$db_admin = new ec_db_admin( );
			$order_row = $db_admin->get_order_row_admin( $order_id );
			$order = new ec_orderdisplay( $order_row, true, true );
			
			$order->send_failed_payment( );
		
		}else if( $webhook_type == "invoiceitem.created" ){
			
		}else if( $webhook_type == "invoiceitem.updated" ){
			
		}else if( $webhook_type == "invoiceitem.deleted" ){
			
		}else if( $webhook_type == "plan.created" ){
			// Add new subscription product
			
		}else if( $webhook_type == "plan.updated" ){
			// Update subscription product
			
		}else if( $webhook_type == "plan.deleted" ){
			// Do not delete a product... 
			
		}else if( $webhook_type == "coupon.created" ){
			
		}else if( $webhook_type == "coupon.deleted" ){
			
		}else if( $webhook_type == "transfer.created" ){
			
		}else if( $webhook_type == "transfer.updated" ){
			
		}else if( $webhook_type == "transfer.paid" ){
			
		}else if( $webhook_type == "transfer.failed" ){
			
		}else if( $webhook_type == "ping" ){
			
		}

	}

}

?>