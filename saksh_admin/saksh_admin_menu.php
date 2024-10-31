<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 // Define constants
define( 'PLUGIN_SLUG', 'saksh__booking' );
define( 'PLUGIN_ROLE', 'manage_options' );
define( 'PLUGIN_DOMAIN', 'saksh' );
 
add_action( 'admin_menu', 'saksh_register_your_plugin_menu', 9 );

function saksh_register_your_plugin_menu() {
	// add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, callable $callback = ”, string $icon_url = ”, int|float $position = null ): string
	
	
	
	add_menu_page(
		__( 'Appointment',  'saksh' ),
		'appointments',
		'manage_options',
		'saksh__booking',
		false,
		'dashicons-admin-generic',
	 75
	);



// add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $callback = ”, int|float $position = null ): string|false

	add_submenu_page(
		'saksh__booking',
		'Appointment',
		'Appointment',
		'manage_options',
		'saksh__booking',
		'saksh_booking_dashboard'
	);
	
	



	
		add_submenu_page(
		'saksh__booking',
		'Bookings  ',
		'Bookings  ',
		'manage_options',
		"booking_dashboard",
		'saksh_wb_print_report' 
	);
	
	
		add_submenu_page(
		'saksh__booking',
		'Todays Booking' ,
		'Todays Booking',
		'manage_options',
		"saksh_todays_booking",
		'saksh_todays_booking'
	);
	
		add_submenu_page(
		'saksh__booking',
		'Holidays' ,
		'Holidays' ,
		'manage_options',
		"saksh_holidays",
		'saksh_holidays'
	);
		add_submenu_page(
		'saksh__booking',
		'Holidays2' ,
		'Holidays2' ,
		'manage_options',
		"saksh_holidaysv2",
		'saksh_holidaysv2'
	);
	
	
 add_submenu_page(
		'saksh__booking',
		'Time slots' ,
		'Time slots' ,
		'manage_options',
		"saksh_time_slots_page",
		'saksh_time_slots_page'
	);
 
	add_submenu_page(
		'saksh__booking',
		'Support' ,
		'Support',
		'manage_options',
		"saksh_plugin_support",
		"saksh_plugin_support"
	); 
	
	
	
	//  extra menu


		add_menu_page(
		__( 'Appointment Bookings',  'saksh' ),
		'Appointment Bookings',
		'manage_options',
		'saksh__booking_hidden',
		false,
		'dashicons-admin-generic',
	 75
	);


	add_submenu_page(
		'saksh__booking_hidden',
		'Appointment Bookings',
		'Appointment Bookings',
		'manage_options',
		'saksh__booking_hidden',
		'saksh_booking_dashboard'
	);
	
	
 
	add_submenu_page(
		'saksh__booking_hidden',
		'Appointment Bookings',
		'Appointment Bookings',
		'manage_options',
		'saksh_booking_view',
		'saksh_booking_view'
	);
	
	
	
  
  remove_menu_page('saksh__booking_hidden');
}
  
 function saksh_holidays(   ) {
 
	
//saksh_plugin_support();
    
	  
  	include "saksh_holidays.php" ;
    
 }
  
 
 function saksh_holidaysv2(   ) {
 
	
//saksh_plugin_support();
    
	  
 	include "saksh_holidays_v2.php" ;
    
 
   

}
 
 function saksh_time_slots_page()
 {
    
    
  include "saksh_time_slots_page.php" ;
    
 }   
 
 
 
 
 
 
 
  
  
 
 
 
 
 
 function saksh_booking_dashboard()
 {
    
    do_action("saksh_booking_dashboard_above");
    
    

    
 }  


function saksh_booking_dashboard_above2() {

 saksh_plugin_support();
 
 
 ?>
 
 <div class='wrap   '>
     
      <div class='card   '>
     <h4>This plugin offer 3 shortcodes 
     </h4>
     
     <p>
    [SakshAppointmentCalendar product_cat="appointments"] this show the booking page where user can do bookings etc.
     </p>
     
     
     <p> 
     [SakshBookingHistory] This return the detials about booking history for the front view user
     </p>
     
     <p>[SakshSimpleBooking]    This can be used if you wanted only a simple booking page</p>
     </div>
     
     </div>
 
 
 <?php
 
    
}
add_action('saksh_booking_dashboard_above','saksh_booking_dashboard_above2',8);


 function saksh_time_slots_pag22e()
 {
       
     
    
    $s=new Saksh_slots_master();
     
    $s->saksh_slot_master_page();
 }  




 
