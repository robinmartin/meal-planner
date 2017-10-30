<template>
    <div class="text-dark">
        <bs-modal-popup :show.sync="showModal">
            <div class="row">
                <div class="col-md-8">
                    <h3>{{ meal.name}}</h3>
                    <div class="form-group">
                        <textarea class="form-control" placeholder="Meal Notes (todo)..."></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Repeats <i class="fa fa-retweet"></i></h4>
                    <div class="form-group">
                        <select
                            v-model="ruleFrequency"
                            @change="mealRuleChanged"
                            class="form-control"
                        >
                            <option :value="null">Never</option>
                            <option value="7">Every Week</option>
                            <option value="14">Every Two Weeks</option>
                        </select>
                    </div>

                </div>
            </div>
        </bs-modal-popup>
        <div
            @click="showModal = true"
            class="meal-card"
            style="cursor: pointer !important;"
        >
            <span>{{ meal.name}}</span>
            <span v-if="showRepeatEventIcon"><i class="fa fa-retweet"></i></span>
            <span
                v-if="! isPast"
                @click.stop="confirmRemoveMealFromDate(meal.id)"
                class="pull-right"
            ><i class="fa fa-remove"></i></span>
        </div>
    </div>
</template>

<script>

    export default {
        components: {
            bsModalPopup: require('./BsModalPopup.vue')
        },
        props:{
            meal: Object,
            calendarEntry: Object,
            isPast: Boolean
        },
        data(){
            return {
                showModal: false,
                ruleFrequency: this.meal.rule ? this.meal.rule.repeat_frequency : null,
            }
        },
        computed:{
            isRepeatEvent(){
                return this.meal.rule ? true : false;
            },
            showRepeatEventIcon(){
                if (this.isRepeatEvent && this.meal.rule.end_date != this.calendarEntry.date){
                    return true;
                }
                return false;
            }
        },
        methods:{
            confirmRemoveMealFromDate(mealId){
                if(this.meal.rule){
                    swal({
                        title: "You're deleting a repeating meal",
                        text: "Do you wish to delete just this meal or all future repeating meals?",
                        icon: "warning",
                        buttons: {
                            cancel: true,
                            justThisMeal: {
                                text: "Just this meal",
                                value: "one",
                            },
                            allMeals: {
                                text: "All future meals",
                                value: "all",
                            },
                        },
                    })
                        .then((value) => {
                            switch (value) {
                                case "one":
                                    this.removeMealFromDate(false)
                                    break;
                                case "all":
                                    this.removeMealFromDate(true)
                                    break;
                                default:
                                    return;
                            }
                        });
                }else{
                    this.removeMealFromDate(false)
                }
            },
            removeMealFromDate(allMeals){
                let params = {
                    rule_id: this.meal.rule ? this.meal.rule.id : null
                }
                if(allMeals){
                    params['delete_future_meals'] = true;
                }
                axios.delete('/api/calendar/' + this.calendarEntry.date + '/meals/' + this.meal.id,{
                    params: params

                })
                    .then(response => {
                        this.$emit('meal-removed')
                    })
            },
            mealRuleChanged(){
                if(this.meal.rule){ //If a rule is in place then update the existing rule before adding a new one
                    axios.patch('/api/rules/' + this.meal.rule.id, {
                        end_date: moment(this.calendarEntry.date).format('YYYY-MM-DD')
                    })
                        .then(response => {
                            if(this.ruleFrequency){
                                this.addRuleToMeal()
                            }else{
                                this.$emit('reload-meals')
                            }
                        })
                }else if(this.ruleFrequency){ //If no existing rule then just add the new one
                    this.addRuleToMeal()
                }
            },
            addRuleToMeal(){
                axios.post('/api/meals/' + this.meal.id + '/rules', {
                    repeat_frequency: this.ruleFrequency,
                    start_date: this.calendarEntry.date
                })
                    .then(response => {
                        this.$emit('reload-meals')
                    })
            }
        }
    }
</script>

<style scoped>
    .meal-card {
        margin-top: 10px;
        background: white;
        border-radius: 3px;
        padding: 10px;
    }
</style>