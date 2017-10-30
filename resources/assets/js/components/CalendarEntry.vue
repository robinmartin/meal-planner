<template>

        <div
            class="card m-1 mb-3 p-0"
            :class="{
                'bg-info text-light': ! isPast,
                'bg-secondary text-light': isPast
            }">

            <div class="card-body p-2">
                <h5 class="card-title text-center font-weight-bold text-nowrap">
                    <span :class="{'day-entry-today': isToday}">
                        {{titleDate}}
                    </span>
                </h5>



                <meal-card
                    v-for="meal in calendarEntry.meals"
                    :key="meal.id"
                    :meal="meal"
                    :calendar-entry="calendarEntry"
                    :is-past="isPast"
                    @reload-meals="loadCalendarEntry"
                    @meal-removed="loadCalendarEntry"
                ></meal-card>
                <add-meal
                    v-if="! isPast"
                    :meals="calendarEntry.meals"
                    :date="calendarEntry.date"
                    @reload-meals="loadCalendarEntry"
                ></add-meal>
            </div>






        </div>


</template>

<script>
    export default {
        components:{
            addMeal: require('./AddMeal.vue'),
            mealCard: require('./MealCard.vue')
        },
        props:{
            initialCalendarEntry: Object
        },
        data(){
            return {
                calendarEntry: this.initialCalendarEntry
            }
        },
        watch:{
            initialCalendarEntry(){
                this.calendarEntry = this.initialCalendarEntry
            },
        },
        computed:{
            titleDate(){
                return moment(this.calendarEntry.date).format('ddd DD')
            },
            isPast(){
                return moment(this.calendarEntry.date).isBefore(moment().startOf('day').format());
            },
            isToday(){
                return moment(this.calendarEntry.date).isSame(moment().startOf('day').format(), 'day');
            }
        },
        methods:{
            loadCalendarEntry(){
                axios.get('/api/calendar/' + this.calendarEntry.date )
                    .then(response => {
                        this.calendarEntry = response.data.data
                    })
            }
        }
    }
</script>

<style scoped>
    .day-entry-today {
        border-bottom: 3px solid #ffffff;
    }
</style>
