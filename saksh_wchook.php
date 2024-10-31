<?php

/*
function saksh_display_engraving_text_cart( $item_data, $cart_item ) {
	if ( empty( $cart_item['appointment_date'] ) ) {
	return $item_data;
	}

  
	 return $item_data;

	
		$item_data[] = array(
		'key'     => __( 'appointment_date', 'aistore' ),
		'value'   => wc_clean( $cart_item['appointment_date'] ),
		'display' => '',
	);
	
		$item_data[] = array(
		'key'     => __( 'start', 'aistore' ),
		'value'   => wc_clean( $cart_item['start'] ),
		'display' => '',
	);
		$item_data[] = array(
		'key'     => __( 'end', 'aistore' ),
		'value'   => wc_clean( $cart_item['end'] ),
		'display' => '',
	);
		$item_data[] = array(
		'key'     => __( 'ampm', 'aistore' ),
		'value'   => wc_clean( $cart_item['ampm'] ),
		'display' => '',
	);
	
	
 
	
	return $item_data;
}

 add_filter( 'woocommerce_get_item_data', 'saksh_display_engraving_text_cart', 10, 2 );

*/


/*
 add_filter('woocommerce_thankyou_order_received_text', 'saksh_woo_change_order_received_text', 10, 2 );
 
 
 
function saksh_woo_change_order_received_text( $str, $order ) {
	
return "";

	$saksh_event_time="";
	
 foreach ( $order->get_items() as $key => $item ) {
	 
 
         
			 
				
				
    $saksh_event_time = wc_get_order_item_meta( $key, 'saksh_event_time' );
    
 
   
}  


    $str = 'Booking time.  '.$saksh_event_time ;
    return $str;
}

*/


 
 add_action( 'woocommerce_order_status_pending', 'saksh_appointment_step3_pending', 10, 1);
 add_action( 'woocommerce_order_status_failed', 'saksh_appointment_step3_failed', 10, 1);
 add_action( 'woocommerce_order_status_on-hold', 'saksh_appointment_step3_on_hold', 10, 1);
// Note that it's woocommerce_order_status_on-hold, and NOT on_hold.
 add_action( 'woocommerce_order_status_processing', 'saksh_appointment_step3_processing', 10, 1);
 add_action( 'woocommerce_order_status_completed', 'saksh_appointment_step3_completed', 10, 1);
 add_action( 'woocommerce_order_status_refunded', 'saksh_appointment_step3_refunded', 10, 1);
 add_action( 'woocommerce_order_status_cancelled', 'saksh_appointment_step3_cancelled', 10, 1);	
  
 
 

 
 function saksh_appointment_step3_pending($order_id){
      saksh_appointment_step3($order_id,"Pending");
 }
 function saksh_appointment_step3_failed($order_id){
      saksh_appointment_step3($order_id,"Failed");
 }
 function saksh_appointment_step3_on_hold($order_id){
      saksh_appointment_step3($order_id,"On-hold");
 }
 function saksh_appointment_step3_processing($order_id){
      saksh_appointment_step3($order_id,"Processing");
 }
 function saksh_appointment_step3_completed($order_id){
      saksh_appointment_step3($order_id,"Completed");
 }
 function saksh_appointment_step3_refunded($order_id){
      saksh_appointment_step3($order_id,"Refunded");
 }

 function saksh_appointment_step3_cancelled($order_id){
      saksh_appointment_step3($order_id,"Cancelled");
 } 
 
     
 
 function saksh_appointment_step3($order_id,$status){


 
 
 
    $order = wc_get_order( $order_id );


	 
	
 
        
   $saksh_booking_data=array();
 
$products="";

$saksh_products=array();


foreach ( $order->get_items() as $item_id => $item ) {
    
    
$s_product=array();




   $s_product['product_id'] = $item->get_product_id();
   
  $s_product['product_name'] = $item->get_name();
   $s_product['quantity'] = $item->get_quantity();
   
   $s_product['total'] = $item->get_total();
 $saksh_products[]=$s_product;
 
 
 $products  .="  " . $s_product['product_name'] ;
 
 
 
 
 
				
   $appointment_date = wc_get_order_item_meta( $item_id, 'appointment_date' );
   
   
   $start = wc_get_order_item_meta( $item_id, 'start' );
   $end = wc_get_order_item_meta( $item_id, 'end' );
   $ampm = wc_get_order_item_meta( $item_id, 'ampm' );
     
 
   
}
 
 
  
	 
	
     $saksh_booking_data['appointment_date']=$appointment_date;
   
	
     $saksh_booking_data['start']=$start;
   
	
     $saksh_booking_data['end']=$end;
   
	
     $saksh_booking_data['ampm']=$ampm;
    
   
   
   $saksh_booking_data['order_id']=$order_id;
   
   $saksh_booking_data['products_title']=$products;
   
   
   
  $saksh_booking_data['products']=wp_json_encode($saksh_products);
   
   
   
   
       $user = wp_get_current_user();
    
    $user_id = $user->ID;
    
   
   $saksh_booking_data['user_id']=$user_id;
    
   
   $saksh_booking_data['email']=$user->data->user_email;
   $saksh_booking_data['name']=$user->data->display_name;
   
   
 
     
   $saksh_booking_data['order_amount']=$order->get_total();
    
     $billing_phone = $order->get_billing_phone();
     
     
 $saksh_booking_data['phone']=$billing_phone; 
 
    global   $wpdb;
    
    $table_name = $wpdb->prefix . 'saksh_bookings';
     
    
    
     $checkIfExists = $wpdb->get_var($wpdb->prepare(  "SELECT  order_id FROM    {$wpdb->prefix}saksh_bookings  WHERE order_id = %d",$order_id ) );


 $saksh_booking_data['status']=$status; 
 
do_action( 'saksh_appointment_updates', $saksh_booking_data);

 
    if ($checkIfExists === NULL) {


    
   
   saksh_booking_capture_data($saksh_booking_data);
    
        
    }
    
    else
    
    {
    
    $table_name = $wpdb->prefix . 'saksh_bookings';
    
    
    
 
 

$wpdb->update(
    
    $table_name,
    array(
        'status' => $status 
    ),
    array(
        'order_id' => $order_id,
    ),
    array(
        '%s' 
         
    ),
    array(
        '%d',
    )
);
        
    }
       
       
	
 
}  


function saksh_update_booking_status($id,$status){
    
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'saksh_bookings';
    
    
    
 
 

$wpdb->update(
    
    $table_name,
    array(
        'status' => $status 
    ),
    array(
        'id' => $id,
    ),
    array(
        '%s' 
         
    ),
    array(
        '%d',
    )
);
        
   
       
}
 

 function saksh_booking_capture_data($query_data)
  {
  
   
    
      
      global $wpdb;
      
    
     
     
 
   
       
 $table_name= $wpdb->prefix ."saksh_bookings";
  
 

 saksh_capture_data_to_log( __LINE__,$query_data) ;

 
  $wpdb->insert( $table_name, $query_data );
 
 

 $my_post = array(
'post_title'    => __LINE__,
'post_content'  =>  $wpdb->last_error
);

// Insert the post into the database
wp_insert_post( $my_post );
      
  }

function saksh_add_text_to_order_items( $item, $cart_item_key, $values, $order ) {
   
   

	if ( empty( $values['appointment_date'] ) ) {
		return;
	}
	
 
	
 


	$item->add_meta_data( __( 'appointment_date', 'aistore' ), $values['appointment_date'] );
	
		$item->add_meta_data( __( 'start', 'aistore' ), $values['start'] );
	
		$item->add_meta_data( __( 'end', 'aistore' ), $values['end'] );
	
		$item->add_meta_data( __( 'ampm', 'aistore' ), $values['ampm'] );
	
	 
	
	
  
     
	
}

add_action( 'woocommerce_checkout_create_order_line_item', 'saksh_add_text_to_order_items', 10, 4 );




