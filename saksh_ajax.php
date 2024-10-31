<?php



defined( 'ABSPATH' ) || exit;

 


function saksh_create_new_time_slot()
{
   
   
    
 
 global $wpdb;
 
 $table_name= $wpdb->prefix ."time_slots";
 
  
    
    
$data = json_decode(file_get_contents('php://input'), true);
$day =sanitize_text_field( $data['day']);

  $start_time =sanitize_text_field( $data['startTime']);

  $end_time = sanitize_text_field($data['endTime'] );

  $ampm = sanitize_text_field($data['ampm']);

  
     
    
        
      $res=  $wpdb->insert(
 $table_name,
	array(
		'day' => $day,
	 
		'start_time' => $start_time,
		'end_time' => $end_time,
		'ampm' => $ampm,
		
	 	"user_id" =>  get_current_user_id(),
	 
	),
	array(
		'%s',
		'%s',	'%s',	 
			'%s',
		'%s'
	)
);


if($res==false)
{
    echo json_encode(['error' => 'Request failed!']); 
    die();
}

 else
 {
     
      echo json_encode(['message' => 'Request Successfully']); 
    die();
 }
    
    
}


function saksh_get_time_slots(){
    
    
$data = json_decode(file_get_contents('php://input'), true);
$day = sanitize_text_field ($_REQUEST['day']);
    
 
	global $wpdb;  
 
 
$query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}time_slots WHERE day = %s", $day);


 
 
// Execute the query
$results = $wpdb->get_results($query, 'ARRAY_A');

 

 if ($wpdb->last_error) {
echo json_encode(['error' => 'Database query error: ' . $wpdb->last_error]);
wp_die();
}
 
 
 
		echo json_encode($results);
		 
		

	wp_die(); // this is required to terminate immediately and return a proper response
}



function saksh_delete_time_slot()  {
 

$data = json_decode(file_get_contents('php://input'), true);
$id = sanitize_text_field($data['id']);

  

 
	global $wpdb; // this is how you get access to the database
 
 
$res=$wpdb->query($wpdb->prepare("delete  from  {$wpdb->prefix}time_slots  where id=%d     "  ,$id));

    echo json_encode(['success'=>true, 'message' => 'Request Successfully.'.$id]); 
   

	wp_die(); 
}
 
function saksh_time_slots_add(){
    
         
$data = json_decode(file_get_contents('php://input'), true);
 
 $d_ar=array();
 
 
}
 
function saksh_time_slots1(){
    
    
$data = json_decode(file_get_contents('php://input'), true);
$day = $data['day'];

$times = [];

if (!in_array($day, ['Saturday', 'Sunday'])) {
$start = strtotime('09:00');
$end = strtotime('17:00');

while ($start < $end) {
$times[] = date('H:i', $start);
$start = strtotime('+30 minutes', $start);
}
}

echo json_encode($times);  wp_die(); 
}

function saksh_time_slots_days(){
    
    
    $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
echo json_encode($days);   wp_die(); 
}


function saksh_update_holidays_db(){
    
  
     
$date=$_POST['date'];

     
$status=$_POST['status'];

 

	global $wpdb;  
	
 
		   $table=$wpdb->prefix."saksh_availability";
		
		
		
		$wpdb->delete(
    $table,
    array(
        'date' => $date // value in column to target for deletion
    ),
    array(
        '%s' // format of value being targeted for deletion
    )
);



$wpdb->insert(
     $table,
    array(
        'date' => $date,
        'status' => $status,
    ),
    array(
        '%s',
        '%s',
    )
);
 
 $ar=array();
 
 $ar['status']=true;
 $ar['message']="Success";
 
 

echo json_encode($ar);
       wp_die(); 
    
}

function saksh_holidays_db(){
    
      

	global $wpdb;  
	
 
		
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}saksh_availability  "  , 'ARRAY_A' );

 

echo json_encode($results);
       wp_die(); 
    
}





function saksh_generate_TimeSlots( ) {
    
    global $wpdb;
    
    $day="Monday";
    
    
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}time_slots WHERE day = %s", $day ) , 'ARRAY_A' );

 
 
 
 
		return  $results;
		 
		
 
}
 



function saksh_timeslots_list( ){
    
    
     
 $timeSlots = saksh_generate_TimeSlots( );
 
 
$ar=array();
$ar['timeSlots']=$timeSlots ;

echo json_encode($ar);
         wp_die();  
         

}
 
 function saksh_holidays_list(){
     
     // Set the content type to application/json
header('Content-Type: application/json');

// Define an array of holidays
$holidays = [
'2024-08-15', // Independence Day
'2024-08-31', // Example Holiday
'2024-12-25', // Christmas
'2024-01-01', // New Year's Day
'2024-10-02'  // Gandhi Jayanti
];

// Create an associative array to hold the holidays
$response = [
'holidays' => $holidays
];

// Encode the array to JSON and output it
echo json_encode($response);
         wp_die();  
        
 }
 
 
 // saksh_capture_data_to_log(__LINE__,['POST']);
  
 function saksh_post_simple_appointment(){
     
 
   

  
$json = file_get_contents('php://input');

 
$data = json_decode($json, true);
   
    
     saksh_capture_data_to_log(__LINE__,$data);
    
     
     
$name = htmlspecialchars($data['name']);
$email = htmlspecialchars($data['email']);
$phone = htmlspecialchars($data['phone']);
$message = htmlspecialchars($data['message']);
$date = htmlspecialchars($data['date']);
$start_time = htmlspecialchars($data['start_time']);
$end_time = htmlspecialchars($data['end_time']);
$ampm = htmlspecialchars($data['ampm']);
 $services =  implode(',',$data['services'])   ;



   $saksh_booking_data=array();
   
   
   
   
    
     
  $date = date_create( $date);

	 
     $saksh_booking_data['appointment_date']=date_format($date, 'Y-m-d');
   
   
	  

     $saksh_booking_data['start']= $start_time ; 
   
 
	
	
      $saksh_booking_data['end']= $end_time ;
     
   	
	
     $saksh_booking_data['ampm']= $ampm;
     $saksh_booking_data['services']= json_encode($services);
    
   
   
   $saksh_booking_data['order_id']= 0;
   
   $saksh_booking_data['products_title']=$message;
   
    
  
   
   
   
   if ( is_user_logged_in() ) {
       $user = wp_get_current_user();
    
    $user_id = $user->ID; }
    
    else
    $user_id =0;
    
   $saksh_booking_data['user_id']=$user_id;
    
   
   $saksh_booking_data['email']=$email;
   $saksh_booking_data['name']=$name;
   
   
 
     
   $saksh_booking_data['order_amount']= 0;
    
     
 $saksh_booking_data['phone']=$phone; 
 
 
 
 //$saksh_booking_data['status']= "wc-completed";  
 


     saksh_capture_data_to_log(__LINE__,$saksh_booking_data);
     
 

  saksh_booking_capture_data($saksh_booking_data);
   
   
echo 'Your message has been sent successfully!';

 
         wp_die();  
     
 }

 function saksh_booking_update_view()
 {
     
     
   saksh_booking_update_admin();
 
    wp_die();  
     
 } 

 function saksh_get_time_slots1(){
     
     $day=$_REQUEST['day'];
     
     
    $data= saksh_getTimeslots( $day);
    
    
 echo wp_json_encode($data); 
     die();
  
  
    
 }
 

 
 
function saksh_get_timeslot($id)
{
    
    
    
	global $wpdb;  
	
 
		
$row= $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}time_slots WHERE id = %d", $id )   );

 
	return $row;
	
	
		 
    
}
 
 
 
function saksh_getTimeslots($day)
{
    
    
    
	global $wpdb;  
	
 
		
$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}time_slots WHERE day = %s", $day ) , 'ARRAY_A' );

 
	return $results;
	
	
		 
    
}
 
function saksh_post_events() {
  
 
  
 
	   if ( ! wp_verify_nonce(sanitize_text_field( $_REQUEST['nonce']),   "saksh" ) ) {
        wp_die ( 'Busted!');
    }
 
 global $wpdb;
 
 $table_name= $wpdb->prefix ."saksh_bookings";
 
 
  
    $appointment_date =sanitize_text_field( $_REQUEST['appointment_date']);
    
 
  
  
    $start_end_ampm_r =  sanitize_text_field($_REQUEST['start_end_ampm']) ; 
    
  
    $start_end_ampm = explode("-",$start_end_ampm_r); 
    
    
    $start=$start_end_ampm[0];
    
    $end=$start_end_ampm[1];
    
    $ampm=$start_end_ampm[2];
    
    
    
    
    $saksh_products=   wp_unslash(   (  $_REQUEST['saksh_products']) ) ; 
 //SANITIZE DONE WHEN ACCESS EACH ITEM FROM THE ARRAY at line 132 
    
     
  
       $cart_item_data = array( 'appointment_date' => $appointment_date , "start"=>$start  ,"end"=>$end  ,"ampm"=>$ampm  , "staff"=>1);
	 
 
	  saksh_capture_data_to_log( __LINE__,$cart_item_data) ;
	  
 
	  saksh_capture_data_to_log( __LINE__,$saksh_products) ;
	  
	  
	 
	 foreach($saksh_products as $saksh_product)
	 {
	     
	     
	     
	WC()->cart->add_to_cart( sanitize_text_field( $saksh_product  ) , 1, '', array(), $cart_item_data);
	 
	 }
	  
	  
	
	
	
 echo wp_json_encode($cart_item_data); 
     die();
  
    
    


 
}

function saksh_booking_update_admin(){
 
     
     
         $sbnew =new saksh_booking();
     
     $row=$sbnew->saksh_booking_update_admin();
     
     echo wp_json_encode($row);
    wp_die( );  
     
}
 
function saksh_update__booking_status(){
    
    

    
    
         $sbnew =new saksh_booking();
     
     $row=$sbnew->saksh_update__booking_status();
     
     
    

  echo wp_json_encode($row);
    wp_die( );  
     
     
}

  function  saksh_get_booking_info()
 {
     
 
     
     
     $sbnew =new saksh_booking();
     
     $row=$sbnew->saksh_get_booking_info();
     
     
     

 echo wp_json_encode($row);
    wp_die();  
     
 }



 function saksh_get_form_data()
 {
     
     echo esc_html ( saksh_form_booking( ));
     
     die();
 }
 
 