<template>
    <div>
        <div class="row mb-3">
            <div class="col-auto mr-auto align-self-end">
                <h4>{{ monthTitle }}</h4>
            </div>
            <div class="col text-right">
                <button
                    @click="moveDateBackwards()"
                    class="btn btn-dark"
                >
                    <i class="fa fa-arrow-left"></i>
                </button>
                <button
                    @click="showToday()"
                    class="btn btn-dark"
                >
                    Today
                </button>
                <button
                    @click="moveDateForwards()"
                    class="btn btn-dark"
                >
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>
        </div>
        <div class="card-deck">

            <calendar-entry
                v-for="entry in calendarEntries"
                :key="entry.date"
                :initial-calendar-entry="entry"

            ></calendar-entry>




        </div>
    </div>
</template>

<script>
    export default {
        components:{
            calendarEntry: require('./CalendarEntry.vue')
        },
        data(){
            return {
                date: moment().startOf('isoWeek').format('YYYY-MM-DD'),
                calendarEntries: []
            }
        },
        computed:{
            monthTitle(){
                return moment(this.date).format('MMMM YYYY');
            }
        },
        mounted() {
            this.loadCalendarEntries()
        },
        methods:{
            loadCalendarEntries(){
                axios.get('/api/calendar/',{
                    params: {
                        'start_date': this.date
                    }
                })
                .then(response => {
                    this.calendarEntries = response.data.data
                })
            },
            moveDateBackwards(){
                this.date = moment(this.date).subtract(7, 'days').format('YYYY-MM-DD')
                this.loadCalendarEntries()
            },
            moveDateForwards(){
                this.date = moment(this.date).add(7, 'days').format('YYYY-MM-DD')
                this.loadCalendarEntries()
            },
            showToday(){
                this.date = moment().startOf('isoWeek').format('YYYY-MM-DD')
                this.loadCalendarEntries()
            },
        }
    }
</script>

<style scoped>
    .week-row {
        margin-top: 20px;
        display: flex;
        justify-content: space-around;
    }
</style>
