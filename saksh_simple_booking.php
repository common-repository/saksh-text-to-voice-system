 

<div id="app">
    


    
<div v-if="!successMessage">
<?php
$posts = get_posts([
'post_type' => 'services'
]);
 

foreach ($posts as $post) {
?>
<input type="checkbox" id="checkbox" value="<?php echo $post->post_title; ?>" v-model="services"  
 />
<label for="checkbox"><?php echo $post->post_title; ?></label>
<?php
}

 
?>
</div>


<div v-if="!successMessage">
<h2>Current Month</h2>
<div class="calendar">
<div class="day" v-for="day in currentMonthDays" :key="day.date" :class="{ holiday: day.isHoliday }" @click="selectDate(day)">
{{ day.date }}
</div>
</div>

<h2>Next Month</h2>
<div class="calendar">
<div class="day" v-for="day in nextMonthDays" :key="day.date" :class="{ holiday: day.isHoliday }" @click="selectDate(day)">
{{ day.date }}
</div>
</div>

<div class="selected-date red-text" v-if="selectedDate">
Selected Date: {{ selectedDate }}
</div>

<div class="time-slots" v-if="selectedDate && !isHoliday">
<h3>Select a Time Slot for {{ selectedDate }}</h3>
<div class="time-slot red-text" v-for="time in timeSlots" :key="time" @click="selectTime(time)">
{{ time.start_time }}-{{ time.end_time }} {{ time.ampm }}
</div>
</div>

<div class="selected-date red-text" v-if="isHoliday">
No time available for this date.
</div>

<div class="selected-date red-text" v-if="selectedTime">
Selected Time: {{ selectedTime.start_time }}-{{ selectedTime.end_time }} {{ selectedTime.ampm }} on {{ selectedDate }}
</div>

<div class="contact-form" v-if="selectedTime && !successMessage">
<h3>Contact Form</h3>
<form @submit.prevent="submitForm">
    
 

<input type="text" v-model="name" placeholder="Your Name" required>
<input type="email" v-model="email" placeholder="Your Email" required>
<textarea v-model="message" placeholder="Your Message" required></textarea>
<button type="submit">Submit</button>
</form>
<div class="loading-bar" v-if="isLoading"></div>
</div>
</div>

<div class="success-message" v-if="successMessage">
<div class="confirmation">
<p><strong>Name:</strong> {{ confirmedName }}</p>
<p><strong>Email:</strong> {{ confirmedEmail }}</p>
<p><strong>Message:</strong> {{ confirmedMessage }}</p>
<p><strong>Date:</strong> {{ confirmedDate }}</p>
<p><strong>Time:</strong> {{ confirmedTime.start_time }}-{{ confirmedTime.end_time }} {{ confirmedTime.ampm }}</p>
</div>
{{ successMessage }}
</div>



</div>