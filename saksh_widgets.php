<?php



add_action('saksh_date_wise_booking','saksh_booking_dashboard_widgets' , 10);


function saksh_booking_dashboard_widgets(){
    
    
    $sb=new saksh_booking();
    
    
    ?>
    
    <div class="wrap">
        
        
    <div class="card">
     <h1>   
        <?php
        
     echo $sb->saksh_get_total_booking();
        
        ?></h1>
        
        Appointment(s)
        
    </div>
        
    </div>
    <?php
 
}