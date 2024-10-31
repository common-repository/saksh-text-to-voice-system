<?php



defined( 'ABSPATH' ) || exit;
 
 
 function saksh_event_line_title($res){
     
     
     
     
         if(is_array($res->products))
        {
            
            $title_array=array();
            
            
           $products= json_decode($res->products);
           
           foreach ( $products as $product )
           {
               $title_array[]= $product->product_name;
               
               
                 
                 
           }
           
            $title = implode(',', $title_array);
     return $title;
        }  
     
     else
    return  get_bloginfo( 'name' );;
     
  
     
     
 }
 
 
 
function saksh_booking_history_func(   ) {
 
 	ob_start();
 
   
     $nonce = wp_create_nonce( "saksh"  );
 
       echo "<div class='susheelhbti'>";





 if (isset($_REQUEST['id'])) {
     
     
     $case=sanitize_text_field(  $_REQUEST['case'] );
     
     
 $id=sanitize_text_field(   $_REQUEST['id']);
 
 
 
 
 
 	$user_id=  get_current_user_id(); 
 	
 	if($case=="download")
 	{
 saksh_download_booking($id,$user_id);
 	}
 	
 	
 	else if ($case=="reschedule")
 	{
 	    $sb=new saksh_booking();
 	$sb->saksh_booking_update($id,$user_id);
 	
 	
 	}
    	else   if ($case=="cancel")
 	{
 	    

 	      $sb=new saksh_booking();
 $sb->saksh_cancel_booking($id,$user_id);
 	    
 	  
  
   
   echo  '<div class="alert alert-primary" role="alert">
Request Forwarded
</div>';
   
 	}
    
 }
 
  
  
 	 
 
	
	 	global $wpdb;

	 
	  $table_name = $wpdb->prefix . 'saksh_bookings';
 
 
 	$user_id=  get_current_user_id(); 

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name where user_id=%d order by appointment_date   desc limit 50"  ,$user_id));
		
		
	 
		$date="";
			 
  foreach( $results as $res)
  {
          
 
       if($date <> $res->appointment_date){
       
       
           
           echo "<div class='saksh_h1_date text-gray-dark mb-3 text-start'>". esc_attr( $res->appointment_date) ."</div>";
           
       $date= $res->appointment_date;
        echo "<div class='text-end'> ".saksh_get_time_ago(strtotime( $res->appointment_date  ) )."</div>";
       echo "<hr />";
       }
       
       
  
      
       echo "<div class='saksh_event_row row'>";
 
  
       echo "<div class='col '>";
 
        
       
       echo "<div> ";
        echo esc_attr($res->start) ."-". esc_attr($res->end)." ".esc_attr($res->ampm);
       echo "</div>";
       
         echo "</div>";
       
       
       
            echo "<div class='col '>";
            
         
         
       echo "<div>";
       
       $title= saksh_event_line_title($res);;
       
       echo $title;
        
       
       
       echo "</div>";
       
       
       
       
       
       
       
       
     
    
       
       
     $timeslot=$res->start."-".$res->end." ".$res->ampm;
       
       ?>
       
       
       <div class="d-flex">
           
           <div class="saksh_col">
               
                <button 
                type="button"
                class="btn btn-primary btn-sm  m-1"
                data-bs-toggle="modal" 
                data-bs-target="#exampleModal" 
                data-bs-id="<?php echo esc_attr($res->id); ?>"    
                data-bs-appointment_date="<?php echo esc_attr($res->appointment_date); ?>"
                data-bs-timeslot="<?php echo esc_attr($timeslot); ?>"     
                >    &#x270D; Reschedule</button> 
       
       
               
           </div>
              <div class="saksh_col">
               
               
                 <form method="post" action="" >
           
           
         
   
     <?php
     
     
     
     $nonce = wp_create_nonce( "saksh"  );
        ?>	
        	   <input type='hidden' 
               id='nonce' value="<?php echo esc_attr($nonce); ?>"
               name='nonce'  />  
               
               
 
        	   <input type='hidden'  
               id='id' value="<?php echo esc_attr($res->id); ?>" 
               name='id' />  
               
               
 
        	   <input type='hidden'  
               id='case' value="cancel"
               name='case' />  
               
                <button type="submit" class="btn btn-primary btn-sm m-1"   >	&#9249;   Cancel</button> 
       
               
             
       </form>
       
           </div>
           
       </div>
      
      
      
      
         </div>
          
     
       

       <?php  
     	
 
    
      
         
       
        
            echo "<div class='col '>";
            
            
        //    echo "<div>";
         
       
        
     //   echo esc_attr($res->status) . "#". esc_attr($res->order_id);
       
     //  echo "</div>";


              echo "<div>"; 
 
  
   $format = 'Y-m-d h A';


 $saksh_dt=$res->appointment_date   ." ". $res->start." ".$res->ampm ; 

   



//////


$saksh_date_start = new DateTime($saksh_dt, new DateTimeZone( wp_timezone_string())); 
$saksh_date_start->setTimezone(new DateTimeZone("UTC"));  
 


 
 $saksh_dt=$res->appointment_date   ." ". $res->end." ".$res->ampm ; 
 

$saksh_date_end = new DateTime($saksh_dt, new DateTimeZone( wp_timezone_string())); 


$saksh_date_end->setTimezone(new DateTimeZone("UTC"));  

if ($saksh_date_end <= $saksh_date_start) {
$saksh_date_end = (clone $saksh_date_start)->modify('+30 minutes');
}
 
 //////
  
 echo  saksh_get_calander_links($title, $saksh_date_start,$saksh_date_end);
 
  

         echo "</div>";
         
       echo "</div>";
       
       
       
      echo "</div>";
      
      
      
      
        
  }
	  
 
 include "saksh_reschedule_booking.php";
    
         echo "</div>";
 
$content = ob_get_clean();
return $content;
 
 


}



add_shortcode( 'SakshBookingHistory', 'saksh_booking_history_func' );




