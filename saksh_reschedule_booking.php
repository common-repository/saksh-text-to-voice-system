

 	<form id='formId' method="post" class=" " action=''>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-body">
     
     
     
     
      
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
               id='case' value="reschedule"
               name='case' />  
               
               
      
        	
        	   <input type='hidden' 
               id='id'  
               name='id' />  
               
               
       
    <div class="mb-3">
    <label for="skashInputPassword1" class="form-label">Appointment Date</label>
    <input type="date" id="appointment_date" class="form-control    saksh_get_booking_info_appointment_date"      name="appointment_date"  >
  </div>   
    <div class="mb-3">
        
        
        
    <label for="skashInputPassword1" class="form-label">Timeslot</label>
      
  
  <select class="form-select" id="timeslot" name="timeslot" aria-label="Timeslot">
 
 
   
 </select>
</div>

     <button type="submit" class="btn btn-primary">Submit</button>
    
          
     
  
 
 
 
 
      </div>
       
    </div>
  </div>
</div>

 </form>
 