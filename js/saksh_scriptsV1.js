jQuery(document).ready( function($ ) {
  


  
  
  const exampleModal = document.getElementById('exampleModal')
if (exampleModal) {
  exampleModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const id = button.getAttribute('data-bs-id')
     
     var modal = $(this) 
  
  modal.find('.modal-body input#id').val(id)
   
   
    
    
    
   var appointment_date = button.getAttribute('data-bs-appointment_date')  
   
 modal.find('.modal-body input#appointment_date').val(appointment_date)
    
      url =   saksh_object.ajax_url +"?action=saksh_get_time_slots&day=tuesday&dataType=JSON";
      
      var timeslot_old = button.getAttribute('data-bs-timeslot') ; 
    
    
      $.ajax({
              url: url ,  
             
            dataType: 'json',
            cache: false,
            success: function (data) {
                
                $.each(data, function (index, res) {
                 
                 
   
                  var timeslot= res.start_time+"-"+res.end_time+" "+res.ampm;
                
                if(timeslot_old===timeslot){
     var option = $("<option selected></option>");
     option.text(timeslot);
     option.val(res.id);
                }
                
                else
                {
                    var option = $("<option></option>");
     option.text(timeslot);
     option.val(res.id);
                
                }
                
                
  modal.find('.modal-body select#timeslot').append(option);
  
  
                })
            }
        });
        
 
   
 
   
   
   
 
 
   
     
     
     //$("'.modal-body  #appointment_date'").append(option);
     
     
 
 
//  modal.find('.modal-body select#timeslot').append(option);
  
  })
}
 
  var calendarEl = document.getElementById('saksh_appointment_calendarV1');


       
if(calendarEl  ) {
    
    
    
       
       
        




  var calendar = new FullCalendar.Calendar(calendarEl, {
      
      
     selectable: true,
  
    themeSystem: 'bootstrap5', // important!
      
          initialView: 'dayGridMonth'
        });
        
        
       

calendar.on('dateClick', function(info) {
  
  
   saksh_show_form(info.dateStr );
   
   jQuery("#selected_date").val(info.dateStr) ;
   
   
});

}
         

jQuery('.saksh_checkbox').on('change', function() { 
   
   //calendarEl.visble=false;
   
    
     // jQuery(".saksh_appointment_calendar").css("display", "inline"); 
    
     calendar.render();
        
});

 

 
jQuery( ".timeslotsblock" ).on( "click", function() {
 
  
 
  
  var saksh_products = new Array(); 
        
    url =   saksh_object.ajax_url +"?action=saksh_post_events&ab=222";


jQuery('input:checkbox[name=saksh_products]:checked').each(function() 
    {
     
      
      
         saksh_products.push(jQuery(this).val());
         
         
    });
    
    

    
 var formData = {
      appointment_date :jQuery("#selected_date").val(),
      start_end_ampm:this.id,
       saksh_products:saksh_products,
       
       nonce: saksh_object.nonce
    };
   
    
    
        jQuery.ajax({
            url: url,  
             
            data:formData,  
              dataType: "json",
      encode: true,
     
      
            type: "post",
            success:function(data){
              
              console.log(data);

   window.location.href = saksh_object.checkout_page_url;

            },
            error:function (){}
        });
    
} );





   });
        



function saksh_show_form( d)
{
      jQuery("#saksh_appointment_timeblock").html(d);
    
     jQuery("#timeslots").css("display", "inline"); 
    
    
    

 
 
 
 
    

}

function saksh_get_time_slots( day )
{
 
 
    
       	var data = {
			'action': 'saksh_get_time_slots' ,
				'day': day  , 'dataType': 'JSON' 
		};
 
 
 console.log(date);
 
 
		jQuery.getJSON(saksh_object.ajax_url , data, function(response ) {
		 
			 
 
                 
	});
   
   
   
   
}
  




// vue js code for simple booking . our plan is to convert whole project to vue js
 let AjaxUrl = saksh_object.ajax_url;


 


new Vue({
el: '#app',


data: {
services: [], // Initialize services as an array
currentMonthDays: [],
nextMonthDays: [],
selectedDate: null,
selectedTime: null,
timeSlots: [],
name: '',
email: '',
message: '',
isHoliday: false,
holidays: [],
isLoading: false,
successMessage: '',
confirmedName: '',
confirmedEmail: '',
confirmedMessage: '',
confirmedDate: '',
confirmedTime: '',
monthNames: [
"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
]
},



async created() {
await this.fetchHolidays();
this.generateDays();
},



methods: {
    
    
    
generateDays() {
let today = new Date();
let currentMonth = today.getMonth();
let nextMonth = (currentMonth + 1) % 12;
let year = today.getFullYear();
let daysInCurrentMonth = new Date(year, currentMonth + 1, 0).getDate();
let daysInNextMonth = new Date(year, nextMonth + 1, 0).getDate();

// Add days of the current month
for (let i = today.getDate(); i <= daysInCurrentMonth; i++) {
let dateStr = `${i} ${this.monthNames[currentMonth]}`;
let isHoliday = this.checkIfHoliday(dateStr, currentMonth + 1);
this.currentMonthDays.push({
date: dateStr,
isHoliday: isHoliday,
year: year
});
}

// Add days of the next month
for (let i = 1; i <= daysInNextMonth; i++) {
let dateStr = `${i} ${this.monthNames[nextMonth]}`;
let isHoliday = this.checkIfHoliday(dateStr, nextMonth + 1);
this.nextMonthDays.push({
date: dateStr,
isHoliday: isHoliday,
year: year
});
}
},




async fetchHolidays() {
try {
let response = await axios.get(AjaxUrl + '?action=saksh_holidays_list');
this.holidays = response.data.holidays;
console.log(this.holidays);
} catch (error) {
console.error('Error fetching holidays:', error);
}
},



selectDate(day) {
this.selectedDate = day.date + " " + day.year;
this.isHoliday = day.isHoliday;
if (!this.isHoliday) {
this.fetchTimeSlots(day.date);
}
},



async fetchTimeSlots(day) {
this.isLoading = true;
try {
let response = await axios.get(AjaxUrl + `?action=saksh_timeslots_list&date=${day}`);
this.timeSlots = response.data.timeSlots;
this.isLoading = false;
} catch (error) {
console.error('Error fetching time slots:', error);
this.isLoading = false;
}
},
selectTime(selectedTimeSlot) {
    
    
this.selectedTime = selectedTimeSlot;
},
checkIfHoliday(day, month) {
// Convert selected date to a comparable format
let dateParts = day.split(' ');
let dateStr = `2024-${month < 10 ? '0' + month : month}-${dateParts[0] < 10 ? '0' + dateParts[0] : dateParts[0]}`;

return this.holidays.includes(dateStr);
},




async submitForm() {
    
 
this.isLoading = true;
this.successMessage = '';

const data = {
name: this.name,
email: this.email,
message: this.message,
date: this.selectedDate,
start_time: this.selectedTime.start_time,
end_time: this.selectedTime.end_time,
ampm: this.selectedTime.ampm,
services: this.services,
action: 'saksh_post_simple_appointment'
};

 
 
try { 
let response = await axios.post(AjaxUrl+"?action=saksh_post_simple_appointment", data, {
headers: {
'Content-Type': 'application/json'
}
});

 

this.isLoading = false;
this.successMessage = 'Your message has been sent successfully!';
// Store confirmed values
this.confirmedName = this.name;
this.confirmedEmail = this.email;
this.confirmedMessage = this.message;
this.confirmedDate = this.selectedDate;
this.confirmedTime = this.selectedTime;
// Reset form fields
this.name = '';
this.email = '';
this.message = '';
this.selectedDate = null;
this.selectedTime = null;
this.services = []; // Reset services


 
} catch (error) {
this.isLoading = false;
this.successMessage = 'There was a problem sending your message. Please try again.';
console.error('Error:', error);
}
 
}



}
});
