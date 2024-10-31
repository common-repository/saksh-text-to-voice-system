<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


  


 


 function saksh_todays_booking()
 { 
       $request_date=  gmdate("Y-m-d");
        
    saksh_booking_by_date($request_date);
    
    
 }





function saksh_wb_print_report(){
    
         if (!empty($_POST))
  {
    
     


   if ( ! isset( $_POST['saksh_nonce'] ) 
    || ! wp_verify_nonce( sanitize_text_field(wp_unslash ( $_POST['saksh_nonce'])) , 'saksh_nonce_action' ) 
) {
   return  esc_html_e( 'Sorry, your nonce did not verify.', 'saksh-wp-hotel-booking-lite' );

   exit;
}




}
    //  wp_nonce_field( 'saksh_nonce_action', 'saksh_nonce' );
    
    if(isset($_REQUEST['request_date']))
    {
        
    $request_date=sanitize_text_field($_REQUEST['request_date']);
        
    saksh_booking_by_date($request_date);
    
    saksh_other_booking_by_date($request_date);
    
    
    
    }else 
    
    
     if(isset($_REQUEST['user_id']))
    {
        
    $user_id=sanitize_text_field($_REQUEST['user_id']);
         

  saksh_booking_by_user_id($user_id) ;
     
    
    }else
    
     
    
    {
     saksh_date_wise_booking();
    }
    

}
function saksh_date_wise_booking(){
	
	
	     do_action("saksh_date_wise_booking");
    

 
		?>
		<div class="  wrap">
  
 
  
		<?php
		
		  
		saksh_recent_booking();
		
 
	 echo "</div>";


 
	
	
}

function saksh_recent_booking ( ){
	
	
	
	 	global $wpdb; 
	

		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}saksh_bookings order by id desc limit 100 " );
		?>
		<div class="  wrap">
  

	  <h3 class="wp-heading-inline"> New bookings</h3>  
	  
	  <?php
saksh_report_table_view($results);
 
	 echo "</div>";


 
	
	
}


function saksh_booking_by_user_id($user_id){
	
	
	
	 	global $wpdb;
 
		 
		$results = $wpdb->get_results( 	$wpdb->prepare(
	"SELECT * FROM {$wpdb->prefix}saksh_bookings  WHERE `user_id` =%d",  
$user_id
) );
	
	
     $user_info = get_userdata($user_id);
     
     echo "<div class='wrap'><div class='card'>";
      echo 'Username: ' . esc_attr($user_info->user_login) . "<br />";



echo "</div></div>";

	?>
	
	
		<div class="  wrap">
  
		  <h1 class="wp-heading-inline">
		      
		      
		     
New bookings</h1>  

	<?php
		
	 
	 
	 
	 saksh_report_table_view($results);
	 
	 
	 echo "</div>";


 
	
	
}


function saksh_booking_by_date($request_date){
	
	
	
	 	global $wpdb;
 
		
		
		 
 
 
	

		$results = $wpdb->get_results( 	$wpdb->prepare(
	"SELECT * FROM {$wpdb->prefix}saksh_bookings  WHERE `appointment_date` =date(%s)",  
$request_date
) );
		?>
		<div class="  wrap">
 
		    
		    
		  <h1 class="wp-heading-inline">
		      
		      
		     
New bookings</h1>  

<h2>
    
    
 Date <?php echo esc_attr($request_date); ?>
	
	
</h2>	
		<?php
		
	 
	 
	 
	 saksh_report_table_view($results);
	 
	 
	 echo "</div>";


 
	
	
}

function saksh_other_booking_by_date($request_date){
	
	
	
	 	global $wpdb;
 
		
		
		 
		
  
	

		$results = $wpdb->get_results(  	$wpdb->prepare(
	"SELECT * FROM {$wpdb->prefix}saksh_bookings  WHERE `appointment_date` =date(%s)",  
$request_date
)  );
		?>
		<div class="  wrap">
 
		    
		    
		  <h1 class="wp-heading-inline">
		      
		       
All list of booking </h1>  
	
		
<h2>
    
    
 Date <?php echo esc_attr( $request_date); ?>
	
	
</h2>
		<?php
	 saksh_report_table_view($results);
 
	 echo "</div>";


 
	
	
}




function saksh_report_table_view($results)
{
    
    
    
    
    
		
	 echo "<table class=' table wp-list-table widefat    '>";
	 
	  
	  
	  
      echo "<tr>";
      
       echo "<td> Booking ID </td>";
       
       
   
       
       echo "<td> Date   </td>";
   
       
       echo "<td> Time   </td>";
        
          echo "<td> Name </td>";
       
       echo "<td> Email </td>";
          
        echo "<td> Phone </td>"; 
       
   
        
          
          
          
       
       echo "<td>Created at </td>";
       
       
       
       echo "<td>Status </td>";
       
       echo "</tr>";
	 
	 
  foreach( $results as $res)
  {
       
      echo "<tr>";
      
       echo "<td>";
  
       
    $url= admin_url( 'admin.php?page=saksh_booking_view&id='.$res->id , 'https' );  
       
        
    
      echo  esc_attr( $res->id );
      
      echo "<a href=".esc_url($url)." target='_blank'> View </a>";
      
      
       echo "</td>";
       
       
       
    
      
       
       echo "<td>";
      echo  esc_attr($res->appointment_date );
       echo "</td>";
       
       echo "<td>";
      echo  esc_attr($res->start );
      
      echo "-";
      echo  esc_attr($res->end );
      
      
      echo "  ";
      echo  esc_attr($res->ampm );
       echo "</td>";
       
     
               
        echo "<td>";
      echo  esc_attr($res->name );
       
       echo "</td>";
       
       echo "<td>";
      echo  esc_attr($res->email );
       echo "</td>";
          
        echo "<td>";
      echo  esc_attr($res->phone );
       echo "</td>";
        
       
   
       
    
    
       echo "<td>";
      echo  esc_attr($res->created_at );
       echo "</td>";
       
       
       
       echo "<td>";
      echo  esc_attr($res->status );
       echo "</td>";
       
       
       
       
        
      echo "</tr>";
  }
   
 
	 echo "</table>";
 
	 echo "</div>";


 
}