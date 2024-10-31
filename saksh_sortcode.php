<?php
 


defined( 'ABSPATH' ) || exit;





add_shortcode( 'SakshSimpleBooking', 'saksh_simple_booking_page_func' );


function saksh_simple_booking_page_func(   ) {
 
	
	
	 
 
  	ob_start();
	
	include "saksh_simple_booking.php" ;
    
$content = ob_get_clean();
return $content;
    
  
 

}



function saksh_booking_page_func(){
    
	ob_start();
	
	include "saksh_booking.php" ;
    
$content = ob_get_clean();
return $content;
    
}




add_shortcode( 'SakshBookingPage', 'saksh_booking_page_func' );


function saksh_appointment_calendar_func(   ) {
 
	
	
	
 return "<div id='saksh_appointment_calendar'></div>";
 
  
  
 

}



add_shortcode( 'SakshAppointmentCalendar', 'saksh_appointment_calendar_funcV1' );


function saksh_appointment_calendar_funcV1(  $atts ) {

   if( !saksh_is_wc_available())    
       {
        
          return "";
       }
       
       
$product_cat=$atts['product_cat'] ;

  
 
	$term_id= saksh_get_term_ids($product_cat,'product_cat');
 
 
     $args = array(
    'status'            => array(  'publish' ),
  
  'tax_query'             => array(
        array(
            'taxonomy'      => 'product_cat',
            'field'         => 'term_id',
            'terms'         => $term_id,
            'operator'      => 'IN'
        ),
    ),
    'tag'               => array() 
    
);

  
  $products = wc_get_products( $args ) ;
 
  
 
       $str   ="<div class='saksh susheelhbti  alignfull'><div class='container '><div class='row'><div class='col-md-2'>";
       
       
            foreach( $products as $product ) {

 
    
    
   $str .="<div class='saksh-product-row' >";
   
  $str  .= '   <input type="checkbox" class="saksh_checkbox"    name="saksh_products" value="'.esc_attr($product->get_id()).'">'. $product->get_name() .'   ' . wc_price ( $product->get_price())   ;
  
     $str .=   "</div>"; 
  
 }
   
    $str  .="</div><div class='col-md-8 saksh_appointment_calendar '  ><div id='saksh_appointment_calendarV1'></div></div><div class='col-md-2'>";
   
   
 $timeslot=array();
$timeslot= saksh_getTimeslots("monday");



   $str .="<div id='timeslots' style='display:none '>";
   
   
    $str .="<div id='saksh_appointment_timeblock' class=' card p-2 m-1'></div>";
   
   
   
  foreach ($timeslot as $ts )
  {
   $str .="<div class='timeslotsblock card p-2 m-1'  id='".   esc_attr($ts['start'])."-".esc_attr($ts['end'])."-".esc_attr($ts['ampm'])."'>";
  $str .=     esc_attr($ts['start'])."-".esc_attr($ts['end'])." ".esc_attr($ts['ampm']);
  
      $str .=   "</div>";  
  }
  
    $str .=   "</div>";
  
  
  
     $nonce = wp_create_nonce( "saksh"  );
     	
 
    $str .=   "<input type='hidden' name='selected_date' id='selected_date'>";
 //   $str .=   "<input type='hidden' name='selected_date' value='".esc_attr($nonce)."'>";
	
	
	
	 
     
     
        	  
               
               
	 $str  .="</div> ";	 $str  .="</div> ";
	 
	 
 return  $str."  </div></div>";
	
 
 
  
  
 

}



add_shortcode( 'SakshAppointmentCalendarV1', 'saksh_appointment_calendar_funcV1' );



  
function saksh_download_booking($id,$user_id){
    
 
 	 
	
    
}



function saksh_cancel_booking($id,$user_id){
    
    
       if( !saksh_is_wc_available())    
       {
        
          return "";
       }
       
       
$booking=saksh_get_booking_info_by_id_n_user_id($id,$user_id);


 $order_id=$booking->order_id;


   $order = wc_get_order( $order_id );
   
  
    $order->update_status( "wc-cancelled" );
   
	
    
}


