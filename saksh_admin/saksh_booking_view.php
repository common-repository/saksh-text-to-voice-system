<?php


 

 function saksh_booking_view() 
 
 {

      global $wpdb; 
	 
	 
		$id = sanitize_key( $_GET['id']);
		
?>

<div class="susheelhbti ">
<div class="wrap ">
<div class="card ">
<div class="p-3">
    
    
    
 <table class="table table-hover table-striped  table-bordered">
     
     <tr>
         
         <td>
             
             Booking ID
         </td>
         <td>
             
             
             <div class="saksh_get_booking_info_id"> </div>
             
            
             
         </td>
     </tr> <tr>
         
         <td>
             
             Booking Order ID
         </td>
         <td>
             
             
             <div class="saksh_get_booking_info_order_id"> </div>
             
            
             
         </td>
     </tr>
       <tr>
         
         <td>
             
         Appointment date
         </td>
         <td>
             <div class="saksh_get_booking_info_appointment_date"> </div>
             
            
             
         </td>
     </tr>
       <tr>
         
         <td> 
             
            Timeslot
         </td>
         <td>
             <div class="saksh_get_booking_timeslot"> </div>
             
            
             
         </td>
     </tr>
       <tr>
         
         <td>
             
          Products
         </td>
         <td>
             <div class="saksh_get_booking_info_products_title"> </div>
             
            
             
         </td>
     </tr>
       <tr>
         
         <td>
             
             Order amount
         </td>
         <td>
             <div class="saksh_get_booking_info_order_amount"> </div>
             
            
             
         </td>
     </tr>
       <tr>
         
         <td>
             
          Name
         </td>
         <td>
             <div class="saksh_get_booking_info_name"> </div>
             
            
             
         </td>
     </tr>
       <tr>
         
         <td>
             
          Email
         </td>
         <td>
             <div class="saksh_get_booking_info_email"> </div>
              
            
             
         </td>
     </tr>  <tr>
         
         <td>
             
         Phone
         </td>
         <td>
             <div class="saksh_get_booking_info_phone"> </div>
              
            
             
         </td>
     </tr>  <tr>
         
         <td>
             
         Created at
         </td>
         <td>
             <div class="saksh_get_booking_info_created_at"> </div>
             
            
             
         </td>
     </tr>  <tr>
         
         <td>
             
         Status
         </td>
         <td>
             <div class="saksh_get_booking_info_status"> </div>
             
             
         </td>
     </tr>   
     
  
     
 </table>
 
 
 
 </div>
 
 </div>
 
 </div>
 
 <div class="wrap ">
<div class="card ">
<div class="p-3">
    
 <h3>Update this booking</h3>


 	<form id='formId' class="row  mb-2" action=''>
      
     <?php
     
     
     
     $nonce = wp_create_nonce( "saksh"  );
        ?>	
        	   <input type='hidden' 
               id='nonce' value="<?php echo esc_attr($nonce); ?>"
               name='nonce'  />  
               
               
 
        	   <input type='hidden' 
               id='action' value="saksh_booking_update_view"
               name='action' />  
               
               
      
        	
        	   <input type='hidden' 
               id='id' value="<?php echo esc_attr($id);?>"
               name='id' />  
               
               
       
  
    
    <table class="table">
     <tr>
         
         <td>
             
          Appointment Date
         </td>
         <td>
            
             <input type="date" class="form-control    saksh_get_booking_info_appointment_date"      name="appointment_date"  >
             
         </td>
     </tr>
       <tr>
         
         <td>
             
           Timeslot
         </td>
         <td>
             
  
  <select class="form-select" name="timeslot" id="timeslotrs" aria-label="Default select example">
 </select>
 
     <button type="submit" class="btn btn-primary">Submit</button>
             
          
         </td>
     </tr>
     
     </table>
  
 
</form>
 
 <h3>Update status</h3>

  <?php
 
 		
		
$order_statuses = array(
    'wc-pending'    => _x( 'Pending payment', 'Order status', 'woocommerce' ),
    'wc-processing' => _x( 'Processing', 'Order status', 'woocommerce' ),
    'wc-on-hold'    => _x( 'On hold', 'Order status', 'woocommerce' ),
    'wc-completed'  => _x( 'Completed', 'Order status', 'woocommerce' ),
    'wc-cancelled'  => _x( 'Cancelled', 'Order status', 'woocommerce' ),
    'wc-refunded'   => _x( 'Refunded', 'Order status', 'woocommerce' ),
    'wc-failed'     => _x( 'Failed', 'Order status', 'woocommerce' ),
);

  

foreach($order_statuses as $key=> $order_status){
    
    
    ?>
    
    
  <a class='btn btn-success m-2'  onclick='saksh_booking_update_status("<?php  echo esc_attr($key);?>")' > 
    
    
  <?php  echo esc_attr($order_status);
    ?>
    
  
 </a > 
    <?php
    
    
    
}
?>

 
</div>
</div>
</div>
 
 <?php
 
 
  
     
 }
 
 
 
 
 
 
 





add_action( 'admin_footer', 'saksh_booking_view_js' ); // Write our JS below here

function saksh_booking_view_js() { ?>
	<script type="text/javascript" >
	 
	 

 
	    
	jQuery(document).ready(function($) {
	    
	    
 



         
            saksh_load_booking_data();
            
            
            
	
	 $("#formId").submit(function (event) {
    var formData = $( this ).serialize();
    
    
  
		jQuery.post(ajaxurl, formData, function(results) {
		    
	 saksh_load_booking_data();
    });
 
    event.preventDefault();
  });
  
  
  
	});
 
	
	
 

	
                
                
	
   function saksh_load_booking_data()
 
   {
       
       <?php
		$id = sanitize_key( $_GET['id']);
  
 
     $nonce = wp_create_nonce( "saksh" );
  ?>
       	var data = {
			'action': 'saksh_get_booking_info' ,
				'id': <?php echo esc_attr($id); ?> ,
					'nonce': '<?php echo esc_attr($nonce); ?>' ,
			 'dataType': 'JSON' 
		};
 
		jQuery.getJSON(ajaxurl, data, function(response ) {
		 
			 
 saksh_set_data_html(response);
    
    
                 
	});
   
   }
   
      
   
   
   function saksh_set_data_html(response)
   {
       
       
 
                jQuery(".saksh_get_booking_info_id" ).html( response.id);
 
                jQuery(".saksh_get_booking_info_order_id" ).html( response.order_id);
                
                
                jQuery(".saksh_get_booking_info_appointment_date" ).html( response.appointment_date);
                
                
                jQuery(".saksh_get_booking_timeslot" ).html( response.start +"-"+response.end +" "+response.ampm );
                
                
                jQuery(".saksh_get_booking_info_products_title" ).html( response.products_title);
                
                
                jQuery(".saksh_get_booking_info_order_amount" ).html( response.order_amount);
                
                
                jQuery(".saksh_get_booking_info_name" ).html(response.name);
                
                
                jQuery(".saksh_get_booking_info_email" ).html( response.email);
                
                jQuery(".saksh_get_booking_info_phone" ).html( response.phone);
                
                jQuery(".saksh_get_booking_info_created_at" ).html( response.created_at);
                
                jQuery(".saksh_get_booking_info_status" ).html( response.status); 
                
                 
                 jQuery("input[name='appointment_date']").val(response.appointment_date)
             
             
              jQuery("input[name='timeslot']").val( response.start +"-"+response.end +" "+response.ampm)
              
              
                     ///////////////
                     
                     
 url =   ajaxurl +"?action=saksh_get_time_slots&day=tuesday&dataType=JSON";
      
      var timeslot_old = response.start +"-"+response.end +" "+response.ampm; 
      
      jQuery.ajax({
              url: url ,  
             
            dataType: 'json',
            cache: false,
            success: function (data) {
                
                jQuery.each(data, function (index, res) {
                 
                 
   
                  var timeslot= res.start+"-"+res.end+" "+res.ampm;
                
                if(timeslot_old===timeslot){
     var option =jQuery("<option selected></option>");
     option.text(timeslot);
     option.val(res.id);
                }
                
                else
                {
                    var option =jQuery("<option></option>");
     option.text(timeslot);
     option.val(res.id);
                
                }
                 
 jQuery('select#timeslotrs').append(option);
  
  
                })
            }
        });
        
        
        //////////////////////////
                
                
   }
   
   
   
   
   
	 	 function    saksh_booking_update_status (new_status){
	        
	        
 <?php
		$id = sanitize_key( $_GET['id']);
 
     $nonce = wp_create_nonce( "saksh" );
  ?>
    	var data = {
			'action': 'saksh_update__booking_status' ,
				'id': <?php echo esc_attr($id); ?> ,
					'nonce': '<?php echo   esc_attr($nonce) ; ?>' ,
				'status': new_status ,
			 'dataType': 'JSON' 
		};
 
  
  
		
		
	 jQuery.ajax({
      type: 'POST',
      url: ajaxurl,
      data: data,
      dataType: "JSON",
      success: function(response) { saksh_set_data_html(response); }
});



		
		 
		  
	        
	    }
	    
  
	</script> <?php
} 