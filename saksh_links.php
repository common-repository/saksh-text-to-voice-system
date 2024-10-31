<?php


include "vendor/autoload.php";
use Spatie\CalendarLinks\Link;

// echo saksh_get_calander_links( "sdf");
 
 
 
function saksh_get_calander_links($link_title,$date_start,$date_end)
{
 
 
 ob_start();
 
 
 $links= saksh_get_links($link_title,$date_start,$date_end);
  
  
  echo "<div class='saksh_calander_links' > ";
  
 foreach($links as $key=>$value)  {
    
    
    ?>
    
    <a target="_blank" href="<?php echo  esc_url($value);?>" >
        
     
        
        
        <?php echo '<img class="img-fluid" src="' . esc_url( plugins_url( 'img/'.$key.".png", __FILE__ ) ) . '" > ';
        
        ?>
        
        
        </a>
    
    <?php
  }
  
  echo "</div>";
  
  $content = ob_get_clean();
return $content;

}



function saksh_get_links($link_title,$date_start,$date_end)
{
    
 
$from =$date_start;
$to =$date_end;
 


$link = Link::create($link_title, $from, $to);

$links=new stdClass();

// Generate a link to create an event on Google calendar
$links->google = $link->google();

// Generate a link to create an event on Yahoo calendar
 //$links->yahoo =  $link->yahoo();

// Generate a link to create an event on outlook.live.com calendar
 $links->webOutlook =  $link->webOutlook();

// Generate a link to create an event on outlook.office.com calendar
 //$links->webOffice =  $link->webOffice();

 
 
//$links->ics =  $link->ics();
return $links;

}