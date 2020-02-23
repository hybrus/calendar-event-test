<template>
    <div class="container">

        <div class="row">
            <h3>Calendar</h3>
        </div>
    
        <div id="snackbar">{{alertMessage}}</div>

        <div class="row justify-content-center">
            <div class="col-md-4">
                <form @submit.prevent>
                    <div class="form-group">
                        <label for="event_name">Event Name</label>
                        <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name" required/>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">From</label>
                                <input type="date" id="start_date" class="form-control" v-model="newEvent.start_date"  required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">To</label>
                                <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container"> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.sun"> Sun  </label> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.mon"> Mon  </label> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.tue"> Tue  </label> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.wed"> Wed  </label> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.thu"> Thu  </label> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.fri"> Fri  </label> 
                            <label class="checkbox-inline"><input type="checkbox" :value="true" :unchecked-value="false" v-model="newEvent.weekdays.sat"> Sat  </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <button class="btn btn-primary" @click="addNewEvent">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-8">
                <FullCalendar  :plugins="calendarPlugins" :events="events" defaultView="listMonth"/>
            </div>

        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import listPlugin from '@fullcalendar/list'
export default {
    components: {
        FullCalendar
    },
    data: function() {
        return {
            calendarPlugins: [listPlugin],
            events: [],
            preEvents: {},
            newEvent: {
                event_name: "",
                start_date: "",
                end_date: "",
                weekdays:{
                    sun: false,
                    mon: false,
                    tue: false,
                    wed: false,
                    thu: false,
                    fri: false,
                    sat: false,
                }
            },
            alertMessage: ""
        };
    },
    created: function() {
        this.getEvents();
    },
    methods: {
        
        addNewEvent() {
            axios.post("/api/calendar-events",{
                ...this.newEvent})
                .then(resp =>
                    this.preEvents = resp.data.data,
                    this.alertMessage="Success",
                    this.showSnackbar())
                .catch(err =>
                    this.alertMessage="Failed",
                    this.showSnackbar());
        },
        getEvents: function() {
            axios.get("/api/calendar-events")
                .then(resp =>
                    this.preEvents = resp.data.data)
                .catch(err =>
                    console.log(err.response.data));
        },
        showSnackbar: function(){
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    },
    watch:{

        //parse events from axios
        preEvents: function(v) {
            this.events=[];
            for(let items in v){
                let start = new Date(v[items].start);
                let end = new Date(v[items].end);
                for (let dt=start; dt <= end; dt.setDate(dt.getDate() + 1)) {
                    for(let element in v[items].weekdays){
                        if(v[items].weekdays[element] && dt.getDay().toString() == element){
                            this.events.push({
                                title: v[items].title,
                                start:new Date(dt),
                                end: new Date(dt)
                            });
                        }
                    }
                }
            }
        }
    }
};
</script>
