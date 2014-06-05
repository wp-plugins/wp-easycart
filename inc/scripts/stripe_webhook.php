<?php
ini_set( 'log_errors', true );
ini_set( 'error_log', dirname( __FILE__ ).'/stripe_log.txt' );

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
			
			error_log( "SUBSCRIPTION FOUND: " . $stripe_subscription_id );
			error_log( print_r( $subscription, true ) );
			
			if( $subscription->last_payment_date == $payment_timestamp ){
				$mysqli->update_stripe_order( $subscription->subscription_id, $stripe_charge_id );
			}else{
				$mysqli->insert_stripe_order( $subscription->subscription_id, $webhook_data );
				$mysqli->update_stripe_subscription( $subscription_id, $webhook_data );
			}
			
		}else if( $webhook_type == "invoice.payment_failed" ){
			
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