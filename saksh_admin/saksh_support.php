<?php

  function saksh_plugin_support()
 {
 
      
   if(isset($_GET['demo'] ))
   
   {
   
   
    
 
 
   if(sanitize_text_field($_GET['demo'])==1)
   
   saksh_plugin_table_install();
   saksh_create_dummy_product();
 
   }
  
  
   
 saksh_admin_notices_demo_data();
 
 
 echo "<div class='wrap   '>";
 
 echo "<div class='card   '>";
 
 
 
 $data= saksh_fetch_data( "https://sakshamapp.com/dummy_data/support.php");
 


 $data_json=json_decode($data);
 
 
 
    echo "<p>For 100% FREE  support whatsapp ".esc_attr ( $data_json->whatsapp)."  email ".esc_attr ($data_json->email)." website ".esc_url($data_json->url)."</p>";
    
 
    
  
 echo "</div>";   
 echo "</div>";   
    
 }
 
 