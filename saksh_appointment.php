<?php
/*
Plugin Name: Saksh appointment booking system
Plugin URI: https://profiles.wordpress.org/susheelhbti/
Description: Discover the easiest way to schedule appointments with the saksh appointment booking system. Use  [SakshAppointmentCalendar] as shortcode and show calander.

Author: susheelhbti
Version: 2.0.8
Stable tag: 4.8.0
Author URI: https://profiles.wordpress.org/susheelhbti/
*/
   
 
 
  
 
defined( 'ABSPATH' ) || exit;

global $wpdb;

$wpdb->saksh_bookings =  $wpdb->prefix . "saksh_bookings";

include "saksh_booking.class.php";
 
 
 
 include "saksh_services_post_type.php";
 
 include "saksh_admin/saksh_admin_menu.php";
// include "saksh_admin/saksh_holidays.php";
 include "saksh_admin/saksh_support.php";
 
 
 include "saksh_admin/saksh_booking_view.php";
 
 
 //include "saksh_admin/saksh_edit_booking.php";
 
 include "saksh_booking_history.php";

include "saksh_widgets.php";
include "saksh_links.php";
include "saksh_sortcode.php";

 include "saksh_ajax.php";
 include "saksh_wchook.php";
 
// include "saksh_admin/admin_report.php";
 include "saksh_admin/saksh_reports.php";
  
// include "saksh_admin/time_slots.php";
 include "saksh_notification.php";
 
add_action('init', 'saksh_check_wc', 0);
   function saksh_check_wc() {
       
     
          
   
          
       
    
      if( !saksh_is_wc_available())    
       {
        
         //  add_action( 'admin_notices',  'saksh_admin_notices'  );
       }
       
       
       
     
      
    
       
	}
	
	
	
	
	
	
	
	 function saksh_admin_notices_demo_data() {
		?>
		<div class="  card">
			<p>
				<?php
				
			
			$url= 	admin_url( 'admin.php?page=saksh_plugin_support&demo=1', 'https' );
			
			
				
				
				
				echo esc_html ( 'Saksh appointment booking plugin offer demo data installation click here to do this ' , 'saksh' );  
				
			 
				
				
				
				
				
				?> 
			 
 <a target='_blank' href="<?php echo esc_url($url);?>" /> Install Demo</a> 
				
			</p>
		</div>
		<?php
	}
	
	
	
	
		  function saksh_admin_notices() {
		?>
		<div class="  card">
			<p>
				<?php echo esc_html_e( 'Saksh appointment booking plugin requires', 'saksh-wp-hotel-booking-lite' ); ?> 
				<a href="https://wordpress.org/plugins/woocommerce/">WooCommerce</a> <?php echo esc_html_e( 'plugins to be active!', 'saksh' ); ?>
			</p>
		</div>
		<?php
	}	
	

function saksh_scripts(){
      
    $url= plugins_url( '/css/sakshbs5.css', __FILE__ );
    
    
    
	wp_enqueue_style( 'sakshbs5-css',$url, '5.0.0',  true );
    
      
    $url= plugins_url( '/css/saksh.css', __FILE__ );
    
    
    
	wp_enqueue_style( 'saksh-css',$url, '1.0.0',  true );
    
     
 
       wp_enqueue_script('vue', "//cdn.jsdelivr.net/npm/vue@2", array(  ), '1.0.0',  true);
    
    wp_enqueue_script('axios', "//cdn.jsdelivr.net/npm/axios/dist/axios.min.js", array(  ), '1.0.0',  true);
    
   
	 $nonce = wp_create_nonce( "saksh"  );

      wp_localize_script( 'saksh_js', 'saksh_object', array( 'ajax_url' => admin_url('admin-ajax.php')) );
 



    wp_enqueue_script('saksh_jquery-ui', "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js", array( 'jquery' ), '5.3.3',  true);
     
      
      
    wp_enqueue_script('saksh_fullcalendar_js', "//cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js", array( 'jquery' ), '1.0.0',  true);
    

  
    wp_enqueue_script('saksh_js', plugins_url( '/js/saksh_scriptsV1.js', __FILE__ ), array( 'jquery' ), '1.0.0',  true);
    
    
    
    

         	
     wp_localize_script( 'saksh_js', 'saksh_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' )  ,'nounce'=>$nonce  ) );
             
        
      
      
      if( saksh_is_wc_available())    
       {
        
    
    
    
    global $woocommerce;
$checkout_page_url = function_exists( 'wc_get_cart_url' ) ? wc_get_checkout_url() : $woocommerce->cart->get_checkout_url();





     wp_localize_script( 'saksh_js', 'saksh_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ,"checkout_page_url" => $checkout_page_url    ,'nonce'=>$nonce )    );
       }
    
    
    
    
    
    
}
add_action('wp_enqueue_scripts', 'saksh_scripts');


add_action('admin_head', 'saksh_admin_css');

function saksh_admin_css() {
    
        $url= plugins_url( '/css/sakshbs5.css', __FILE__ );
    
    
    
    
  echo '<link rel="stylesheet" href="'.esc_url($url).'" type="text/css" media="all" />';
}



 

 function saksh_booking_complete_booking($query_data)
  {
  
   
  saksh_capture_data_to_log( __LINE__,$query_data) ;

    
      
      global $wpdb;
      
       
 $table_name= $wpdb->prefix ."saksh_bookings";
  
 
  $wpdb->insert( $table_name, $query_data );
 
 
 
  saksh_capture_data_to_log( __LINE__,[$wpdb->last_error]) ;


  }
  
  
  
function saksh_enqueue_vue_in_admin($hook) {

 $pre="appointments_page_";
 
 
 
 
$allowed_hooks = array( );
 
  
 

 $allowed_hooks[]= $pre. "saksh_booking_dashboard";
 

 $allowed_hooks[]= $pre. "saksh_wb_print_report";
 
 $allowed_hooks[]= $pre. "saksh_todays_booking";
 
 $allowed_hooks[]= $pre. "saksh_holidaysv2";
 
 $allowed_hooks[]= $pre. "saksh_time_slots_page";
 
 $allowed_hooks[]= $pre. "saksh_plugin_support";
 
 
 
if (!in_array($hook, $allowed_hooks)) {
return;
}
  

wp_enqueue_script('vue-js', 'https://cdn.jsdelivr.net/npm/vue@2', array(), '', true);


wp_enqueue_script('vue-jsaxios', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js', array(), '', true);



wp_enqueue_script('saksh_admin', plugin_dir_url(__FILE__) . 'js/saksh_admin.js', array('vue-js','vue-jsaxios'), '1.0', true);


}
add_action('admin_enqueue_scripts', 'saksh_enqueue_vue_in_admin');

	
 



function saksh_is_wc_available(){
    
             
      $active_plugins= (array) get_option( 'active_plugins', array() );
      
      
      if(in_array( "woocommerce/woocommerce.php",   $active_plugins))    
       {
        
        return true;
       }
    
    else 
    return false;
    
    
}

 // front end ajax
$ajax_actions=array("saksh_form_booking","saksh_get_form_data","saksh_post_events","saksh_delete_events","saksh_get_events","get_time_list"  ,"saksh_post_simple_appointment","saksh_holidays_list","saksh_timeslots_list");

foreach($ajax_actions as $ajax_action)
{

add_action( 'wp_ajax_'.$ajax_action, $ajax_action );
add_action( 'wp_ajax_nopriv_'.$ajax_action, $ajax_action );

} 


// admin side ajax
$ajax_actions=array("saksh_get_appointments","saksh_update_appointment" ,"create_new_time_slot","saksh_get_time_slots","saksh_delete_time_slot","saksh_create_new_time_slot"  ,"saksh_get_booking_info","saksh_booking_update_view","saksh_update__booking_status"   ,"saksh_holidays_db","saksh_update_holidays_db","saksh_time_slots_days","saksh_time_slots","saksh_time_slots_add");

foreach($ajax_actions as $ajax_action)
{

add_action( 'wp_ajax_'.$ajax_action, $ajax_action ); 

} 




function saksh_plugin_table_install()
{
    
    global $wpdb;




   
   
 
    $table_sql_system = "
 
CREATE TABLE   " . $wpdb->prefix ."saksh_bookings    (
  `id` int(11) NOT NULL AUTO_INCREMENT,
   `appointment_date` date DEFAULT NULL, 
  
  
   `start` varchar(200)   DEFAULT NULL,
  `end` varchar(200) DEFAULT NULL,
    `ampm` varchar(2)   DEFAULT NULL,
   `timezone` varchar(200)   DEFAULT NULL, 
     `timeslot` varchar(200)  DEFAULT NULL,
   
  `user_id` int(20) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
   `order_amount` double NOT NULL,
  `name` varchar(200)   DEFAULT NULL,
  `email` varchar(200)  DEFAULT NULL,
  `phone` varchar(200)  DEFAULT NULL,
  
  `status` varchar(20) DEFAULT 'Pending',
  `products_title` text   DEFAULT NULL,
  `services`  varchar(200)   DEFAULT NULL,
   `products` json DEFAULT NULL,
   
   
   
  `created_at` timestamp   DEFAULT current_timestamp(),
  
  
     PRIMARY KEY ( id )  
);
 
 
 

CREATE TABLE " . $wpdb->prefix ."saksh_availability (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status` enum('available','unavailable') NOT NULL,
  PRIMARY KEY ( id )  
)  ;

 
CREATE TABLE " . $wpdb->prefix ."time_slots   (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` int(10) DEFAULT NULL,
  `end_time` int(10) DEFAULT NULL,
  `ampm` varchar(4) DEFAULT NULL,
  `slots` varchar(20) NOT NULL,
  `day` varchar(20) NOT NULL,
  `user_id` int(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  
  PRIMARY KEY ( id )  
  
);

 
INSERT INTO  " . $wpdb->prefix ."time_slots (`id`, `start_time`, `end_time`, `ampm`, `slots`, `day`, `user_id`, `created_at`, `status`) VALUES
(4, 12, 1, 'pm', '10', 'Monday', 1, '2023-11-20 20:16:39', 'Pending'),
(5, 1, 2, 'pm', '10', 'Monday', 1, '2023-11-20 20:16:44', 'Pending'),
(6, 2, 3, 'pm', '10', 'Monday', 1, '2023-11-20 20:16:51', 'Pending'),
(7, 3, 4, 'pm', '10', 'Monday', 1, '2023-11-20 20:16:58', 'Pending'),
(8, 4, 5, 'pm', '10', 'Monday', 1, '2023-11-20 20:17:03', 'Pending'),
(9, 5, 6, 'pm', '10', 'Monday', 1, '2023-11-20 20:17:10', 'Pending'),
(10, 10, 11, 'am', '10', 'Tuesday', 1, '2023-11-21 01:16:07', 'Pending'),
(11, 11, 12, 'am', '10', 'Tuesday', 1, '2023-11-21 01:16:32', 'Pending'),
(12, 12, 1, 'pm', '10', 'Tuesday', 1, '2023-11-21 01:16:39', 'Pending'),
(13, 1, 2, 'pm', '10', 'Tuesday', 1, '2023-11-21 01:16:44', 'Pending'),
(14, 2, 3, 'pm', '10', 'Tuesday', 1, '2023-11-21 01:16:51', 'Pending'),
(15, 3, 4, 'pm', '10', 'Tuesday', 1, '2023-11-21 01:16:58', 'Pending'),
(16, 4, 5, 'pm', '10', 'Tuesday', 1, '2023-11-21 01:17:03', 'Pending'),
(17, 5, 6, 'pm', '10', 'Tuesday', 1, '2023-11-21 01:17:10', 'Pending'),
(18, 10, 11, 'am', '10', 'Wednesday', 1, '2023-11-21 01:16:07', 'Pending'),
(19, 11, 12, 'am', '10', 'Wednesday', 1, '2023-11-21 01:16:32', 'Pending'),
(20, 12, 1, 'pm', '10', 'Wednesday', 1, '2023-11-21 01:16:39', 'Pending'),
(21, 1, 2, 'pm', '10', 'Wednesday', 1, '2023-11-21 01:16:44', 'Pending'),
(22, 2, 3, 'pm', '10', 'Wednesday', 1, '2023-11-21 01:16:51', 'Pending'),
(23, 3, 4, 'pm', '10', 'Wednesday', 1, '2023-11-21 01:16:58', 'Pending'),
(24, 4, 5, 'pm', '10', 'Wednesday', 1, '2023-11-21 01:17:03', 'Pending'),
(25, 5, 6, 'pm', '10', 'Wednesday', 1, '2023-11-21 01:17:10', 'Pending'),
(26, 10, 11, 'am', '10', 'Thursday', 1, '2023-11-21 01:16:07', 'Pending'),
(27, 11, 12, 'am', '10', 'Thursday', 1, '2023-11-21 01:16:32', 'Pending'),
(28, 12, 1, 'pm', '10', 'Thursday', 1, '2023-11-21 01:16:39', 'Pending'),
(29, 1, 2, 'pm', '10', 'Thursday', 1, '2023-11-21 01:16:44', 'Pending'),
(30, 2, 3, 'pm', '10', 'Thursday', 1, '2023-11-21 01:16:51', 'Pending'),
(31, 3, 4, 'pm', '10', 'Thursday', 1, '2023-11-21 01:16:58', 'Pending'),
(32, 4, 5, 'pm', '10', 'Thursday', 1, '2023-11-21 01:17:03', 'Pending'),
(33, 5, 6, 'pm', '10', 'Thursday', 1, '2023-11-21 01:17:10', 'Pending'),
(34, 10, 11, 'am', '10', 'Friday', 1, '2023-11-21 01:16:07', 'Pending'),
(35, 11, 12, 'am', '10', 'Friday', 1, '2023-11-21 01:16:32', 'Pending'),
(36, 12, 1, 'pm', '10', 'Friday', 1, '2023-11-21 01:16:39', 'Pending'),
(37, 1, 2, 'pm', '10', 'Friday', 1, '2023-11-21 01:16:44', 'Pending'),
(38, 2, 3, 'pm', '10', 'Friday', 1, '2023-11-21 01:16:51', 'Pending'),
(39, 3, 4, 'pm', '10', 'Friday', 1, '2023-11-21 01:16:58', 'Pending'),
(40, 4, 5, 'pm', '10', 'Friday', 1, '2023-11-21 01:17:03', 'Pending'),
(41, 5, 6, 'pm', '10', 'Friday', 1, '2023-11-21 01:17:10', 'Pending'),
(42, 10, 11, 'am', '10', 'Saturday', 1, '2023-11-21 01:16:07', 'Pending'),
(43, 11, 12, 'am', '10', 'Saturday', 1, '2023-11-21 01:16:32', 'Pending'),
(44, 12, 1, 'pm', '10', 'Saturday', 1, '2023-11-21 01:16:39', 'Pending'),
(45, 1, 2, 'pm', '10', 'Saturday', 1, '2023-11-21 01:16:44', 'Pending'),
(46, 2, 3, 'pm', '10', 'Saturday', 1, '2023-11-21 01:16:51', 'Pending'),
(47, 3, 4, 'pm', '10', 'Saturday', 1, '2023-11-21 01:16:58', 'Pending'),
(48, 4, 5, 'pm', '10', 'Saturday', 1, '2023-11-21 01:17:03', 'Pending'),
(49, 5, 6, 'pm', '10', 'Saturday', 1, '2023-11-21 01:17:10', 'Pending'),
(50, 10, 11, 'am', '10', 'Monday', 1, '2023-11-21 01:16:07', 'Pending') ;


 

 

";

 




   
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');



    dbDelta($table_sql_system);
 
  
    
}



function saksh_fetch_data($url){
    
    
      if( !class_exists( 'WP_Filesystem_Direct' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
}
    
    $wpfsd = new WP_Filesystem_Direct( false );
    
    
    $dummy_data=$wpfsd->get_contents (  $url);

return $dummy_data;

  
   
   
}
function saksh_create_dummy_product(){
    
    
    
 $dummy_data= saksh_fetch_data(  "https://www.sakshamapp.com/dummy_data/appoint.php");
 

 

 

   $dummy_data=json_decode(   $dummy_data);
   
   $pages=  $dummy_data->pages;
   
  
 
   
   
 foreach($pages as $page)
 {

wp_insert_post( $page ); 
 
 }
 
 
 
 
  
  

 
 
     if( saksh_is_wc_available())    
       {
        
    
 $product_data=$dummy_data->product;
$term =wp_insert_term(
	'appointments' ,  
	'product_cat' 
);
 

      $product = new WC_Product_Simple();

$product->set_name( $product_data->title  ); // product title

$product->set_slug( $product_data->slug  );

$product->set_regular_price( $product_data->price   ); // in current shop currency

$product->set_short_description( $product_data->description  );

 
 
 
if(!is_wp_error($term))

{
 
$term_id=$term['term_id'];
 

$term_array= array($term_id )  ;

}
else
{
    
    $term_array= saksh_get_term_ids( 'appointments','product_cat');
    

    
}


 $product->set_category_ids( $term_array);
 
 
$product->save();


}

 
 echo "<div class='wrap   '>";
 
 echo "<div class='card   '>";
 
 
echo "If no error then task done successfully.";


echo "</div>";
echo "</div>";
}

 
     
     
     
register_activation_hook(__FILE__, 'saksh_plugin_table_install');




  function saksh_get_term_ids($name__like,$taxonomy){
      
      

  $terms = get_terms([
    'taxonomy' => $taxonomy,
    'name__like' => $name__like ,
    'hide_empty' => false,
]);

$term_id=array();

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
 
	foreach ( $terms as $term ) {
	$term_id[]= $term->term_id  ;
	}
 
} 

return $term_id;

 
  }
  
  
  //saksh_capture_data_to_log(__LINE__,["sdfsdf"]);
  
  
  function saksh_capture_data_to_log($line,$data)
  {
      
      
      $file = 'people.txt';

  
$my_post = array(
'post_title'    => $line,
'post_content'  =>"Saksh log---<hr />". print_r([$data],true) 
);

 
 

//file_put_contents($file, print_r($my_post,true), FILE_APPEND | LOCK_EX);


// Insert the post into the database
   wp_insert_post( $my_post );

  
 
       
  }
  
  
  
  
function saksh_get_time_ago( $time )
{
    $time_difference = $time-time() ;

   if( $time_difference < 1 ) { return 'Completed'; }
    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $time_difference / $secs;

        if( $d >= 1 )
        {
            $t = round( $d );
            return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . '    to Check in';
        }
    }
}
 

 add_filter ('manage_users_columns', 'saksh_users_columns') ;
add_filter ('manage_users_custom_column', 'saksh_users_custom_column', 10, 3) ;

function saksh_users_columns ($cols)
{
    $cols['author_page'] = 'Apointments' ;

    return ($cols) ;
}

function saksh_users_custom_column ($default, $column_name, $user_id)
{
    
    
    
       
    $url= admin_url( 'admin.php?page=booking_dashboard&user_id='.$user_id , 'https' );  
       
        
     
      
      $default .=  "<a href=".esc_url($url)." target='_blank'> View Apointments</a>";
      
      
      
      
       
        

    return ($default) ;
}