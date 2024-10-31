<?php


 add_action( 'saksh_appointment_updates', 'saksh_appointment_updates', 10, 1);	
  
 
 

 
 function saksh_appointment_updates($saksh_booking_data){
     
     
     saksh_capture_data_to_log( __LINE__,$saksh_booking_data);
     
     
      
     
     
     
      // email to customer
     ob_start();
     
     
include  'saksh_emails/saksh_customer_email_templates.php';



$email_content = ob_get_contents();
ob_end_clean();

 
     
     
     $to =  $saksh_booking_data['email'];
     
$subject = 'Appointment Booking information';
$body = $email_content; 
$headers = array('Content-Type: text/html; charset=UTF-8');

wp_mail( $to, $subject, $body, $headers );


// email to admin

    ob_start();
    
    include  'saksh_emails/saksh_admin_email_templates.php';
$email_content = ob_get_contents();
ob_end_clean();

 
     
     
      
$to =  get_bloginfo('admin_email');
$subject = 'Appointment Booking information';
$body = $email_content; 
$headers = array('Content-Type: text/html; charset=UTF-8');

wp_mail( $to, $subject, $body, $headers );


}

