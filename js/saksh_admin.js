 


Vue.component('table-component', {
data: function() {
return {
days: [],
times: {},
ampm:"",id:"",
newStartTime: '',
newEndTime: '',
selectedDay: ''
}
},
created: async function() {
await this.fetchDays();
await this.fetchTimes();
},
methods: {
    
    
    
    
async fetchDays() {
try {
const response = await axios.get( ajaxurl+'?action=saksh_time_slots_days');
this.days = response.data;


console.log(response.data);
} catch (error) {
console.error('Error fetching days:', error);
}
},




async fetchTimes() {
for (const day of this.days) {
try {
const response = await axios.post(ajaxurl+'?action=saksh_get_time_slots', { day: day });
this.$set(this.times, day, response.data);
} catch (error) {
console.error(`Error fetching times for ${day}:`, error);
}
}
},


isWeekend: function(day) {
return day === 'Saturday' || day === 'Sunday';
},






async addTimeSlot() {
if (this.newStartTime && this.newEndTime && this.selectedDay) {
try {
const response = await axios.post(ajaxurl+'?action=saksh_create_new_time_slot', {
day: this.selectedDay,
startTime: this.newStartTime,
endTime: this.newEndTime
});
if (response.data.success) {
if (!this.times[this.selectedDay]) {
this.$set(this.times, this.selectedDay, []);
}
this.times[this.selectedDay].push({
startTime: this.newStartTime,
endTime: this.newEndTime
});
this.newStartTime = '';
this.newEndTime = '';
this.selectedDay = '';
}
} catch (error) {
console.error('Error adding time slot:', error);
}
}
},






async deleteTimeSlot(day, time) {
try {
const response = await axios.post(ajaxurl+'?action=saksh_delete_time_slot', {
 
id: time.id,
 
});


if (response.data.success) {
    
    
await this.fetchTimes();


const index = this.times[day].indexOftime;
if (index > -1) {
this.times[day].splice(index, 1);
}


}
} catch (error) {
console.error('Error deleting time slot:', error);
}
}
},
template: `
<div>
<table class="table table-bordered">
<thead class="thead-dark">
<tr>
<th v-for="day in days">{{ day }}</th>
</tr>
</thead>
<tbody>
<tr v-for="timeIndex in 16">
<td v-for="day in days">
<span v-if="times[day] && times[day][timeIndex]"> 
{{ times[day][timeIndex].start_time }} - {{ times[day][timeIndex].end_time }} {{ times[day][timeIndex].ampm }}  
<button class="btn btn-danger btn-sm ml-2" @click="deleteTimeSlot(day, times[day][timeIndex])"> <span class="dashicons dashicons-trash"></span></button>
</span>
</td>
</tr>
</tbody>
</table>
<div class="mt-4 col-3"> 

<h3 class="mb-4">Add Time Slot</h3>
<div class="form-group">
<label for="daySelect">Select Day</label>
<select id="daySelect" class="form-control" v-model="selectedDay">
<option v-for="day in days" :value="day">{{ day }}</option>
</select>
</div>
<div class="form-group">
<label for="startTime">Start Time</label>
<input type="time" id="startTime" class="form-control" v-model="newStartTime">
</div>
<div class="form-group">
<label for="endTime">End Time</label>
<input type="time" id="endTime" class="form-control" v-model="newEndTime">
</div>
<div class="form-group">
<label for="ampmSelect">AM/PM</label>
<select id="ampmSelect" class="form-control" v-model="ampm">
<option value="am">AM</option>
<option value="pm">PM</option>
</select>
</div>
<button class="btn btn-primary" @click="addTimeSlot">Add</button>
</div>
`
});

new Vue({
el: '#app'
});






























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
el: '#holiday_app',
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