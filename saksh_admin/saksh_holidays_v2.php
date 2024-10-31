 

<div   class="susheelhbti  saksh b5">

<div id="holiday_app" class=" ">
<div class="row   ">
    <div class="col 6">
        <h3>Black are available and red are unavailable</h3>
            <div class="row   ">
<div class="col" v-for="(month, index) in months" :key="index">
<calendar :month="month" :availability="availability" @date-selected="selectDate"></calendar>
</div>


</div>
        
    </div>
  <div class="col  -3">
<div v-if="selectedDate" class="mt-3">
<h4>Selected Date: {{ selectedDate }}</h4>
<button class="btn btn-success" @click="markDate('available')">Mark as Available</button>
<button class="btn btn-danger" @click="markDate('unavailable')">Mark as Unavailable</button>

<p>
    By default all dates are available

    
</p>

</div>
</div>
</div>
</div>
</div>
 