<?php

class saksh_booking 
{  
    
    
    
    public function __construct(){ 
        
        
    
    } 
    
    
    
     
 function saksh_get_total_booking()
 {
     
     
     	global $wpdb;  
	 
		
	 

		
$row = $wpdb->get_row(  "SELECT count(*) count FROM  $wpdb->saksh_bookings "  );


return $row->count;
 
 }

    
    
      
 function saksh_get_booking_info_by_id($id)
 {
     
     
     	global $wpdb;  
	 
		
	 

		
$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM  $wpdb->saksh_bookings WHERE id = %d", $id ) );


return $row;
 
 }


  function saksh_get_booking_info_by_id_n_user_id($id,$user_id)
 {
     
     
     	global $wpdb;  
	 
		
	 

		
$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->saksh_bookings WHERE id = %d and user_id=%d", $id,$user_id ) );


return $row;
 
 }
 
 
 
 
  function  saksh_get_booking_info()
 {
     
     
     	global $wpdb;  
	 
		
				
 $id =sanitize_key($_REQUEST['id']);
 

		
$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->saksh_bookings WHERE id = %d", $id ) );



 echo wp_json_encode($row);
    wp_die();  
     
 }
 
 
 
 
  function saksh_booking_update($id,$user_id)
 {
     
     
     	global $wpdb;  
	 
	 	  if ( ! wp_verify_nonce( $_POST['nonce'],  "saksh") ) {
         wp_die ( 'Busted!');
     }
		
 
 
  
  $appointment_date=sanitize_key($_POST['appointment_date']);
  $timeslot=sanitize_key($_POST['timeslot']);


 
  $time_slot=saksh_get_timeslot($timeslot );
  
  $sql=$wpdb->prepare( "UPDATE   $wpdb->saksh_bookings SET `appointment_date` = %s,  `start` = %s , `end` = %s , `ampm` = %s,  timeslot =%s    WHERE   id  = %d and   user_id=%d", $appointment_date  ,$time_slot->start_time  ,$time_slot->end_time,$time_slot->ampm,$timeslot,   $id ,$user_id   );
  
  
  
$wpdb->query($sql  );


echo  '<div class="alert alert-success" role="alert">
  Updated successfully.
</div>' ;
   
 

		  
     
 } 
 
 
 

  function saksh_booking_update_admin()
 {
     
     
     	global $wpdb;  
	 
		  if ( ! wp_verify_nonce( $_POST['nonce'],  "saksh") ) {
         wp_die ( 'Busted!');
     }
		
 $id =sanitize_key($_REQUEST['id']);
 
  
  $appointment_date=sanitize_key($_POST['appointment_date']);
  $timeslot=sanitize_key($_POST['timeslot']);


  $time_slot=saksh_get_timeslot($timeslot );
  
  
  
$wpdb->query( $wpdb->prepare( "UPDATE   $wpdb->saksh_bookings SET `appointment_date` = %s,  `start` = %s , `end` = %s , `ampm` = %s    WHERE   id  = %d", $appointment_date  ,$time_slot->start  ,$time_slot->end,$time_slot->ampm,   $id   ) );



$booking=$this->saksh_get_booking_info_by_id($id);
 

 return   $booking ;
   
 
   
     
 } 
 
 
 
 
 
 function saksh_cancel_booking(){
     
     
     
     	
 
	   if ( ! wp_verify_nonce(sanitize_key( $_REQUEST['nonce']),   "saksh" ) ) {
        wp_die ( 'Busted!');
    }
		
		
		
     	global $wpdb;  
     	
     	
 $id =sanitize_key($_REQUEST['id']);
 
 
 
 
   
  $status= "wc-cancelled";

$booking=$this->saksh_get_booking_info_by_id($id);

$order_id=$booking->order_id;


   $order = wc_get_order( $order_id );
   
   
    $order->update_status( $status );
   
    


$booking=$this->saksh_get_booking_info_by_id($id);
 
 
 

 return   $booking ;
   
     
 }
 
  function saksh_update__booking_status(){
      
   
     
     	
 
	   if ( ! wp_verify_nonce(sanitize_key( $_REQUEST['nonce']),   "saksh" ) ) {
        wp_die ( 'Busted!');
    }
		
		
		
     	global $wpdb;  
     	
     	
 $id =sanitize_key($_REQUEST['id']);
 
 
 
 
   
  $status=sanitize_key($_REQUEST['status']);

$booking=$this->saksh_get_booking_info_by_id($id);

$order_id=$booking->order_id;


if($order_id <> 0)
{
  
 
   $order = wc_get_order( $order_id );
   
   
    $order->update_status( $status );
   
   
  //wp_die ( 'Busted!');
}
else
{
      saksh_update_booking_status($id,$status);
 
}

$booking=$this->saksh_get_booking_info_by_id($id);
 

 return   $booking ;
   
     
 }
 
 
 

 
}

