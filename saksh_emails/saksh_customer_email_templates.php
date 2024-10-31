<?php 
 
do_action( 'saksh_appointment_notification_start', $saksh_booking_data);
  
 echo "The booking is submitted with following details";
 
 
do_action( 'saksh_appointment_notification_before_table', $saksh_booking_data);

echo '<table class="saksh_table">';


    
            
    do_action( 'saksh_appointment_notification_id', $saksh_booking_data);
       
       
     
    echo "<tr><td> Booking ID</td>    <td>". esc_attr( $saksh_booking_data['order_id'] ) ."</td></tr>";
    
    
        
    do_action( 'saksh_appointment_notification_order_id', $saksh_booking_data);
       
       
    echo "<tr><td> Booking order ID</td>    <td>". esc_attr( $saksh_booking_data['order_id'] )."</td></tr>";
    
    
    do_action( 'saksh_appointment_notification_products_title', $saksh_booking_data);
       
       
       
    echo "<tr><td>Products</td>    <td>". esc_attr( $saksh_booking_data['products_title'] )."</td></tr>";
       
       
do_action( 'saksh_appointment_notification_appointment_date', $saksh_booking_data);
       
    echo "<tr><td> Appointment date</td>    <td>". esc_attr( $saksh_booking_data['appointment_date'] ) ."</td></tr>";
       
       
do_action( 'saksh_appointment_notification_timeslot', $saksh_booking_data);
     
    echo "<tr><td> Timeslot</td>    <td>". esc_attr( $saksh_booking_data['start'] ) ."-".esc_attr( $saksh_booking_data['end'] ) ." ".esc_attr( $saksh_booking_data['ampm'] ) ."</td></tr>";
           
           
           
           
do_action( 'saksh_appointment_notification_status', $saksh_booking_data);


    echo "<tr><td> Status</td>    <td>". esc_attr( $saksh_booking_data['status'] ) ."</td></tr>";
       
       



do_action( 'saksh_appointment_notification_table', $saksh_booking_data);

echo '</table>';  
  

do_action( 'saksh_appointment_notification_after_table', $saksh_booking_data);
  
  echo "For anything contact to the support";
  
  
  
  
do_action( 'saksh_appointment_notification_end', $saksh_booking_data);
  
  