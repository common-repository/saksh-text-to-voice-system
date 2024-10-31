

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<style>



.saksh 

{
    
   
 
/*
.available {
background-color: #28a745;
color: white;
}
*/
.unavailable {
background-color: #dc3545 !important;
color: white  !important;
}

.selected {
    
background-color: #28a745  !important;
color: white  !important;
}
</style>


<div   class="susheelhbti  saksh b5">

<div id="app" class=" ">
<div class="row   ">
    <div class="col 6">
        <h3>Black are available and red or unavailable</h3>
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


<script>
Vue.component('calendar', {
props: ['month', 'availability'],
template: `
<div class="calendar">
<div>{{ month.name }} {{ month.year }}</div>
<table class="table table-dark table-sm table-sm   ">
<thead>
<tr>
<th v-for="day in days">{{ day }}</th>
</tr>
</thead>
<tbody>
<tr v-for="week in month.weeks">
<td v-for="day in week" :class="[getDayClass(day, month), { selected: isSelected(day, month) }]" @click="selectDate(day, month)">
{{ day }}
</td>
</tr>
</tbody>
</table>
</div>
`,
data() {
return {
days: ['S', 'M', 'T', 'W', 'T', 'F', 'S']
};
},
methods: {
getDayClass(day, month) {
if (!day) return '';
const date = new Date(month.year, month.index, day).toISOString().split('T')[0];
const availability = this.availability.find(a => a.date === date);
return availability ? availability.status : '';
},
isSelected(day, month) {
if (!day) return false;
const date = new Date(month.year, month.index, day).toISOString().split('T')[0];
return this.$parent.selectedDate === date;
},
selectDate(day, month) {
if (!day) return;
const date = new Date(month.year, month.index, day).toISOString().split('T')[0];
this.$emit('date-selected', date);
}
}
});

new Vue({
el: '#app',
data: {
months: [],
availability: [],
selectedDate: null
},
created() {
this.fetchAvailability();
this.generateCalendar();
},
methods: {
async fetchAvailability() {
try {
const response = await axios.get(ajaxurl+'?action=saksh_holidays_db');
this.availability = response.data;
} catch (error) {
console.error('Error fetching availability:', error);
}
},
generateCalendar() {
const today = new Date();
for (let i = 0; i < 12; i++) {
const date = new Date(today.getFullYear(), today.getMonth() + i, 1);
const month = {
name: date.toLocaleString('default', { month: 'long' }),
year: date.getFullYear(),
index: date.getMonth(),
weeks: this.generateMonth(date)
};
this.months.push(month);
}
},
generateMonth(date) {
const firstDay = date.getDay();
const lastDate = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
let week = new Array(firstDay).fill('');
const weeks = [];
for (let day = 1; day <= lastDate; day++) {
week.push(day);
if (week.length === 7) {
weeks.push(week);
week = [];
}
}
if (week.length) {
weeks.push(week);
}
return weeks;
},
selectDate(date) {
this.selectedDate = date;
},
async markDate(status) {
if (!this.selectedDate) return;
try {
 

const response = await axios.post(ajaxurl+'?action=saksh_update_holidays_db', new URLSearchParams({
date: this.selectedDate,
status: status
}));
if (response.data.status) {
this.fetchAvailability();
this.selectedDate = null;
} else {
alert('Error updating status: ' + response.data.error);
}
} catch (error) {
console.error('Error updating status:', error);
}
}
}
});
</script> 